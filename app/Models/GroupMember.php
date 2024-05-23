<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FamilyMember;

class GroupMember extends Model // GroupSchedule with Member
{
    use HasFactory;


    protected $table = 'groups_members';

    protected $fillable = [
        'group_id',
        'family_member_id',
        'group_schedule_id',
        'status',
        'status_date'
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class);
    }

    public function childrenEvaluations()
    {
        return $this->hasMany(ChildEvaluation::class);
    }

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Ativo' : 'Inativo';
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByGroup($query, $group_id)
    {
        return $query->where('group_id', $group_id);
    }

    public function scopeByFamilyMember($query, $family_member_id)
    {
        return $query->where('family_member_id', $family_member_id);
    }

    public function scopeByGroupSchedule($query, $group_schedule_id)
    {
        return $query->where('group_schedule_id', $group_schedule_id);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByTherapist($query, $therapist_id)
    {
        return $query->whereHas('familyMember.family', function ($query) use ($therapist_id) {
            $query->where('therapist_id', $therapist_id);
        });
    }
}
