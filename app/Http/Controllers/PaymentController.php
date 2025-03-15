<?php

namespace App\Http\Controllers;

use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function buy_license(Request $request)
    {
        try {
            $controller = flutterwave_payment();


            // License type price
            switch ($request->license) {
                case 'gold':
                    $activation = Auth::user()->school->has_license() ? 0 : 61500;
                    $license_price = 7500;
                    break;
                case 'diamond':
                    $activation = Auth::user()->school->has_license() ? 0 : 88000;
                    $license_price = 10000;
                    break;
                default:
                    $activation = Auth::user()->school->has_license() ? 0 : 45000;
                    $license_price = 5000;
                    break;
            }

            // Payment Data
            $data = [
                'payment_method' => 'card,banktransfer',
                'amount' => $license_price + $activation,
                'email' => Auth::user()->email,
                'tx_ref' => uniqid(),
                'first_name' => Auth::user()->school->name,
                'last_name' => Auth::user()->name,
                'currency' => 'NGN',
                'redirect_url' => route('set_license'),
                'success_url' => route('set_license'),
                'failure_url' => route('set_license'),
                'customer' => [
                    'email' => Auth::user()->email,
                    "phone_number" => Auth::user()->phone_number,
                    "name" => Auth::user()->name,
                ],
                "customizations" => [
                    "title" => 'CBT License',
                    "description" => "Get CBT License",
                ],
            ];

            // Process Payment
            $controller->process($data);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment initialization failed: ' . $e->getMessage());
            abort(500, "An error occurred during the payment process. Please try again.");
        }
    }

    public function set_license(Request $request)
    {

        DB::beginTransaction();
        try {
            // Validate Payment Response (Optional: Add verification logic)
            if (!$request->has('status') || $request->status !== 'completed') {
                throw new \Exception("Payment verification failed");
            }
            $payment = varify_payment($request->tx_ref);
            if ($payment->data->amount < 70000) {
                $ownership = 'single';
            } else {
                $ownership = 'multiple';
            }

            // $license = system_new_licence(Auth::user()->school->id, Auth::user()->id, 1, 'subscription', 'single', 5000, 'system');

            $license = system_new_licence(Auth::user()->school->id, Auth::user()->id, 1, 'subscription', $ownership, $payment->data->amount, 'system');
            DB::commit();

            return redirect()->route('app')->with('success', 'License activated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('License activation failed: ' . $e->getMessage());
            return redirect()->route('app')->with('error', 'License activation failed.');
        }
    }
}
