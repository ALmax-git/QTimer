<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\Models\License;
use App\Models\School;
use App\Models\User;
use Flutterwave\Controller\PaymentController;
use Flutterwave\EventHandlers\ModalEventHandler as PaymentHandler;
use Flutterwave\Flutterwave;
use Flutterwave\Library\Modal;

if (!function_exists('user_can_access')) {
    function user_can_access()
    {
        $user = Auth::user();

        if (!$user) {
            return [];
        }
        $permissions = [];
        foreach ($user->roles as $role) {
            $role_permissions = $role->permissions;
            foreach ($role_permissions as $permission) {
                $permissions[] = $permission->title;
            }
        }

        return $permissions;
    }
}

if (!function_exists('check_if')) {
    function check_if($permissions, $access)
    {
        foreach ($permissions as $permission) {
            if ($permission == $access) {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('system_license_check')) {

    function system_license_check()
    {
        try {
            // Ensure user is authenticated
            if (!Auth::check()) {
                return false;
            }

            // Get the admin user ID of the school
            $adminId = Auth::user()->school->admin->id ?? null;

            if (!$adminId) {
                Log::warning("License check failed: Admin ID not found.");
                return false;
            }

            // Retrieve the latest license for the admin user
            $license = License::where('user_id', $adminId)->orderBy('created_at', 'desc')->first();

            // Check if license exists
            if (!$license) {
                Log::warning("License check failed: No license found for Admin ID: $adminId");
                return false;
            }

            // Check if license is active
            if (!$license->is_active) {
                Log::warning("License check failed: License is inactive for Admin ID: $adminId");
                return false;
            }

            // Check if license is expired
            if (now()->greaterThan($license->expires_at)) {
                Log::warning("License check failed: License expired for Admin ID: $adminId");
                return false;
            }

            // License is valid
            return true;
        } catch (\Exception $e) {
            Log::error("License check error: " . $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('write')) {
    /**
     * Encrypts the given value.
     *
     * @param mixed $value The value to be encrypted.
     * @return string The encrypted string.
     */
    function write($value)
    {
        $key = env('READ_AND_WRITE', null);
        if (!$key) {
            throw new Exception('Encryption key not set in .env');
        }

        $keyHash = hash('sha256', $key);
        return Crypt::encrypt($value, $keyHash);
    }
}
if (!function_exists('read')) {
    /**
     * Decrypts the given encrypted value.
     *
     * @param string $value The encrypted string.
     * @return mixed The decrypted value.
     */
    function read($value)
    {
        $key = env('READ_AND_WRITE', null);
        if (!$key) {
            throw new Exception('Decryption key not set in .env');
        }

        $keyHash = hash('sha256', $key);
        return Crypt::decrypt($value, $keyHash);
    }
}

if (!function_exists('varify_payment')) {


    /**
     * Verify a payment transaction using its reference.
     *
     * @param string $tx_ref Transaction reference to verify.
     * @return object Decoded JSON response from the payment verification API.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException For validation and processing errors.
     */
    function varify_payment($tx_ref)
    {
        // Validate transaction reference input
        if (empty($tx_ref) || !is_string($tx_ref)) {
            Log::error('Transaction reference (tx_ref) is missing, empty, or invalid.');
            abort(400, 'Invalid or missing transaction reference.');
        }

        // Check if the transaction exists in the database
        // $transactionExists = DB::table('transactions')->where('transaction_reference_code', $tx_ref)->exists();
        // if (!$transactionExists) {
        //     Log::error("Transaction reference ($tx_ref) not found in the database.");
        //     abort(404, "Transaction reference not found.");
        // }

        // API configuration
        $url = "https://api.flutterwave.com/v3/transactions/verify_by_reference?tx_ref=$tx_ref";
        $apiKey = 'FLWSECK_TEST-cc73c6958426b626bf55189bbf9bb477-X';
        $maxRetries = 5; // Maximum retry attempts
        $retryDelay = 2; // Delay between retries in seconds

        $attempt = 0;
        $response = null;

        while ($attempt < $maxRetries) {
            $ch = curl_init();

            // Set cURL options for the API call
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $apiKey",
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout for the request

            $response = curl_exec($ch);

            // Handle cURL errors
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                Log::warning("Attempt $attempt: cURL error during payment verification for tx_ref ($tx_ref): $error");

                curl_close($ch);
                $attempt++;
                sleep($retryDelay); // Wait before retrying
                continue; // Retry the request
            }

            curl_close($ch);
            break; // Exit the retry loop if the request is successful
        }

        // Check if all retry attempts failed
        if ($response === false) {
            Log::error("Payment verification failed after $maxRetries attempts for tx_ref ($tx_ref).");
            abort(500, 'Payment verification failed. Please try again later.');
        }

        // Decode and validate the API response
        $decodedResponse = json_decode($response);

        // Ensure the response is properly formatted
        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error("Invalid JSON response during payment verification for tx_ref ($tx_ref): $response");
            abort(500, 'Invalid payment verification response.');
        }

        // Check for successful verification status
        if (!isset($decodedResponse->status) || $decodedResponse->status !== 'success') {
            $errorMessage = $decodedResponse->message ?? 'Unknown error during payment verification.';
            Log::error("Payment verification failed for tx_ref ($tx_ref): $errorMessage");
            abort(500, 'Payment verification unsuccessful: ' . $errorMessage);
        }

        // Log successful verification for auditing
        Log::info("Payment verification successful for tx_ref ($tx_ref).");

        // Return the decoded response
        return $decodedResponse;
    }
}

if (!function_exists('flutterwave_payment')) {
    /**
     * Helper function to initialize and handle a Flutterwave payment.
     *
     * @return object Payment controller.
     */
    function flutterwave_payment()
    {
        // Initialize Flutterwave SDK
        Flutterwave::bootstrap();
        $customHandler = new PaymentHandler();
        $client = new Flutterwave();
        $modalType = Modal::POPUP;
        $controller = new PaymentController($client, $customHandler, $modalType);

        return $controller;
    }
}

if (!function_exists('system_generate_new_api_key')) {
    function system_generate_new_api_key(): string
    {
        // Generate 8 random bytes and convert to uppercase hexadecimal (16 characters)
        // You can format it with dashes if desired.
        return strtoupper(bin2hex(random_bytes(16)));
    }
}

if (!function_exists('system_new_licence')) {
    function system_new_licence($client_id, $user_id, $software_id,  $license_type, $ownership, $amount_payed, $payment_type)
    {
        DB::beginTransaction();
        try {
            $user = User::find($user_id);
            $client = School::find($client_id);
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User or Client not found please contact support!',
                    'data' => []
                ]);
            }

            $license = new License();

            $license->user_id = $user->id;
            $license->client_id = $client->id;
            $license->ownership = $ownership == 'multiple' ? 'multiple' : 'single';
            $license->software_id = 1;
            $license->key = system_generate_new_api_key();
            $license->license_type = $license_type;
            $license->status = 'active';
            $license->is_active = true;
            $license->activated_at = now();
            $license->expires_at = now()->addYear();
            $license->activated_devices = json_encode([]);
            $hash = write($license->key . $license->ownership . '1' . $user->name . $user->id);
            $certificate = <<<EOT
            -----BEGIN CERTIFICATE-----
            Type:: $license->license_type
            Active:: $license->activated_at
            Expire:: $license->expires_at
            Price:: $amount_payed
            Payment:: $payment_type
            Owner:: $user->name
            Software:: QTimer
            Software Key:: self_key
            License Key:: $license->key
            ----------------------------
            Hash:: $hash
            -----END CERTIFICATE-----
            EOT;
            $license->certificate = $certificate;
            $license->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'License activated successfully!',
                'data' => [
                    'certificate' => $certificate,
                    'key' => $license->key,
                    'user' => $user->id,
                    'software' => 'QTimer',
                    'software_key' => 'self_key',
                    'status' => $license->status,
                ]
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('License activation failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => ':( An error: License not activated please contact support!',
                'data' => $e->getMessage()
            ]);
        }
    }
}
