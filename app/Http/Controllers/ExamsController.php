<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\Result;
use App\Models\Question;
use App\Models\QuestionAnswer;
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
}
