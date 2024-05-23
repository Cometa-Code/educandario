<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupSchedule extends Model
{
    use HasFactory;

    protected $table = 'groups_schedules';

    protected $fillable = [
        'active',
        'group_id',
        'day',
        'start',
        'end',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function calendarSchedules()
    {
        return $this->hasMany(CalendarSchedule::class);
    }

    public function members()
    {
        return $this->hasMany(GroupMember::class);
    }

    public function getDaysAttribute()
    {
        $days = [
            1 => 'Domingo',
            2 => 'Segunda-feira',
            3 => 'Terça-feira',
            4 => 'Quarta-feira',
            5 => 'Quinta-feira',
            6 => 'Sexta-feira',
            7 => 'Sábado',
        ];

        return $days;
    }

    public function getDayNameAttribute()
    {
        $days = $this->getDaysAttribute();

        return $days[$this->day];
    }

    public function getStartAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getEndAttribute($value)
    {
        return date('H:i', strtotime($value));
    }

    public function getScheduleAttribute()
    {
        return "{$this->day_name} - {$this->start} às {$this->end}";
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeDay($query, $day)
    {
        return $query->where('day', $day);
    }

    public function scopeTime($query, $time)
    {
        return $query->where('start', '<=', $time)->where('end', '>=', $time);
    }

    public function scopeToday($query)
    {
        return $query->day(date('N'));
    }

    public function scopeNow($query)
    {
        return $query->time(date('H:i'));
    }

    public function scopeTodayNow($query)
    {
        return $query->today()->now();
    }

    public function scopeGroup($query, $group)
    {
        return $query->where('group_id', $group);
    }


}
