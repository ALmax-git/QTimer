<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExamsController extends Controller
{
    /**
     * List available exams for authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->sets) {
            return response()->json([
                'exams' => []
            ]);
        }

        $allowMock = $user->school->allow_mock;

        $exams = $user->sets
            ->flatMap(function ($set) use ($allowMock) {
                return $set->exams
                    ->where('is_visible', true)
                    ->when(!$allowMock, fn($q) => $q);
            })
            ->unique('id')
            ->values();

        return response()->json([
            'exams' => $exams->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'start_time' => Carbon::parse($exam->start_time)->timestamp,
                    'finish_time' => Carbon::parse($exam->finish_time)->timestamp,
                    'is_mock' => $exam->is_mock,
                ];
            })
        ]);
    }

    public function all_exams(Request $request)
    {
        $exams = Exam::where('is_visible', true)->get();
        return response()->json([
            'exams' => $exams->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'start_time' => Carbon::parse($exam->start_time)->timestamp,
                    'finish_time' => Carbon::parse($exam->finish_time)->timestamp,
                    'is_mock' => $exam->is_mock,
                ];
            })
        ]);
    }

    /**
     * Start or Resume Exam
     */
    public function start(Request $request, Exam $exam)
    {
        $user = $request->user();

        if (!$user->school->server_is_up) {
            return response()->json([
                'message' => 'Exam server is currently down.'
            ], 403);
        }

        $now = now()->timestamp;
        $examStart = Carbon::parse($exam->start_time)->timestamp;
        $examFinish = Carbon::parse($exam->finish_time)->timestamp;

        if (!$exam->is_mock && $now < $examStart) {
            return response()->json([
                'message' => 'Exam has not started yet.',
                'start_time' => $examStart
            ], 403);
        }

        if (!$exam->is_mock && $now > $examFinish) {
            return response()->json([
                'message' => 'Exam has finished.'
            ], 403);
        }

        $result = Result::firstOrCreate(
            [
                'user_id' => $user->id,
                'exam_id' => $exam->id
            ],
            [
                'status' => 'progress',
                'total_question_count' => 0,
                'attempt_question_count' => 0,
                'result' => 0,
                'started_at' => $now,
                'last_seen_at' => $now
            ]
        );

        $remainingTime = $exam->is_mock
            ? ($examFinish - $examStart)
            : ($examFinish - $now);

        // Load exam with objective questions only
        $exam->load(['subjects.questions.options']);

        $subjects = $exam->subjects->map(function ($subject) {
            return [
                'id' => $subject->id,
                'title' => $subject->title,
                'questions' => $subject->questions->map(function ($question) {
                    return [
                        'id' => $question->id,
                        'text' => $question->text,
                        'image' => $question->image,
                        'options' => $question->options->map(function ($option) {
                            return [
                                'id' => $option->id,
                                'option' => $option->option
                            ];
                        })->shuffle()->values()
                    ];
                })->shuffle()->values()
            ];
        })->shuffle()->values();

        $attempted = QuestionAnswer::where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->pluck('question_id');

        return response()->json([
            'exam_id' => $exam->id,
            'title' => $exam->title,
            'server_time' => $now,
            'remaining_time' => $remainingTime,
            'result_id' => $result->id,
            'status' => $result->status,
            'subjects' => $subjects,
            'attempted' => $attempted
        ]);
    }

    /**
     * Lightweight heartbeat
     */
    public function heartbeat(Request $request, Exam $exam)
    {
        $user = auth()->user();
        $now = now()->timestamp;
        $examStart = Carbon::parse($exam->start_time)->timestamp;
        $examFinish = Carbon::parse($exam->finish_time)->timestamp;


        $remainingTime = $exam->is_mock
            ? ($examFinish - $examStart)
            : ($examFinish - $now);
        if (Result::where('user_id', Auth::id())->where('exam_id', $exam->id)->first()) {
            $result = Result::where('user_id', Auth::id())->where('exam_id', $exam->id)->first();
            // user already start his/her exam 
            $remainingTime = $examFinish - $now;
        } else {
            $result = Result::create([
                'user_id' => Auth::id(),
                'exam_id' => $exam->id,
                'total_question_count' => 0,
                'attempt_question_count' => 0,
                'status' => 'progress',
                'result' => 0,
                'time_spent' => null,
                'started_at' => now()->timestamp,
                'last_seen_at' => now()->timestamp,
                'submitted_at' => null,
            ]);
        }

        $result->update([
            'last_seen_at' => now()->timestamp
        ]);

        return response()->json([
            'server_time' => now()->timestamp,
            'remaining_time' => max(0, $remainingTime),
            'server_is_live' => $user->school->server_is_up
        ]);
    }

    /**
     * Submit exam
     */
    public function submit(Request $request, Exam $exam)
    {
        $user = $request->user();

        if (!$user->school->server_is_up) {
            return response()->json([
                'message' => 'Exam server is down.'
            ], 403);
        }

        $result = Result::where('id', $request->result_id)
            ->where('user_id', $user->id)
            ->where('exam_id', $exam->id)
            ->where('status', 'progress')
            ->firstOrFail();

        return DB::transaction(function () use ($request, $exam, $result, $user) {

            $correct = 0;
            $attempt = 0;
            $total = 0;

            foreach ($request->answers as $answer) {

                $question = Question::with('options')
                    ->where('id', $answer['question_id'])
                    ->first();

                if (!$question) continue;

                $total++;

                $option = $question->options
                    ->where('id', $answer['option_id'])
                    ->first();

                if ($option) {
                    $attempt++;

                    if ($option->is_correct) {
                        $correct++;
                    }

                    QuestionAnswer::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'exam_id' => $exam->id,
                            'question_id' => $question->id
                        ],
                        [
                            'question_option_id' => $option->id,
                            'is_correct' => $option->is_correct
                        ]
                    );
                }
            }

            $result->update([
                'status' => 'submitted',
                'total_question_count' => $total,
                'attempt_question_count' => $attempt,
                'result' => $correct,
                'submitted_at' => now()->timestamp,
                'last_seen_at' => now()->timestamp
            ]);

            $total = 0;
            foreach ($exam->subjects as $subject) {
                $total += $subject->questions()->where('type', 'objective')->where('status', 'active')->count();
            }
            return response()->json([
                'message' => 'Exam submitted successfully.',
                'score' => $correct,
                'total' => $total
            ]);
        });
    }
    private function grade($score)
    {
        if ($score >= 90) return 'A (Excellent)';
        if ($score >= 75) return 'B (Very Good)';
        if ($score >= 60) return 'C (Good)';
        if ($score >= 50) return 'D (Satisfactory)';
        return 'F (Fail)';
    }
    public function full(Exam $exam)
    {
        $exam->load(['subjects.questions.answers', 'results.user']);

        $studentsResults = [];
        $rankingCollection = [];

        foreach ($exam->results as $result) {

            $student = $result->user;

            $subjectsData = $exam->subjects->map(function ($subject) use ($student) {

                $total_questions = $subject->questions->count();

                $total_attempts = $subject->questions
                    ->sum(
                        fn($q) =>
                        $q->answers->where('user_id', $student->id)->count()
                    );

                $total_score = $subject->questions
                    ->sum(
                        fn($q) =>
                        $q->answers
                            ->where('user_id', $student->id)
                            ->where('is_correct', true)
                            ->count()
                    );

                $average_score = $total_questions > 0
                    ? round(($total_score / $total_questions) * 100, 2)
                    : 0;

                return [
                    'subject_id' => $subject->id,
                    'title' => $subject->title,
                    'total_questions' => $total_questions,
                    'attempted' => $total_attempts,
                    'correct' => $total_score,
                    'average' => $average_score,
                    'grade' => $this->grade($average_score),
                ];
            })->toArray();


            $totalQuestions = collect($subjectsData)->sum('total_questions');
            $totalAttempted = collect($subjectsData)->sum('attempted');
            $totalCorrect = collect($subjectsData)->sum('correct');

            $overallAverage = $totalAttempted > 0
                ? round(($totalCorrect / $totalAttempted) * 100, 2)
                : 0;

            $rankingCollection[] = [
                'student_id' => $student->id,
                'score' => $overallAverage
            ];

            $studentsResults[] = [
                'student_id' => $student->id,
                'name' => $student->name,
                'subjects' => $subjectsData,
                'summary' => [
                    'total_questions' => $totalQuestions,
                    'attempted' => $totalAttempted,
                    'correct' => $totalCorrect,
                    'average' => $overallAverage,
                    'grade' => $this->grade($overallAverage),
                ]
            ];
        }

        // Sort ranking
        usort($rankingCollection, fn($a, $b) => $b['score'] <=> $a['score']);

        foreach ($studentsResults as &$studentResult) {
            $position = collect($rankingCollection)
                ->search(fn($r) => $r['student_id'] == $studentResult['student_id']) + 1;

            $studentResult['summary']['position'] = $position;
        }

        $examAverage = collect($rankingCollection)->avg('score');

        return response()->json([
            'exam' => [
                'id' => $exam->id,
                'title' => $exam->title,
            ],
            'exam_stats' => [
                'total_students' => count($studentsResults),
                'exam_average' => round($examAverage, 2),
                'highest_score' => collect($rankingCollection)->max('score'),
                'lowest_score' => collect($rankingCollection)->min('score'),
            ],
            'students' => $studentsResults
        ]);
    }

    public function results(Exam $exam)
    {
        $exam->load('subjects.questions');

        $results = Result::with('user')
            ->where('exam_id', $exam->id)
            ->orderByDesc('result')
            ->get();

        $totalStudents = $results->count();

        if ($totalStudents === 0) {
            return response()->json([
                'exam' => $exam,
                'stats' => [],
                'leaderboard' => [],
                'subject_analytics' => []
            ]);
        }

        // Leaderboard
        $leaderboard = $results->values()->map(function ($result, $index) {
            return [
                'position' => $index + 1,
                'student_id' => $result->user->id,
                'name' => $result->user->name,
                'score' => $result->result,
                'grade' => $this->grade($result->result),
            ];
        });

        // Exam statistics
        $examAverage = round($results->avg('result'), 2);
        $highest = $results->max('result');
        $lowest = $results->min('result');

        // Subject analytics
        $subjectAnalytics = [];

        foreach ($exam->subjects as $subject) {

            $subjectTotalScore = 0;
            $subjectTotalStudents = 0;

            foreach ($results as $result) {

                $correct = $subject->questions->sum(function ($q) use ($result) {
                    return $q->answers()
                        ->where('user_id', $result->user_id)
                        ->where('is_correct', true)
                        ->count();
                });

                $totalQuestions = $subject->questions->count();

                if ($totalQuestions > 0) {
                    $subjectTotalScore += ($correct / $totalQuestions) * 100;
                    $subjectTotalStudents++;
                }
            }

            $average = $subjectTotalStudents > 0
                ? round($subjectTotalScore / $subjectTotalStudents, 2)
                : 0;

            $subjectAnalytics[] = [
                'subject_id' => $subject->id,
                'title' => $subject->title,
                'average_score' => $average,
            ];
        }

        return response()->json([
            'exam' => [
                'id' => $exam->id,
                'title' => $exam->title
            ],
            'stats' => [
                'total_students' => $totalStudents,
                'exam_average' => $examAverage,
                'highest_score' => $highest,
                'lowest_score' => $lowest,
            ],
            'leaderboard' => $leaderboard,
            'subject_analytics' => $subjectAnalytics
        ]);
    }
}
