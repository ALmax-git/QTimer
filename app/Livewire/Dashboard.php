<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public $tab = 'Dashboard';

    public function toggle_tab($tab)
    {
        $this->tab = $tab;
    }

    public function logout()
    {
        Auth::guard('web')->logout();  // Use the 'web' guard to log out
        return redirect()->route('login');  // Redirect to the login page
    }
    public function exit_qtimer()
    {
        // Kill Firefox (Windows)
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec('taskkill /F /IM firefox.exe');
            exec('taskkill /F /IM php.exe'); // Stop Laravel server
        }
        // Kill Firefox (Linux)
        else {
            exec('pkill firefox');
            exec('pkill php'); // Stop Laravel server
        }
    }
    public function mount()
    {
        \App\helpers\RequestTracker::track();
        $this->tab = 'Dashboard';
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
