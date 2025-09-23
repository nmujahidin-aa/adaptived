<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Instruction extends Model
{
    use HasTrixRichText;   

    protected $table = 'worksheet_instructions';
    protected $guarded = [];

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function answers()
    {
        return $this->hasMany(GroupAnswer::class, 'worksheet_instruction_id');
    }
}
