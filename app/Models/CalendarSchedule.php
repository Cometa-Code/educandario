<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarSchedule extends Model
{
    use HasFactory;

    protected $table = 'calendar_schedules';

    protected $fillable = [
        'therapist_id',
        'family_id',
        'family_member_id',
        'group_member_id',
        'group_schedule_id',
        'start',
        'end',
    ];

    public function therapist()
    {
        return $this->belongsTo(User::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function groupMember()
    {
        return $this->belongsTo(GroupMember::class);
    }

    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class);
    }

    public function scopeByTherapist($query, $therapist_id)
    {
        return $query->where('therapist_id', $therapist_id);
    }

    public function scopeByFamily($query, $family_id)
    {
        return $query->where('family_id', $family_id);
    }

    public function scopeByFamilyMember($query, $family_member_id)
    {
        return $query->where('family_member_id', $family_member_id);
    }

    public function scopeByGroupMember($query, $group_member_id)
    {
        return $query->where('group_member_id', $group_member_id);
    }

    public function scopeByGroupSchedule($query, $group_schedule_id)
    {
        return $query->where('group_schedule_id', $group_schedule_id);
    }

}
