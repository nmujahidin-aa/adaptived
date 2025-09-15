<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'group_members';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
