<?php

namespace App\Livewire\Auth;

use App\Models\Session;
use App\Models\User;
use Livewire\Component;

class Login extends Component
{
    public $username_email_or_phone;
    public $username_email_or_phone_is_valid = false;
    public $email;
    public $user_log = '';
    public function chech_for_email()
    {
        if (User::where('email', $this->username_email_or_phone)->exists()) {
            $this->username_email_or_phone_is_valid = true;
            $this->email = $this->username_email_or_phone;
            $this->user_log = "";
            $this->check_seesioon(User::where('email', $this->username_email_or_phone)->first()->id);
            // dd($this);


        } elseif (User::where('id_number', $this->username_email_or_phone)->exists()) {
            $this->username_email_or_phone_is_valid = true;
            $this->email = User::where('id_number', $this->username_email_or_phone)->first()->email;
            $this->user_log = "";
            $this->check_seesioon(User::where('id_number', $this->username_email_or_phone)->first()->id);
        } else {
            $this->username_email_or_phone_is_valid = false;
        }
    }
    public function check_seesioon($id)
    {
        if (Session::where('user_id', $id)->exists()) {
            if ($id > 1) {
                $this->user_log = "This User is already Log on Another Computer please Contact you Admin!";
                $this->username_email_or_phone_is_valid = false;
            }
        }
    }
    public function _login()
    {
        auth()->login(User::where('email', $this->email)->first());
        Session::create([
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
        // dd(auth()->user());
        return redirect()->route('app');
    }
    public function render()
    {
        \App\helpers\RequestTracker::track();
        return view('livewire.auth.login');
    }
}
