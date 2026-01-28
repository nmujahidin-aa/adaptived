<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Te7aHoudini\LaravelTrix\Traits\HasTrixRichText;

class Guide extends Model
{
    use HasTrixRichText;

    protected $table = 'guides';
    protected $fillable = ['content'];
}
