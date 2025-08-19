<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'user_answers_to_assesment_questions';

    protected $fillable = [
        'user_id',
        'assesment_question_id',
        'answer',
    ];
}
