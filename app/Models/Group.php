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

    public function worksheets()
    {
        return $this->belongsToMany(Worksheet::class, 'group_worksheets');
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

    public function instructions()
    {
        return $this->hasMany(Instruction::class, 'worksheet_id', 'worksheet_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'group_id', 'id');
    }

    public function getStatusAttribute()
    {
        $totalInstruksi = $this->instructions()->count();
        $totalJawaban   = $this->answers()->count();

        if ($totalJawaban == 0) {
            return ['label' => 'Belum dikerjakan', 'class' => 'bg-soft-danger text-danger'];
        } elseif ($totalJawaban < $totalInstruksi) {
            return ['label' => 'In progress', 'class' => 'bg-soft-primary text-primary'];
        } else {
            return ['label' => 'Selesai', 'class' => 'bg-soft-success text-success'];
        }
    }
}
