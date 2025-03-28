<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{

    protected $fillable = [
        'user_id',
        'exam_id',
        'result',
        'time_spent',
        'total_question_count',
        'attempt_question_count',
        'status',
        'started_at',
        'submitted_at',
        'last_seen_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_answers', 'exam_id', 'question_id');
    }
}
