<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class QTimerLiveProgress extends Component
{
    public $timestamps = [];
    public $requestCounts = [];

    protected $listeners = ['refreshChart' => 'updateChart'];

    public function mount()
    {
        $this->updateChart();
    }

    public function updateChart()
    {
        // Simulate retrieving QTimer request count per minute
        $time = Carbon::now()->format('H:i'); // Current hour:minute
        $count = Cache::get('qtimer_request_count', 0);

        // Store the latest values (limit to 10 points)
        array_push($this->timestamps, $time);
        array_push($this->requestCounts, $count);

        if (count($this->timestamps) > 10) {
            array_shift($this->timestamps);
            array_shift($this->requestCounts);
        }

        // Reset request count for next tracking cycle
        Cache::put('qtimer_request_count', 0, now()->addMinutes(1));

        $this->dispatch('updateQTimerChart', [
            'labels' => $this->timestamps,
            'data' => $this->requestCounts,
        ]);
        // dd($this->timestamps, $this->requestCounts, $time, $count);
    }
    public function render()
    {
        return view('livewire.q-timer-live-progress');
    }
}
