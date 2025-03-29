<?php

namespace App\Livewire\Tab;

use App\Models\Subject as ModelsSubject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use App\Models\Question;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Subject extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $main_model = false, $questions_upload = false, $new_question_model = false;
    public $questions_file, $subject, $subject_id;
    public $staff, $currentSubject, $question, $cormfirm_delete = false;
    public $new_question = false, $image, $new_question_text, $new_question_more_info_link, $new_question_answer_explanation, $new_question_code_snippet;
    // public $school_name;
    public array $questionOptions = [];
    public function create_new_obj_question()
    {
        DB::beginTransaction();
        // $this->validate([
        //     'question.question_text' => [
        //         'string',
        //         'required',
        //     ],
        //     'question.code_snippet' => [
        //         'string',
        //         'nullable',
        //     ],
        //     'question.answer_explanation' => [
        //         'string',
        //         'nullable',
        //     ],
        //     'question.more_info_link' => [
        //         'string',
        //         'nullable',
        //     ],
        //     'questionOptions' => [
        //         'required'
        //     ],
        //     'questionOptions.*.option' => [
        //         'required'
        //     ],
        // ]);
        $this->question = new Question();
        $file_name = '';
        if ($this->image) {
            $file_name = $this->image->store('obj', 'public') ?? '';
        }
        $this->question->text = $this->new_question_text;
        $this->question->code_snippet = $this->new_question_code_snippet;
        $this->question->answer_explanation = $this->new_question_answer_explanation;
        $this->question->more_info_link = $this->new_question_more_info_link;
        $this->question->image = $file_name ?? '';
        $this->question->subject_id = $this->subject->id;
        $this->question->save();

        foreach ($this->questionOptions as $option) {
            $this->question->options()->create([
                'option' => $option['option'],
                'is_correct' => $option['is_correct']
            ]);
        }
        DB::commit();  // Commit transaction if everything is successful
        $this->alert('success', 'Question created successfully!', [
            'position' => 'top-end',
            'toast' => true,
            'timer' => 5000,
        ]);
        $this->new_question = false;
        // $this->new_model = false;
        $this->mount();
    }

    public function addQuestionsOption()
    {
        $this->questionOptions[] = [
            'option' => '',
            'is_correct' => false
        ];
    }

    public function removeQuestionsOption($index)
    {
        unset($this->questionOptions[$index]);
        $this->questionOptions = array_values(($this->questionOptions));
    }

    protected function rules(): array
    {
        return [
            'question.question_text' => [
                'string',
                'required',
            ],
            'question.code_snippet' => [
                'string',
                'nullable',
            ],
            'question.answer_explanation' => [
                'string',
                'nullable',
            ],
            'question.more_info_link' => [
                'string',
                'nullable',
            ],
            'questionOptions' => [
                'required'
            ],
            'questionOptions.*.option' => [
                'required'
            ],
        ];
    }

    public function new_objective()
    {
        $this->main_model = true;
        $this->questions_upload = false;
        $this->new_question_model = true;
        $this->new_question = false;
    }
    public function create_question()
    {
        $this->new_question = true;
        // dd($this);
        $this->subject = ModelsSubject::find($this->currentSubject->id);
    }
    // public function create_new_question()
    // {
    //     $this->main_model = true;
    //     $this->questions_upload = false;
    //     $this->new_question_model = true;
    // }
    public function delete_question($id)
    {
        $this->question = Question::find($id);
        $this->cormfirm_delete = true;
    }
    public function cancel_delete()
    {
        $this->question = null;
        $this->cormfirm_delete = false;
    }
    public function cormfirm_delete_question()
    {
        $this->question->delete();
        $this->question = null;
        $this->cormfirm_delete = false;
    }
    public function confirm_upload()
    {

        $this->validate([
            'questions_file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        try {
            $import = new QuestionsImport($this->currentSubject->id);
            Excel::import($import, $this->questions_file->getRealPath());

            $errors = $import->getErrors();

            if (!empty($errors)) {
                // dd($errors, $errors[0]['error'], $errors[0]['row_data']);
                $this->alert('error', 'Some questions failed to import!' . $errors[0]['error'], [
                    'position' => 'center',
                    'toast' => false,
                    'timer' => 5000,
                ]);
            } else {
                $this->alert('success', 'Questions imported successfully!', [
                    'position' => 'top-end',
                    'toast' => true,
                    'timer' => 5000,
                ]);
            }
        } catch (\Exception $e) {
            $this->alert('error', 'File import failed: ' . $e->getMessage(), [
                'position' => 'top-end',
                'toast' => true,
                'timer' => 5000,
            ]);
            $this->cancel_upload();
        }
        $this->cancel_upload();
    }
    public function upload_questions($id)
    {
        $this->main_model = true;
        $this->questions_upload = true;
        $this->subject = ModelsSubject::find($id);
        $this->subject_id = $this->subject->id;
        $this->questions_file = null;
    }
    public function cancel_upload()
    {
        $this->questions_upload = false;
        $this->main_model = false;
        $this->subject = null;
        $this->questions_file = null;
    }
    public function change_subject($id)
    {
        $this->currentSubject = ModelsSubject::find(read($id));
    }
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->staff = User::find(Auth::user()->id);
        $this->currentSubject = $this->staff->subjects->first();
        if (!$this->currentSubject) {
            $this->main_model = true;
        }
    }
    public function render()
    {
        return view('livewire.tab.subject');
    }
}
