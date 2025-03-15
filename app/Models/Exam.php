<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'finish_time',
        'is_mock',
        'is_visible'
    ];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'exam_subjects');
    }


    public function sets()
    {
        return $this->belongsToMany(Set::class, 'set_exams');
    }
}
