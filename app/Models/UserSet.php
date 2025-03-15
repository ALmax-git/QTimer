<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSet extends Model
{
    protected $fillable = ['user_id', 'set_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function set()
    {
        return $this->belongsTo(Set::class);
    }
}
