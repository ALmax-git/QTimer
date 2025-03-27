<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class QTimerLiveProgress extends Component
{
    // public $sever_status;
    // public function mount($sever_status)
    // {
    //     $this->sever_status = $sever_status;
    // }
    public function render()
    {
        return view('livewire.q-timer-live-progress');
    }
}
