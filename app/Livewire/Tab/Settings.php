<?php

namespace App\Livewire\Tab;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Settings extends Component
{
    use LivewireAlert;
    public ?School $school;
    public $school_name, $school_email;

    public function toggle_mock()
    {
        $school = School::where('id', $this->school->id)->first();
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
    public function toggle_mock_result()
    {
        $school = School::where('id', $this->school->id)->first();
        if ($this->school->allow_mock_result == true || $this->school->allow_mock_result == 1) {
            $this->school->update([
                'allow_mock_result' => false,
            ]);
            $school->allow_mock_result = false;
            $school->save();
        } else {
            $this->school->update([
                'allow_mock_result' => true,
            ]);
            $school->allow_mock_result = true;
            $school->save();
        }
    }
    public function toggle_live_result()
    {
        $school = School::where('id', $this->school->id)->first();
        if ($this->school->allow_live_result == true || $this->school->allow_live_result == 1) {
            $this->school->update([
                'allow_live_result' => false,
            ]);
            $school->allow_live_result = false;
            $school->save();
        } else {
            $this->school->update([
                'allow_live_result' => true,
            ]);
            $school->allow_live_result = true;
            $school->save();
        }
    }
    public function toggle_mock_review()
    {
        $school = School::where('id', $this->school->id)->first();
        if ($this->school->allow_mock_review == true || $this->school->allow_mock_review == 1) {
            $this->school->update([
                'allow_mock_review' => false,
            ]);
            $school->allow_mock_review = false;
            $school->save();
        } else {
            $this->school->update([
                'allow_mock_review' => true,
            ]);
            $school->allow_mock_review = true;
            $school->save();
        }
    }
    public function update_school_name_and_email()
    {
        $this->school->name = $this->school_name;
        $this->school->email = $this->school_email;
        $this->school->save();
        $this->alert('success', 'School updated Successfully!');
    }
    public function mount()
    {
        $this->school = School::find(Auth::user()->school->id);
        $this->school_name = $this->school->name;
        $this->school_email = $this->school->email;
    }

    public function render()
    {
        return view('livewire.tab.settings');
    }
}
