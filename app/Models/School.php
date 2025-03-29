<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'user_id',
        'email',
        'lincense',
        'allow_mock',
        'status',
        'type',
        'server_is_up',
        'allow_mock_result',
        'allow_live_result',
        'allow_mock_review',
    ];

    public function students()
    {
        return $this->hasMany(User::class)->where('is_staff', false);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function has_license()
    {
        return system_license_check();
    }

    public function sets()
    {
        return $this->hasMany(Set::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
