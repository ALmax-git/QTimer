namespace App\Helpers;

use App\Models\QTimerRequest;
use Carbon\Carbon;

class RequestTracker
{
    public static function track()
    {
        // Get current timestamp rounded to nearest 2-minute interval
        $currentTime = Carbon::now()->startOfMinute()->subMinutes(Carbon::now()->minute % 2);

        // Find or create a record for the current 2-minute interval
        $requestData = QTimerRequest::firstOrCreate(
            ['created_at' => $currentTime],
            ['count' => 0]
        );

        // Increment request count
        $requestData->increment('count');
    }
}
