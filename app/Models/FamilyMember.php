<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $table = 'families_members';

    protected $fillable = [
        'family_id',
        'therapist_id',
        'name',
        'document',
        'birth_date',
        'avatar',
        'obs',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function groupMember()
    {
        return $this->hasOne(GroupMember::class);
    }

    public function therapistEvaluations()
    {
        return $this->hasMany(TherapistEvaluation::class);
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }

    public function calendarSchedules()
    {
        return $this->hasMany(CalendarSchedule::class);
    }

    public function scopeByTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }

    public function scopeByFamily($query, $familyId)
    {
        return $query->where('family_id', $familyId);
    }

}
