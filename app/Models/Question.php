<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Question extends Model
{
    use HasTrixRichText;

    protected $guarded = [];

    public function assesment(){
        return $this->belongsTo(Assesment::class, 'assesment_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }
}
