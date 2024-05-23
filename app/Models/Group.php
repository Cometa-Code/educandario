<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'name',
    ];

    public function schedules()
    {
        return $this->hasMany(GroupSchedule::class);
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function scopeByTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }
}
