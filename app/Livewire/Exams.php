<?php

namespace App\Livewire;

use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionAnswer;
use App\Models\QuestionOption;
use App\Models\Result;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Exams extends Component
{
    use LivewireAlert;

    public $exams = [];
    public ?Exam $exam = null;
    public bool $start = false;
    public bool $can_start = false;
    public string $message = '';

    public int $remainingTime = 0;
    public int $minutes_left = 0;
    public int $seconds_left = 0;

    public array $currentSubject = [];
    public array $currentQuestion = [];
    public int $currentQuestionIndex = 0;
    public int $currentSubjectIndex = 0;
    public array $attemptedQuestions = [];

    public array $subjects = [];
    public array $questions = [];
    public array $options = [];
    public array $questions_bank = [];

    public int $startTimeSeconds = 0;
    public int $result = 0, $score = 0;
    public ?int $selected_option = null;
    public bool $can_submit = false;
    public bool $finished = false;
    public bool $can_review = false;
    public bool $server_is_live = false;

    public int $attempt_count = 0;
    public int $question_count = 0;

    public function next()
    {
        if ($this->currentQuestionIndex < count($this->questions) - 1) {
            $this->currentQuestionIndex++;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
            $this->check_option();
        } else {
            $this->next_subject();
        }
    }


    public function previous()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
            $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
            $this->check_option();
        } else {
            $this->prev_subject();
        }
    }


    public function next_subject()
    {
        if ($this->currentSubjectIndex < count($this->subjects) - 1) {
            $this->currentSubjectIndex++;
            $this->set_current_subject();
            $this->alert('success', "Switched to " . $this->currentSubject['title'], ['toast' => false, 'position' => 'center']);
            $this->check_option();
        } else {
            $this->submit();
        }
    }

    public function prev_subject()
    {
        if ($this->currentSubjectIndex > 0) {
            $this->currentSubjectIndex--;
            $this->set_current_subject();
            $this->alert('success', "Switched to " . $this->currentSubject['title'], ['toast' => false, 'position' => 'center']);
            $this->check_option();
        }
    }

    private function set_current_subject()
    {
        $this->currentSubject = $this->subjects[$this->currentSubjectIndex]; // Keep as object

        // Ensure questions are properly handled
        $this->questions = $this->questions_bank[$this->currentSubjectIndex]; // Convert questions to an array

        // Ensure the first question index exists
        $this->currentQuestionIndex = array_key_first($this->questions);

        // Set current question safely
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex] ?? null;
        // dd($this);
        $this->check_option();
    }


    public function start_x($examId)
    {
        $this->exam = Exam::with(['subjects.questions'])->findOrFail(read($examId));
        $this->startTimeSeconds = now()->timestamp;

        $exam_start_time = Carbon::parse($this->exam->start_time)->timestamp;
        $exam_finish_time = Carbon::parse($this->exam->finish_time)->timestamp;

        if (!$this->exam->is_mock && $this->startTimeSeconds < $exam_start_time) {
            $this->alert('info', 'The exam has not started yet. Please wait until ' . $this->exam->start_time, ['toast' => false, 'position' => 'center']);
            return;
        }

        if (!$this->exam->is_mock && $this->startTimeSeconds > $exam_finish_time) {
            $this->alert('info', 'Sorry! The exam has finished.', ['toast' => false, 'position' => 'center']);
            return;
        }

        $this->can_start = true;
        $this->remainingTime = $this->exam->is_mock ? ($exam_finish_time - $exam_start_time) : ($exam_finish_time - $this->exam_start_time);

        $this->exam->subjects = $this->exam->subjects->shuffle();
        foreach ($this->exam->subjects as $subject) {
            $subject->questions = $subject->questions->shuffle();
        }

        $this->subjects = $this->exam->subjects->toArray();


        foreach ($this->subjects as $subject) {
            // Ensure questions exist
            if (!isset($subject['questions']) || !is_array($subject['questions'])) {
                continue; // Skip if no questions
            }

            $shuffledQuestions = array_map(function ($question) {
                // Fetch options manually from the database
                $options = QuestionOption::where('question_id', $question['id'])->get()->toArray();

                // Shuffle options if available
                shuffle($options);

                // Assign options manually
                $question['options'] = $options;

                return $question;
            }, $subject['questions']);

            shuffle($shuffledQuestions); // Shuffle questions

            // Assign to questions bank with preserved keys
            $this->questions_bank[] = $shuffledQuestions;
        }


        $this->set_current_subject();
        $this->start = true;

        $this->attemptedQuestions = QuestionAnswer::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->pluck('question_id')->toArray();
    }

    public function change_subject($id)
    {
        $id = read($id);

        $this->currentSubjectIndex = (int)$id;
        $this->set_current_subject();
        $this->alert('success', "Switched to " . $this->currentSubject['title'], ['toast' => false, 'position' => 'center']);
        $this->check_option();
    }

    public function jump_question($id)
    {
        $id = read($id);

        $this->currentQuestionIndex = (int)$id;
        $this->currentQuestion = $this->questions[$this->currentQuestionIndex];
        $this->check_option();
        $answer = QuestionAnswer::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->where('question_id', $this->currentQuestion['id'])->first();
        $this->selected_option = $answer?->option_id;
        $q_and_a = QuestionAnswer::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->pluck('question_id');

        $this->attemptedQuestions = $q_and_a->toArray();
    }


    public function answer($id)
    {
        $id = read($id);

        $option = (int)$id;
        // dd($option);
        $is_correct = QuestionOption::find($option)?->is_correct ? 1 : 0;
        $x = QuestionAnswer::updateOrCreate([
            'user_id' => Auth::user()->id,
            'exam_id' => $this->exam->id,
            'question_id' => $this->currentQuestion['id']
        ], [
            'option_id' => $option,
            'is_correct' => $is_correct,
        ]);

        $this->check_option();
    }

    public function check_option()
    {
        $answer = QuestionAnswer::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->where('question_id', $this->currentQuestion['id'])->first();
        $this->selected_option = $answer?->option_id;
        $q_and_a = QuestionAnswer::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->pluck('question_id');

        $this->attemptedQuestions = $q_and_a->toArray();
        \App\helpers\RequestTracker::track();
    }


    public function reveil()
    {
        $this->start = true;
        $this->can_review = true;
        $this->finished = false;
        \App\helpers\RequestTracker::track();
    }
    public function submit()
    {
        $result = 0;
        $this->question_count = 0;
        $this->start = false;
        $this->finished = true;

        foreach ($this->exam->subjects as $subject) {
            $this->question_count += $subject->questions->count();
        }

        if (Result::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->first()) {
            $Result = Result::where('user_id', Auth::id())->where('exam_id', $this->exam->id)->first();
        } else {
            $Result = Result::create([
                'user_id' => Auth::id(),
                'exam_id' => $this->exam->id,
                'question_count' => $this->question_count,
                'result' => 0,
                'time_spent' => now()->timestamp - $this->startTimeSeconds
            ]);
        }
        $question_answers = QuestionAnswer::where('user_id', Auth::user()->id)->where('exam_id', $this->exam->id)->get();

        $this->attempt_count = 0;
        foreach ($question_answers as $answer) {
            ++$this->attempt_count;
            if ($answer->is_correct == true) {
                ++$result;
            }
        }
        $this->score = $result;

        $Result->update([
            'result' => $result,
        ]);
        \App\helpers\RequestTracker::track();
    }
    // Handle the countdown logic for the remaining time
    public function updateCountdown()
    {
        if ($this->remainingTime > 0) {
            $this->remainingTime--;
            $this->minutes_left = floor($this->remainingTime / 60);
            $this->seconds_left = $this->remainingTime % 60;
        } else {
            // dd($this);
            $this->submit(); // Auto-submit when time's up
        }
    }
    /**
     * Livewire mount method: Initializes the component.
     */
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $user = Auth::user();

        if (!$user || !$user->sets) {
            $this->exams = collect();
            return;
        }

        $allowMock = $user->school->allow_mock;

        // Fetch exams based on mock exam allowance
        $this->exams = $user->sets->flatMap(function ($set) use ($allowMock) {
            return $allowMock ? $set->exams->where('is_visible', true) : $set->exams->where('is_visible', true);
        });
    }

    /**
     * Checks if the school server is live.
     */
    public function live_check()
    {

        $this->server_is_live = Auth::user()->school->server_is_up;
        \App\helpers\RequestTracker::track();
    }
    public function render()
    {
        return view('livewire.exams');
    }
}
