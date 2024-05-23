<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildEvaluation extends Model
{
    use HasFactory;

    protected $table = 'children_evaluations';

    protected $fillable = [
        'therapist_id',
        'family_id',
        'family_member_id',
        'group_member_id',
        'meeting_date',

        // Subjective Answers
        'like_most_parents',
        'mom_unhappy',
        'dad_unhappy',
        'ask_mom',
        'ask_dad',

        'aunt_like',
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

    public function scopeByTherapist($query, $therapist_id)
    {
        return $query->where('therapist_id', $therapist_id);
    }

    public function getAnswersAttribute()
    {
        return [
            'like_most_parents' => 'O que você mais gosta em seus pais?',
            'mom_unhappy' => 'O que sua mãe faz que não te deixa feliz?',
            'dad_unhappy' => 'O que sua pai faz que não te deixa feliz?',
            'ask_mom' => 'Se pudesse pedir algo para sua mãe, o que mais pediria para ela agora?',
            'ask_dad' => 'Se pudesse pedir algo para seu, o que mais pediria para ele agora?',
        ];
    }

    public function getScaleAnswerAttribute()
    {
        return [
            'aunt_like' => 'Sobre a tia que fica com você na sala do Educandário, o quanto você gosta dela de 0 a 10? (0 não gosta nada e 10 gosta muito)',
        ];
    }
}
