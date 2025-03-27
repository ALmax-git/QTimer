<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;

use App\Exports\ExamResultsExport;
use App\Models\School as ModelsSchool;
use App\Models\Session;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use App\Imports\QuestionsImport;
use App\Imports\StudentImport;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\Question;
use App\Models\Set;
use App\Models\SetExam;
use App\Models\UserSet;
use App\Models\UserSubject;
use Carbon\Carbon;
use FontLib\Table\Type\name;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

use Livewire\WithFileUploads;

class Menu extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $main_model = false, $new_model = false, $questions_upload = false, $students_upload = false;
    public $new_staff_name, $new_staff_email, $new_staff_subject;
    public $new_exam_title, $new_exam_description, $new_exam_is_mock, $new_exam_start_time, $new_exam_set, $new_exam_end_time, $new_exam_subject, $duration;
    public $new_set_name, $set;
    public $server_is_up = false, $allow_mock = false;
    public $model, $staffs, $subjects, $exams, $sets;
    public $subject, $subject_id, $staff, $staff_id, $exam, $exam_id, $set_id;
    public $sessions;
    public $school;
    public $new_subject_name;
    public $cormfirm_delete = false;
    public $questions_file, $students_file;
    public $result_exam_id;
    public $student_id;
    public Question $question;
    public $new_question = false, $image, $new_question_text, $new_question_more_info_link, $new_question_answer_explanation, $new_question_code_snippet;
    public $school_name;
    public array $questionOptions = [];

    public function new_easay() {}


    public function update_school_name()
    {
        Auth::user()->school->update([
            'name' => $this->school_name,
        ]);
        $this->mount();
    }
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
        $this->new_model = false;
        $this->load_subjects();
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
        $this->new_model = true;
        $this->new_question = false;
        $this->model = 'New Objective Question';
    }
    public function create_question($id)
    {
        $this->new_question = true;
        $this->subject = Subject::find($id);
    }
    public function delete_question($id)
    {
        $this->question = Question::find($id);
        $this->cormfirm_delete = true;
    }

    public function cormfirm_delete_question()
    {
        $this->question->delete();
        // $this->question = null;
        $this->cormfirm_delete = false;
    }
    public function view_questions($id)
    {
        $this->subject = Subject::find($id);
        $this->new_model = true;
        $this->model = 'View Questions';
    }
    public function remove_from_set($id)
    {
        $student_set = UserSet::where('user_id', $id)->where('set_id', $this->set->id)->first();
        if (!$student_set) {
            $this->alert('info', "Student not found in this set");
            return;
        } else {
            $student_set->delete();
            $this->alert('success', "Student removed from set");
        }
        $this->load_sets();
    }
    public function add_student()
    {
        if (UserSet::where('user_id', $this->student_id)->where('set_id', $this->set->id)->first()) {
            $this->alert('info', "Student already added to this set");
        } else {
            $student_set = new UserSet();
            $student_set->user_id = $this->student_id;
            $student_set->set_id = $this->set->id;
            $student_set->save();
            $this->alert('success', "Student Added Successfully!");
        }
    }
    public function add_students($id)
    {
        $this->set = Set::find($id);
        $this->new_model = true;
        $this->model = 'Add Students';
    }
    public function view_students($id)
    {
        $this->set = Set::find($id);
        $this->new_model = true;
        $this->model = 'View Set';
    }
    public function toggle_exam_visibility($id)
    {
        $exam = Exam::find($id);
        $exam->is_visible = $exam->is_visible == true ? false : true;
        $exam->save();
        $this->load_exams();
    }
    public function init_download_result($id)
    {
        $this->set = Set::find($id);
        $this->new_model = true;
        $this->model = 'Result';
    }
    public function download_result()
    {

        $set_id = $this->set->id;
        $exam_id = $this->result_exam_id;

        $exam = Exam::find($exam_id);
        $this->new_model = false;
        $this->model = 'Set';
        return Excel::download(new ExamResultsExport($set_id, $exam_id), 'Exam_Result-[' . $this->set->name . ' ' . $exam->title . '].xlsx');
    }
    public function toggle_mock()
    {
        $school = ModelsSchool::where('id', $this->school->id)->first();
        if ($this->school->allow_mock == true || $this->school->allow_mock == 1) {
            $this->school->update([
                'allow_mock' => false,
            ]);
            $school->allow_mock = false;
            $school->save();
        } else {
            $this->school->update([
                'allow_mock' => true,
            ]);
            $school->allow_mock = true;
            $school->save();
        }
    }
    public function confirm_student_upload()
    {

        $this->validate([
            'students_file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        try {
            $import = new StudentImport($this->set->id);
            Excel::import($import, $this->students_file->getRealPath());

            $errors = $import->getErrors();

            if (!empty($errors)) {
                // dd($errors, $errors[0]['error'], $errors[0]['row_data']);
                $this->alert('error', 'Some Students failed to import!' . $errors[0]['error'], [
                    'position' => 'center',
                    'toast' => false,
                    'timer' => 5000,
                ]);
            } else {
                $this->alert('success', 'Students imported successfully!', [
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
    public function upload_students($id)
    {

        $this->students_upload = true;
        $this->set = Set::find($id);
        $this->set_id = $this->set->id;
        $this->students_file = null;
    }
    public function create_new_set()
    {
        $this->set = new Set();
        $this->set->name = $this->new_set_name;
        $this->set->school_id = Auth::user()->school->id;
        $this->set->save();
        $this->alert('success', 'New Set Created Successfully.');
        $this->dismiss_new();
        $this->load_sets();
    }
    public function delete_set($id)
    {
        $this->set = Set::find($id);
        $this->cormfirm_delete = true;
    }
    public function cormfirm_delete_set()
    {

        $set = Set::where('id', $this->set->id)->first();
        if (!$set) {
            $this->alert('error', 'user not found');
            return;
        }
        // dd($staff);
        $this->set = null;
        $set->delete();
        $this->cormfirm_delete = false;
        $this->load_sets();
    }
    public function add_five_minute($id)
    {
        $exam = Exam::find($id);
        $exam->finish_time = Carbon::parse($exam->finish_time)->addMinute(5)->format('H:i');
        $exam->save();
        $this->load_exams();
    }
    public function create_new_exam()
    {
        $this->exam = new Exam();
        $this->exam->title = $this->new_exam_title;
        $this->exam->is_mock = $this->new_exam_is_mock ? true : false;
        $this->exam->description = $this->new_exam_description;
        $this->exam->start_time = $this->new_exam_start_time;
        $this->exam->finish_time = $this->new_exam_end_time;
        $this->exam->save();

        $exam_set = new SetExam();
        $exam_set->exam_id = $this->exam->id;
        $exam_set->set_id = $this->new_exam_set;
        $exam_set->save();

        $this->new_model = false;

        $this->load_exams();
        // dd($this);
    }
    public function calculateDuration()
    {
        if ($this->new_exam_start_time && $this->new_exam_end_time) {
            try {
                $start = Carbon::createFromFormat('H:i', $this->new_exam_start_time);
                $end = Carbon::createFromFormat('H:i', $this->new_exam_end_time);

                if ($end->lt($start)) {
                    $this->duration = null; // Invalid time range
                } else {
                    // Calculate hours and minutes difference
                    $hours = $start->diffInHours($end);
                    $minutes = $start->diffInMinutes($end) % 60;

                    // Format the duration
                    $this->duration = sprintf('%02d:%02d', $hours, $minutes);

                    // You may also want to update end_time properly in the full datetime format
                    // If you want to set it in the full datetime format, ensure you add today's date
                    // $this->quiz->end_time = Carbon::now()->setTimeFromTimeString($this->new_exam_end_time)->toDateTimeString(); // Update with full date-time
                }
            } catch (\Exception $e) {
                $this->duration = null; // Handle parsing errors
            }
        } else {
            $this->duration = null;
        }
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
    public function remove_subject_from_exam($exam_id, $subject_id)
    {
        $exam_subject = ExamSubject::where('exam_id', $exam_id)->where('subject_id', $subject_id)->first();
        if (!$exam_subject) {
            $this->alert('info', "Exam not assigned to subject!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }

        $exam_subject->delete();
        $this->model = "Exam";
        $this->new_model = false;
        $this->alert('success', "Subject removed from Exam!", [
            'toast' => false,
            'position' => 'center'
        ]);
        $this->load_exams();
    }
    public function add_subject_to_exam()
    {
        if (ExamSubject::where('exam_id', $this->exam->id)->where('subject_id', $this->new_exam_subject)->first()) {
            $this->alert('info', "Subject already added to Exam!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }
        $exam_subject = new ExamSubject();
        $exam_subject->exam_id = $this->exam->id;
        $exam_subject->subject_id = $this->new_exam_subject;
        $exam_subject->save();
        $this->model = "Exam";
        $this->new_model = false;
        $this->load_exams();
    }
    public function add_subject($id)
    {
        $this->exam = Exam::find($id);
        $this->exam_id = $this->exam->id;
        $this->new_model = true;
        $this->model = 'Add Subject';
    }
    public function assign_subject($id)
    {
        $this->staff = User::find($id);
        $this->staff_id = $this->staff->id;
        $this->new_model = true;
        $this->model = 'Asign Subject';
    }
    public function asign_subject_to_staff()
    {
        if (UserSubject::where('user_id', $this->staff->id)->where('subject_id', $this->new_staff_subject)->first()) {
            $this->alert('info', "Staff already assigned to subject!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }
        $staff_subject = new UserSubject();
        $staff_subject->user_id = $this->staff->id;
        $staff_subject->subject_id = $this->new_staff_subject;
        $staff_subject->save();
        $this->model = "Staff";
        $this->new_model = false;
        $this->load_staffs();
    }
    public function remove_subject($staff_id, $subject_id)
    {
        $staff_subject = UserSubject::where('user_id', $staff_id)->where('subject_id', $subject_id)->first();
        if (!$staff_subject) {
            $this->alert('info', "Staff not assigned to subject!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }

        $staff_subject->delete();
        $this->model = "Staff";
        $this->new_model = false;
        $this->alert('success', "Subject removed from staff!", [
            'toast' => false,
            'position' => 'center'
        ]);
        $this->load_staffs();
    }
    public function create_new_staff()
    {
        if (User::where('name', $this->new_staff_name)->first()) {
            $this->alert('info', "Staff name already exist!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }
        if (User::where('email', $this->new_staff_email)->first()) {
            $this->alert('info', "Staff email already in use!", [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }
        $this->staff = new User();
        $this->staff->name = $this->new_staff_name;
        $this->staff->email = $this->new_staff_email;
        $this->staff->password = Hash::make('password');
        $this->staff->is_set_master = true;
        $this->staff->is_subject_master = true;
        $this->staff->school_id = Auth::user()->school->id;
        $this->staff->save();

        $staff_subject = new UserSubject();
        $staff_subject->user_id = $this->staff->id;
        $staff_subject->subject_id = $this->new_staff_subject;
        $staff_subject->save();
        $this->new_staff_email = '';
        $this->new_subject_name = '';
        $this->load_staffs();
        $this->new_model = false;
    }
    public function delete_staff($id)
    {
        $this->staff = User::find($id);
        $this->cormfirm_delete = true;
    }
    public function cormfirm_delete_staff()
    {
        $staff = User::where('id', $this->staff->id)->first();
        if (!$staff) {
            $this->alert('error', 'user not found');
            return;
        }
        // dd($staff);
        $this->staff = null;
        $staff->delete();
        $this->cormfirm_delete = false;
        $this->load_staffs();
    }
    public function upload_questions($id)
    {
        $this->questions_upload = true;
        $this->subject = Subject::find($id);
        $this->subject_id = $this->subject->id;
        $this->questions_file = null;
    }
    public function cancel_upload()
    {
        $this->questions_upload = false;
        $this->students_upload = false;
        $this->set  = null;
        $this->subject = null;
        $this->questions_file = null;
    }
    public function confirm_upload()
    {

        $this->validate([
            'questions_file' => 'required|file|mimes:xls,xlsx,csv',
        ]);

        try {
            $import = new QuestionsImport($this->subject_id);
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
    public function delete_subject($id)
    {
        $this->subject = Subject::find($id);
        $this->cormfirm_delete = true;
    }
    public function cancel_delete()
    {
        $this->cormfirm_delete = false;
    }
    public function delete()
    {
        $subject = Subject::find($this->subject->id);
        $subject->delete();
        $this->subject = null;
        $this->cormfirm_delete = false;
        $this->load_subjects();
    }
    public function toggle_server()
    {
        $this->sessions = Session::all();
        $school = ModelsSchool::find($this->school->id);
        $school->server_is_up = !$this->school->server_is_up;
        $school->save();
        $this->server_is_up = $school->server_is_up;
    }
    public function close_main_model()
    {
        $this->main_model = false;
        $this->new_model = false;
    }
    public function dismiss_new()
    {
        $this->new_staff_name = '';
        $this->new_staff_email = '';
        $this->new_subject_name = '';
        $this->new_staff_subject = '';
        $this->new_set_name = '';
        if ($this->model == 'View Set') {
            $this->model = 'Set';
        } elseif ($this->model == 'Result' || $this->model == 'Add Students') {
            $this->model = 'Set';
        } elseif ($this->model == 'Asign Subject') {
            $this->model = 'Staff';
        } elseif ($this->model == 'View Questions' || $this->model == 'New Objective Question') {
            $this->model = 'Subject';
        }
        $this->new_model = false;
    }
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->school = ModelsSchool::find(Auth::user()->school->id);
        $this->school_name = $this->school->name;
        $this->server_is_up = $this->school->server_is_up == 1 ? true : false;
    }
    public function open_main_model($model)
    {
        switch ($model) {
            case 'Staffs':
                $this->model = 'Staff';
                $this->load_staffs();
                break;
            case 'Subjets':
                $this->model = 'Subjets';
                $this->load_subjects();
                break;
            case 'Exams':
                $this->model = 'Exams';
                $this->load_exams();
                break;
            case 'Set':
                $this->model = 'Set';
                $this->load_sets();
                break;
            default:
                $this->model = 'Staff';
                $this->load_staffs();
                break;
        }
        $this->main_model = true;
    }
    public function create_new($model)
    {
        switch ($model) {
            case 'Staffs':
                $this->model = 'Staff';
                $this->load_staffs();
                break;
            case 'Subjets':
                $this->model = 'Subjets';
                $this->load_subjects();
                break;
            case 'Exams':
                $this->model = 'Exams';
                $this->load_exams();
                break;
            case 'Set':
                $this->model = 'Set';
                $this->load_sets();
                break;
            default:
                $this->model = 'Staff';
                $this->load_staffs();
                break;
        }
        $this->main_model = true;
        $this->new_model = true;
    }
    public function create_new_subject()
    {
        $this->validate([
            'new_subject_name' => 'required'
        ]);
        $subject = Subject::where('title', $this->new_subject_name)->first();
        if ($subject) {
            $this->alert('error', 'Subject already exist', [
                'toast' => false,
                'position' => 'center'
            ]);
            return;
        }
        $new_subject = new Subject();
        $new_subject->title = $this->new_subject_name;
        $new_subject->school_id = Auth::user()->school->id;
        $new_subject->save();
        $this->new_subject_name = '';
        $this->load_subjects();
        $this->dismiss_new();
    }
    public function load_staffs()
    {
        $this->subjects = false;
        $this->exams = false;
        $this->sets = false;
        $this->staffs = User::where('is_staff', true)->orWhere('is_subject_master', true)->where('school_id', Auth::user()->id)->orderBy('id', 'desc')->get();
    }
    public function load_subjects()
    {
        $this->staffs = false;
        $this->exams = false;
        $this->sets = false;
        $this->subjects = Auth::user()->school->subjects()->orderBy('id', 'desc')->get();
    }
    public function load_exams()
    {
        $this->subjects =  false;
        $this->staffs = false;
        $this->sets = false;
        $this->exams = Exam::orderBy('id', 'desc')->get();
    }
    public function load_sets()
    {
        $this->subjects =  false;
        $this->staffs = false;
        $this->exams = false;
        $this->sets = Set::orderBy('id', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.dashboard.menu');
    }
}
