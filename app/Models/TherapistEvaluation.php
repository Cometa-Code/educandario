<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapistEvaluation extends Model
{
    use HasFactory;

    protected $table = 'therapists_evaluations';

    protected $fillable = [
        'therapist_id',
        'family_id',
        'family_member_id',
        'group_member_id',
        'meeting_date',

        'child_presence',

        // Negative Qualities
        'lack_learn_taste',
        'rigidity',
        'agit_hyperact',
        'inflexibility',
        'shyness',
        'perfectionism',
        'pride',
        'impatience',
        'diff_persevering',
        'diff_safety_confidence',
        'egocentrism',
        'diff_sharing',
        'need_attention_selfesteem',
        'anxiety',
        'resentment_difficulty',
        'inadequate_vocab',
        'lack_respect',
        'lie_inauthenticity',
        'laziness_inertia',
        'lack_empathy',
        'lack_prudence_care',

        // Positive Qualities
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

    public function scopeByTherapist($query, $therapistId)
    {
        return $query->where('therapist_id', $therapistId);
    }

    public function scopeByChildPresence($query, $childPresence)
    {
        return $query->where('child_presence', $childPresence);
    }

    public function getPositiveQualitiesAttributes()
    {
        return [
            "patience" => "Paciência",
            "cooperation" => "Cooperação",
            "humility" => "Humildade",
            "flexibility" => "Flexibilidade",
            "respect" => "Respeito",
            "love" => "Amor",
            "perseverance" => "Perseverança",
            "security" => "Segurança",
            "authenticity" => "Autenticidade",
            "trust" => "Confiança",
            "courage" => "Coragem",
            "effort_achievement" => "Esforço de Realização",
            "life_learning_feeling" => "Sentimento de Aprendiza da vida",
            "divine_affiliation_feeling" => "Sentimento de filiação divina (conexão com uma inteligência superior no universo)",
            "concentration_attention" => "Concentração e atenção",
            "self_control" => "Autodomínio",
            "forgiveness" => "Perdão",
            "tolerance" => "Tolerância",
            "calmness" => "Calma",
            "self_esteem" => "Autovalorização",
            "empathy" => "Empatia",
            "altruism" => "Altruísmo",
            "assertiveness" => "Assertividade",
            "obedience" => "Obediência (no sentido de confiar nas orientações do adulto por isso as segue)",
            "docility" => "Docilidade",
            "truth" => "Verdade",
            "gratitude" => "Gratidão",
            "generosity" => "Generosidade",
            "prudence_care" => "Prudência/Cuidado",
        ];
    }

    public function getNegativeQualitiesAttributes()
    {
        return [
            "lack_learn_taste" => "Falta de gosto pela aprendizagem",
            "rigidity" => "Rigidez",
            "agit_hyperact" => "Agitação e Hiperatividade",
            "inflexibility" => "Inflexibilidade",
            "shyness" => "Timidez",
            "perfectionism" => "Perfeccionismo",
            "pride" => "Orgulho",
            "impatience" => "Impaciência",
            "diff_persevering" => "Dificuldade em perseverar",
            "diff_safety_confidence" => "Dificuldade na segurança e confiança",
            "egocentrism" => "Egocentrismo",
            "diff_sharing" => "Dificuldade em partilhar",
            "need_attention_selfesteem" => "Necessidade de chamar atenção a si - falta de autoestima",
            "anxiety" => "Ansiedade",
            "resentment_difficulty" => "Mágoa ou dificuldade em elaborar um ressentimento",
            "inadequate_vocab" => "Vocabulário inadequado",
            "lack_respect" => "Falta de respeito",
            "lie_inauthenticity" => "Mentira e Inaltenticidade",
            "laziness_inertia" => "Preguiça e inércia",
            "lack_empathy" => "Falta de Empatia",
            "lack_prudence_care" => "Falta de prudência e cuidado",
        ];
    }

    // get score of positive qualities
    public function getPositiveQualitiesScoreAttribute()
    {
        $score = 0;

        foreach ($this->getPositiveQualitiesAttributes() as $qualityKey => $qualityValue) {
            $score += $this->$qualityKey;
        }

        return round($score / count($this->getPositiveQualitiesAttributes()) * 100, 2);
    }

    // get score of negative qualities
    public function getNegativeQualitiesScoreAttribute()
    {
        $score = 0;

        foreach ($this->getNegativeQualitiesAttributes() as $qualityKey => $qualityValue) {
            $score += $this->$qualityKey;
        }

        return round($score / count($this->getNegativeQualitiesAttributes()) * 100, 2);
    }

}
