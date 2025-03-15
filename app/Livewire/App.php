<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

class App extends Component
{
    public $tab = 'profile';

    public function logout()
    {
        Auth::guard('web')->logout();  // Use the 'web' guard to log out
        return redirect()->route('login');  // Redirect to the login page
    }
    public function closeApp()
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
    public function change_tab($tab)
    {
        // dd($tab, read($tab));
        $this->tab = read($tab);
    }
    public function render()
    {
        return view('livewire.app');
    }
}
