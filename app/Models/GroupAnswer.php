<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class GroupAnswer extends Model
{
    use HasTrixRichText;
    protected $table = 'group_answers';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function instruction()
    {
        return $this->belongsTo(Instruction::class, 'worksheet_instruction_id');
    }
}
