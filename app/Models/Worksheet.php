<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Worksheet extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_worksheets');
    }

    public function user(){
        return $this->hasMany(Worksheet::class, 'teacher_id', 'id');
    }

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'worksheet_id');
    }

    public function groupWorksheets()
    {
        return $this->hasMany(GroupWorksheet::class, 'worksheet_id');
    }

    public function groupAnswers()
    {
        return $this->hasMany(GroupAnswer::class, 'worksheet_id');
    }
}
