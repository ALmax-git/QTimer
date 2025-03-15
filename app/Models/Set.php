<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Set extends Model
{

    protected $fillable = [
        'name',
        'school_id',
    ];

    public function school()
    {
        $this->belongsTo(School::class, 'school_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sets');
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'set_exams');
    }
}
