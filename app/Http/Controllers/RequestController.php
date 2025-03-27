<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\QTimerRequest;
use Carbon\Carbon;

class RequestController extends Controller
{
    public function trackRequest()
    {
        $requestData = QTimerRequest::orderBy('created_at', 'desc')
            ->limit(15)
            ->get()
            ->reverse() // To display in chronological order
            ->values();
        return response()->json($requestData);
    }
}
