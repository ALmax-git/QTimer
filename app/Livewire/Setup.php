<?php

namespace App\Livewire;

use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Setup extends Component
{
    use WithFileUploads;
    public $school_name, $school_type = 'School', $school_email;
    public $school;
    public $license;
    public function mount()
    {
        if (system_license_check()) {
            return redirect()->route('app');
        }
        if (School::find(Auth::user()->school_id)) {
            $this->school = School::find(Auth::user()->school_id);
        }
    }
    public function save()
    {
        if (!School::find(Auth::user()->school_id)) {
            $school = new School();
            $school->name = $this->school_name;
            $school->type = $this->school_type;
            $school->email = $this->school_email;
            $school->user_id = Auth::user()->id;

            $school->lincense = '';
            $school->save();
            $user = User::find(Auth::user()->id);
            $user->school_id = $school->id;
            $user->save();
            return redirect()->route('app');
        }
    }
    public function render()
    {
        return view('livewire.setup');
    }
}
