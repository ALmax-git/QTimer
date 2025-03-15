<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    protected $fillable = [
        'text',
        'code_snippet',
        'answer_explanation',
        'image',
        'more_info_link',
        'subject_id',
    ];
    public function subject()
    {
        return $this->belongsToMany(Subject::class, 'subject_questions');
    }


    public function answers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
