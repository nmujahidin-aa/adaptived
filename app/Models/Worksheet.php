<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Worksheet extends Model
{
    use HasTrixRichText;
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'worksheet_id');
    }
}
