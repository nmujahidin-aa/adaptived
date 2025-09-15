<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function worksheet()
    {
        return $this->belongsTo(Worksheet::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'group_members')
                    ->withPivot('role'); 
    }

    public function role_leader()
    {
        return $this->hasOne(Member::class)->where('role_in_team', 'leader');
    }

    public function role_member()
    {
        return $this->hasMany(Member::class)->where('role_in_team', 'member');
    }
}
