<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    protected $table = 'variables';
    protected $fillable = [
        'icon', 
        'name',
        'status',
        'image',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, 'variable_id', 'id');
    }

    /**
     * Dapatkan pertanyaan tipe short_answer untuk Variabel (Assesment) ini.
     */
    public function shortAnswerQuestions()
    {
        return $this->hasMany(Question::class, 'variable_id', 'id')
                    ->where('type', 'short_answer');
    }

    /**
     * Dapatkan pertanyaan tipe essay untuk Variabel (Assesment) ini.
     */
    public function essayQuestions()
    {
        return $this->hasMany(Question::class, 'assesment_variable_id', 'id')
                    ->where('type', 'essay'); 
    }
    
}
