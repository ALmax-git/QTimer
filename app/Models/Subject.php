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
        return $this->belongsTo(School::class, 'school_id');
    }
    public function questions()
    {
        return $this->hasMany(Question::class)->where('type', 'objective')->where('status', 'active');
    }
    public function questions_all()
    {
        return $this->hasMany(Question::class);
    }
    public function questions_all_active()
    {
        return $this->hasMany(Question::class)->where('status', 'active');
    }
    public function essays()
    {
        return $this->hasMany(Question::class)->where('type', 'essay')->where('status', 'active');
    }

    public function users()
    {
        return $this->belongsToMany(Exam::class, 'user_subjects');
    }
}
