<?php

namespace App\Livewire\Tab;

use App\Models\Exam;
use Livewire\Component;

class Exams extends Component
{
    public $cormfirm_delete = false;
    public $exams, $exam;
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->load_exams();
    }

    public function load_exams()
    {
        $this->exams = Exam::all();
    }

    public function delete_exam($id)
    {
        $this->exam = Exam::find($id);
        $this->cormfirm_delete = true;
    }
    public function cormfirm_delete_exam()
    {
        $exam = Exam::where('id', $this->exam->id)->first();
        if (!$exam) {
            $this->alert('error', 'Exam not found');
            return;
        }
        // dd($staff);
        $this->exam = null;
        $exam->delete();
        $this->cormfirm_delete = false;
        $this->load_exams();
    }

    public function cancel_delete()
    {
        $this->cormfirm_delete = false;
    }
    public function render()
    {
        return view('livewire.tab.exams');
    }
}
