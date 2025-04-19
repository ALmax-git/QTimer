<?php

namespace App\Livewire\Dashboard;

use App\Models\License;
use App\Models\School;
use App\Models\Set;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;
use Livewire\Component;

class Control extends Component
{

    use WithPagination, LivewireAlert;

    public $studentId;
    public $showViewModal = false;
    public $showEditModal = false;
    public $studentData = [];
    public $msg_status = '';
    public $search = '';
    public $license;
    public $license_modal = false;
    public $is_renew = false;



    protected $paginationTheme = 'bootstrap';
    public $school, $server_is_up;

    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->school = School::find(Auth::user()->school->id);
        $this->server_is_up = $this->school->server_is_up == 1 ? true : false;
        $this->license_status();
    }
    public function open_license_modal()
    {
        $this->license = License::where('user_id', $this->school->admin->id)->orderBy('created_at', 'desc')->first();
        $this->license_modal = true;
        // dd($this->license);
    }
    public function close_license_modal()
    {
        $this->license_modal = false;
        $this->license = null;
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
    public bool $renew_modal = false;
    public function open_renew_modal()
    {
        $this->renew_modal = true;
        $this->msg_status = '';
        $this->license_modal = false;
        $this->is_renew = true;
    }
    public function license_status()
    {
        $license = License::where('user_id', $this->school->admin->id)->orderBy('created_at', 'desc')->first();

        if (!$license) {
            $this->alert('error', 'No license found. Please contact support.');
            $this->msg_status = 'No license found. Please contact support.';
            $this->renew_modal = true;
            $this->is_renew = false;
            return;
        }
        if (!$license->is_active || $license->status != 'active') {
            // Check if the license is inactive or suspended
            // You can also check for other statuses like 'suspended' or 'revoked'
            // and handle them accordingly
            // For example:
            // $this->alert('error', 'Your license is suspended. Please contact support.');
            // or
            // $this->alert('error', 'Your license is revoked. Please contact support.');
            // For now, let's just show a generic error message
            // You can also check for other statuses like 'suspended' or 'revoked'
            // and handle them accordingly
            // For example:
            $this->alert('error', 'Your license is inactive. Please contact support.');
            $this->msg_status = 'Your license is inactive. Please contact support.';
            $this->renew_modal = true;
            $this->is_renew = false;
            return;
        }

        if ($license->isExpired()) {
            $this->alert('warning', 'Your license has expired. Please renew to continue.');
            $this->msg_status = 'Your license has expired. Please renew to continue.';
            $this->renew_modal = true;
            $this->is_renew = false;
            return;
        }

        $this->is_renew = false;
        // Valid license – do nothing
    }

    public function toggle_server()
    {
        //let check for LICENSE before toggling the server

        // Toggle the boolean state
        $this->server_is_up = !$this->server_is_up;

        // Store it properly in the school model (ensure it's saved as an integer)
        $this->school->server_is_up = $this->server_is_up ? 1 : 0;
        $this->school->save();


        // Debugging Logs
        // logger("New Server Status: " . $this->server_is_up);

        // Dispatch only one event based on the new state
        if ($this->server_is_up) {
            logger("Dispatching server-up event");
            $this->dispatch('server-up');
            $this->alert('success', 'Server is live on ' . url('/'));
        } else {
            logger("Dispatching server-down event");
            $this->dispatch('server-down');
        }
        \App\helpers\RequestTracker::track();
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
    public function sync_all()
    {
        // Delete all sessions without a user_id
        \App\Models\Session::whereNull('user_id')->delete();
        $this->mount();
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
