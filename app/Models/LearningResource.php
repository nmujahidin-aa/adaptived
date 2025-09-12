<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class LearningResource extends Model
{
    use HasTrixRichText;

    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function getCover(){
        return $this->cover ? asset('storage/public/' . $this->cover) : asset('assets/img/160x160/img2.jpg');
    }
}
