<?php

namespace App\Livewire\Tab;

use App\Models\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Student extends Component
{
    use LivewireAlert;
    public $sessions;
    public $session;
    public $cormfirm_delete;
    public function delete_session($id)
    {
        $this->session = Session::where('user_id', $id)->get();
        // dd($this);
        if ($this->session) {
            $this->cormfirm_delete = true;
        } else {
            $this->alert('error', 'An Error occour please contact support');
        }
    }
    public function delete_cormfirmed($id)
    {
        // dd($this);
        $this->session = Session::where('user_id', $id)->get();
        foreach ($this->session as $session) {
            $session->delete();
        }
        $this->session = null;
        $this->cormfirm_delete = false;
        $this->alert('success', 'Session Terminated Success');
        $this->mount();
    }

    public function cancel_delete()
    {
        $this->cormfirm_delete = false;
    }
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->sessions = Session::get();
    }
    public function render()
    {
        return view('livewire.tab.student');
    }
}
