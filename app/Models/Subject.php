<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $fillable = [
        'title',
        'school_id',
    ];

    public function school()
    {
        $this->belongsTo(School::class, 'school_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function users()
    {
        return $this->belongsToMany(Exam::class, 'user_subjects');
    }
}
