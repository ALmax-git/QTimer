<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Exam;
use App\Models\Result;
use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

// use Illuminate\Container\Attributes\Auth;

class StudentTranscriptModal extends Component
{
    use WithPagination, LivewireAlert;
    public $student_id;
    public $student;
    // public $students;
    public $school_name;
    public $examCount;
    public $subjectCount;
    public $examDetails = [];
    public $search;

    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        // $this->
        // dd($this->students);
    }
    public function dismiss()
    {
        $this->student_id = null;
        $this->student = null;
    }
    public function loadTranscript($student_id)
    {
        $this->student_id = $student_id;
        $this->student = User::with('school')->find($student_id);

        if (!$this->student) {
            return;
        }

        $this->school_name = $this->student->school->name ?? 'N/A';

        // Get all exams the student participated in
        $exams = Exam::whereHas('results', function ($query) {
            $query->where('user_id', $this->student_id);
        })->with('subjects')->get();
        // dd($exams);
        $this->examCount = $exams->count();
        $this->subjectCount = $exams->pluck('subjects')->flatten()->unique('id')->count();

        $this->examDetails = $exams->map(function ($exam) {
            $total_questions = $exam->subjects->sum(fn($subject) => $subject->questions->count());
            $result = Result::where('user_id', $this->student_id)->where('exam_id', $exam->id)->first();
            $total_score = $result ? $result->score : 0;
            $average_score = $total_questions > 0 ? round(($total_score / $total_questions) * 100, 2) : 0;
            $remark = $this->getGrade($average_score);

            return [
                'title' => $exam->title,
                'total_questions' => $total_questions,
                'total_score' => $total_score,
                'average_score' => $average_score,
                'remark' => $remark,
                'subjects' => $exam->subjects->map(function ($subject) {
                    $total_questions = $subject->questions->count();
                    $total_attempts = $subject->questions->sum(fn($q) => $q->answers->where('user_id', $this->student_id)->count());
                    $total_score = $subject->questions->sum(fn($q) => $q->answers->where('user_id', $this->student_id)->where('is_correct', true)->count());
                    $average_score = $total_questions > 0 ? round(($total_score / $total_questions) * 100, 2) : 0;
                    $remark = $this->getGrade($average_score);

                    return [
                        'title' => $subject->title,
                        'total_questions' => $total_questions,
                        'total_attempts' => $total_attempts,
                        'total_score' => $total_score,
                        'average_score' => $average_score,
                        'remark' => $remark,
                    ];
                }),
            ];
        })->toArray();
        // dd($this->examDetails);
    }

    private function getGrade($score)
    {
        if ($score >= 90) return 'A (Excellent)';
        if ($score >= 75) return 'B (Very Good)';
        if ($score >= 60) return 'C (Good)';
        if ($score >= 50) return 'D (Satisfactory)';
        return 'F (Fail)';
    }

    public function render()
    {
        $students = Auth::user()->school->students()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('id_number', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);
        return view(
            'livewire.student-transcript-modal',
            [
                'students' => $students,

            ]
        );
    }
}
