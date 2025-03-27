<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\QTimerRequest;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function trackRequest()
    { // Find today's record or create a new one
        $requestData = QTimerRequest::firstOrCreate(
            ['created_at' => Carbon::today()],
            ['count' => 0]
        );

        // Increment request count
        $requestData->increment('count');

        return response()->json([
            'timestamp' => Carbon::now()->format('H:i:s'),
            'request_count' => $requestData->count
        ]);
        // Get the current request count
        // $count = Cache::get('qtimer_request_count', 0);

        // // Update the count in cache
        // Cache::increment('qtimer_request_count');

        // return response()->json([
        //     'timestamp' => Carbon::now()->format('H:i:s'),
        //     'request_count' => $count
        // ]);
    }
}
