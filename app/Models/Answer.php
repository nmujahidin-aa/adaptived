<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Answer extends Model
{
    use HasTrixRichText;

    protected $table = 'answers';
    protected $guarded = [];

    public function assesment(){
        return $this->belongsTo(Assesment::class, 'assesment_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }  
}
