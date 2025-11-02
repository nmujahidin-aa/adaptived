<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupWorksheet extends Model
{
    protected $table = 'group_worksheets';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class, 'worksheet_id');
    }
}
