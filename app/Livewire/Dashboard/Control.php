<?php

namespace App\Livewire\Dashboard;

use App\Models\School;
use App\Models\Set;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Component;

class Control extends Component
{

    use WithPagination;

    public $studentId;
    public $showViewModal = false;
    public $showEditModal = false;
    public $studentData = [];
    // public $recent_students;
    public $search = '';

    protected $paginationTheme = 'bootstrap';
    public $school, $server_is_up;

    public function mount()
    {
        $this->school = School::find(Auth::user()->school->id);
        $this->server_is_up = $this->school->server_is_up == 1 ? true : false;
    }

    public function dismiss()
    {
        $this->showViewModal = false;
        $this->showEditModal = false;
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Reset pagination when searching
    }

    public function toggle_server()
    {
        $this->server_is_up = !$this->server_is_up;
        $this->school->server_is_up = $this->server_is_up ? 1 : 0;
        $this->school->save();
    }
    public function viewStudent($id)
    {
        $this->studentData = User::findOrFail($id)->toArray();
        $this->showViewModal = true;
    }

    public function editStudent($id)
    {
        $this->studentData = User::findOrFail($id)->toArray();
        $this->showEditModal = true;
    }

    public function updateStudent()
    {
        $student = User::findOrFail($this->studentData['id']);
        $student->update($this->studentData);

        session()->flash('message', 'Student updated successfully!');
        $this->showEditModal = false;
    }

    public function deleteStudent($id)
    {
        User::findOrFail($id)->delete();
        session()->flash('message', 'Student deleted successfully!');
    }
    public function render()
    {
        $recent_students = Auth::user()->school->students()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('id_number', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.dashboard.control', [
            'recent_students' => $recent_students
        ]);
    }
}
