<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class LearningObjective extends Model
{
    use HasTrixRichText;

    protected $table = 'learning_objectives';
    protected $fillable = ['title', 'content', 'school_id'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
