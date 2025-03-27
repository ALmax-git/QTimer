<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function trackRequest()
    {
        // Get the current request count
        $count = Cache::get('qtimer_request_count', 0);

        // Update the count in cache
        Cache::increment('qtimer_request_count');

        return response()->json([
            'timestamp' => Carbon::now()->format('H:i:s'),
            'request_count' => $count
        ]);
    }
}
