<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    protected $fillable = [
        'user_id',
        'exam_id',
        'question_id',
        'option_id',
        'is_correct',
    ];
}
