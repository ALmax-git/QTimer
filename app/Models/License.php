<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class License extends Model
{

    protected $fillable = [
        'user_id',
        'client_id',
        'ownership',
        'software_id',
        'key',
        'license_type',
        'status',
        'max_devices',
        'activated_devices',
        'activated_at',
        'expires_at',
        'is_active',
    ];

    // Cast the JSON field to an array and timestamps to Carbon instances.
    protected $casts = [
        'activated_devices' => 'array',
        'activated_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a secure unique license key.
     *
     * @return string
     */
    public static function generateKey(): string
    {
        // Generate 8 random bytes and convert to uppercase hexadecimal (16 characters)
        // You can format it with dashes if desired.
        return strtoupper(bin2hex(random_bytes(16)));
    }

    /**
     * Create a new license.
     *
     * @param int|null $userId The owner of the license.
     * @param string $licenseType License type: trial, subscription, or lifetime.
     * @param string|null $expiresAt Expiration date (for trial/subscription licenses).
     * @param int|null $maxDevices Maximum number of devices allowed (null or 0 for unlimited).
     *
     * @return self
     */
    public static function createLicense($userId = null, string $licenseType = 'trial', $expiresAt = null, $maxDevices = 1): self
    {
        return self::create([
            'user_id' => $userId,
            'key' => self::generateKey(),
            'license_type' => $licenseType,
            'max_devices' => $maxDevices,
            'expires_at' => $expiresAt ? Carbon::parse($expiresAt) : null,
            'activated_devices' => [],
        ]);
    }

    /**
     * Validate the license for an optional device.
     *
     * @param string|null $deviceId
     * @return bool
     */
    public function validateLicense($deviceId = null): bool
    {
        // Ensure the license is active.
        if (!$this->is_active) {
            return false;
        }

        // Check for expiration.
        if ($this->expires_at && Carbon::now()->greaterThan($this->expires_at)) {
            return false;
        }

        // If there's a device restriction.
        if ($this->max_devices && $deviceId) {
            $activatedDevices = $this->activated_devices ?? [];

            // If this device is not yet activated and we've reached the maximum.
            if (!in_array($deviceId, $activatedDevices) && count($activatedDevices) >= $this->max_devices) {
                return false;
            }
        }

        return true;
    }

    /**
     * Activate the license for a specific device.
     *
     * @param string $deviceId
     * @return bool
     */
    public function activateLicense(string $deviceId): bool
    {
        // Validate before activation.
        if (!$this->validateLicense($deviceId)) {
            return false;
        }

        $activatedDevices = $this->activated_devices ?? [];

        // Register the device if not already present.
        if (!in_array($deviceId, $activatedDevices)) {
            $activatedDevices[] = $deviceId;
            $this->activated_devices = $activatedDevices;
            // Set the activation timestamp if this is the first activation.
            if (!$this->activated_at) {
                $this->activated_at = Carbon::now();
            }
            $this->save();
        }
        return true;
    }

    /**
     * Deactivate the license entirely.
     *
     * @return void
     */
    public function deactivateLicense(): void
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * Extend the expiration date by a number of days.
     *
     * @param int $days
     * @return void
     */
    public function extendLicense(int $days): void
    {
        if (!$this->expires_at) {
            // Lifetime licenses cannot be extended.
            return;
        }
        $this->expires_at = Carbon::parse($this->expires_at)->addDays($days);
        $this->save();
    }

    /**
     * Revoke activation from a specific device.
     *
     * @param string $deviceId
     * @return bool
     */
    public function revokeDevice(string $deviceId): bool
    {
        $activatedDevices = $this->activated_devices ?? [];
        if (($key = array_search($deviceId, $activatedDevices)) !== false) {
            unset($activatedDevices[$key]);
            // Reindex the array
            $this->activated_devices = array_values($activatedDevices);
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Check if the license has expired.
     *
     * @return bool
     */
    public function isExpired(): bool
    {
        return $this->expires_at && Carbon::now()->greaterThan($this->expires_at);
    }
}
