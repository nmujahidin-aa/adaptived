<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'assesment_questions';

    protected $fillable = [
        'assesment_variable_id',
        'question',
        'type'
    ];

    public function variable()
    {
        return $this->belongsTo(Variable::class, 'assesment_variable_id');
    }

    
}
