<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'schools';
    protected $fillable = [
        'name', 
        'short_name',
        'address', 
        'email', 
        'phone',
        'website',
        'logo',
        'status',
    ];


    public function getLogo(){
        return $this->logo ? asset('storage/public/' . $this->logo) : asset('assets/img/160x160/img2.jpg');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
