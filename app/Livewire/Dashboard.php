<?php

namespace App\Livewire;

use Livewire\Component;

class Dashboard extends Component
{
    public $tab = 'Dashboard';

    public function toggle_tab($tab)
    {
        $this->tab = $tab;
    }
    public function mount()
    {
        $this->tab = 'Dashboard';
    }
    public function render()
    {
        return view('livewire.dashboard');
    }
}
