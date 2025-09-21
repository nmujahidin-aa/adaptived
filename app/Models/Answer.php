<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Answer extends Model
{
    use HasTrixRichText;

    protected $table = 'group_answers';
    protected $guarded = [];

    public function assesment(){
        return $this->belongsTo(Assesment::class, 'assesment_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }  

    public function trix(){
        //
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class, 'worksheet_instruction_id');
    }
}
