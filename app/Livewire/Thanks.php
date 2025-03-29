<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Thanks extends Component
{

    public function logout()
    {
        Auth::guard('web')->logout();  // Use the 'web' guard to log out
        return redirect()->route('login');  // Redirect to the login page
    }
    public function render()
    {
        return view('livewire.thanks');
    }
}
