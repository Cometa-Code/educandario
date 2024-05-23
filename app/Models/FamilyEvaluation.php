<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyEvaluation extends Model
{
    use HasFactory;

    protected $table = 'families_evaluations';

    protected $fillable = [
        'therapist_id',
        'family_id',
        'family_member_id',
        'group_member_id',
        'meeting_date',

        // Emotions
        'anger',
        'anxiety',
        'sadness',
        'fear',
        'impatience',
        'rigidity',
        'agitation',

        // Answers to the following questions are given on a scale of 1 to 10
        'concentration_attention_level',
        'cooperation_level',
        'emotional_regulation_level',
        'learning_taste_level',

        // Child Qualities
        'patience',
        'cooperation',
        'humility',
        'flexibility',
        'respect',
        'love',
        'perseverance',
        'security',
        'authenticity',
        'trust',
        'courage',
        'effort_achievement',
        'life_learning_feeling',
        'divine_affiliation_feeling',
        'concentration_attention',
        'self_control',
        'forgiveness',
        'tolerance',
        'calmness',
        'self_esteem',
        'empathy',
        'altruism',
        'assertiveness',
        'obedience',
        'docility',
        'truth',
        'gratitude',
        'generosity',
        'prudence_care',
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

    public function scopeByFamilyMember($query, $familyMemberId)
    {
        return $query->where('family_member_id', $familyMemberId);
    }

    public function scopeByFamily($query, $familyId)
    {
        return $query->where('family_id', $familyId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }

    public function getEmotionsAttributes()
    {
        return [
            'anger' => 'Raiva',
            'anxiety' => 'Ansiedade',
            'sadness' => 'Tristeza',
            'fear' => 'Medo',
            'impatience' => 'Impaciência',
            'rigidity' => 'Rigidez',
            'agitation' => 'Agitação',
        ];
    }

    public function getScaleAnswersAttributes()
    {
        return [
            'concentration_attention_level' => 'Qual o Nível de Concentração e Atenção a sua criança tem demonstrado ter neste momento:',
            'cooperation_level' => 'Qual o Nível de Cooperação em realizar os deveres a sua criança tem demonstrado ter neste momento:',
            'emotional_regulation_level' => 'Qual o Nível de prática em Regulação Emocional a sua criança tem demonstrado ter quando percebe em desequilíbrio neste momento:',
            'learning_taste_level' => 'Qual o Nível de gosto pela Aprendizagem Escolar sua criança está demonstrando ter na escola neste momento:',
        ];
    }

    public function getChildQualitiesAttributes()
    {
        return [
            'patience' => 'Paciência',
            'cooperation' => 'Cooperação',
            'humility' => 'Humildade',
            'flexibility' => 'Flexibilidade',
            'respect' => 'Respeito',
            'love' => 'Amor',
            'perseverance' => 'Perseverança',
            'security' => 'Segurança',
            'authenticity' => 'Autenticidade',
            'trust' => 'Confiança',
            'courage' => 'Coragem',
            'effort_achievement' => 'Esforço de Realização',
            'life_learning_feeling' => 'Sentimento de Aprendizado da vida',
            'divine_affiliation_feeling' => 'Sentimento de filiação divina (conexão com uma inteligência superior no universo)',
            'concentration_attention' => 'Concentração e atenção',
            'self_control' => 'Autodomínio',
            'forgiveness' => 'Perdão',
            'tolerance' => 'Tolerância',
            'calmness' => 'Calma',
            'self_esteem' => 'Autovalorização',
            'empathy' => 'Empatia',
            'altruism' => 'Altruísmo',
            'assertiveness' => 'Assertividade',
            'obedience' => 'Obediência (no sentido de confiar nas orientações do adulto por isso as segue)',
            'docility' => 'Docilidade',
            'truth' => 'Verdade',
            'gratitude' => 'Gratidão',
            'generosity' => 'Generosidade',
            'prudence_care' => 'Prudência/Cuidado',
        ];
    }

    public function getChildQualitiesScoreAttribute()
    {
        $score = 0;

        foreach ($this->getChildQualitiesAttributes() as $qualityKey => $qualityValue) {
            $score += $this->$qualityKey;
        }

        return round($score / count($this->getChildQualitiesAttributes()) * 100, 2);
    }

    public function getScaleAnswersScoreAttribute()
    {
        $score = 0;

        foreach ($this->getScaleAnswersAttributes() as $answerKey => $answerValue) {
            $score += $this->$answerKey;
        }

        return round($score / (count($this->getScaleAnswersAttributes()) * 10) * 100, 2);
    }

    public function getEmotionsScoreAttribute()
    {
        $score = 0;

        foreach ($this->getEmotionsAttributes() as $emotionKey => $emotionValue) {
            $score += $this->$emotionKey;
        }

        return round($score / count($this->getEmotionsAttributes()) * 100, 2);
    }


}
