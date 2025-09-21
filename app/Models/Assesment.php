<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Assesment extends Model
{
    use HasTrixRichText;

    protected $guarded = [];

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function variable(){
        return $this->belongsTo(Variable::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
