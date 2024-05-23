<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
Entidades:

Administrador
Terapeuta -> Agenda Encontros & Faz Avaliações
Familia -> Responsável & Filhos (Alunos)

Turmas: Cada turma tem um terapeuta e uma lista de alunos, As turmas são separadas por idade


Alunos: Cada aluno tem uma lista de avaliações


Avaliações -> Ter um campo de tipo de avaliação: Primeiro encontro e último encontro
Avaliação Profissional -> Avaliação feita pelo terapeuta
Avaliação Criança -> Avaliação feita pela criança
Avaliação Familiar -> Avaliação feita pelo responsável


*/


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users: Admins & Therapists
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('active')->default(0); // 0 = desativado, 1 = ativo
            $table->boolean('superadmin')->default(false); // true = admin, false = affiliate
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
            $table->index('active');
        });

        // Therapists Profiles
        Schema::create('users_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('document', 20)->unique();
            $table->string('birth_date')->nullable();
            $table->string('phone', 20);
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('specialty')->nullable();
            $table->text('avatar')->nullable();
            $table->text('obs')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

            $table->index('user_id');
            $table->index('document');


        });

        // Families: Parents & Children
        Schema::create('families', function (Blueprint $table) {
            $table->id();

            $table->integer('active')->default(0); // 0 = desativado, 1 = ativo
            $table->string('responsable_name'); // responsable name
            $table->string('responsable_document', 20); // responsable cpf or rg
            $table->string('email')->unique(); // magic link login
            $table->string('phone', 20);
            $table->string('address')->nullable();
            $table->string('zip')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->text('avatar')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('email');
            $table->index('active');
            $table->index('responsable_name');
            $table->index('responsable_document');
        });

        // Families Members: Children
        Schema::create('families_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('therapist_id');
            $table->string('name');
            $table->string('document', 20)->unique();
            $table->string('birth_date');
            $table->text('avatar')->nullable();
            $table->text('obs')->nullable();
            $table->tinyInteger('lock_evaluation')->default(0); // 0 = bloqueado, 1 = desbloqueado primero encontro, 2 = desbloqueado encontro quinzenal, 3 = desbloqueado último encontro
            $table->timestamps();

            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('therapist_id')->references('id')->on('users');

            $table->index('name');
            $table->index('family_id');
            $table->index('document');
            $table->index('therapist_id');
        });

        // Groups: Each group has a therapist and a list of students, Groups are separated by age
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
            $table->index('name');
        });

        Schema::create('groups_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->integer('active')->default(1); // 0 = desativado, 1 = ativo
            $table->string('day'); // Segunda, Terça, Quarta, Quinta, Sexta, Sábado, Domingo
            $table->time('start'); // 08:00, 09:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00
            $table->time('end'); // 08:00, 09:00, 10:00, 11:00, 12:00, 13:00, 14:00, 15:00, 16:00, 17:00, 18:00, 19:00
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');

            $table->index('group_id');
            $table->index('active');
        });

        // Groups & Family Members: Each family member can be in a group
        Schema::create('groups_members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('group_schedule_id');
            $table->tinyInteger('status')->default(0); // 0 = atendendo, 1 = concluído, 2 = cancelado/desistente
            $table->date('status_date')->nullable(); // data de alteração do status
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('group_schedule_id')->references('id')->on('groups_schedules');
            $table->foreign('family_member_id')->references('id')->on('families_members');


            $table->index('group_id');
            $table->index('family_member_id');
            $table->index('group_schedule_id');
            $table->index('status');
        });

        // Therapist Evaluations
        Schema::create('therapists_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('group_member_id');
            $table->tinyInteger('type')->default(0); // Evaluation Type: 0 = Terapeuta, 1 = Familiar, 2 = Criança
            $table->tinyInteger('meeting_type')->default(0); // 0 = Primeiro encontro, 1 = encontro quinzenal, 2 = último encontro
            $table->date('meeting_date');

            $table->tinyInteger('child_presence'); // 1 = presente, 0 = faltou

            // Negative Qualities
            $table->tinyInteger('lack_learn_taste'); // Falta de gosto pela aprendizagem
            $table->tinyInteger('rigidity'); // Rigidez
            $table->tinyInteger('agit_hyperact'); // Agitação e Hiperatividade
            $table->tinyInteger('inflexibility'); // Inflexibilidade
            $table->tinyInteger('shyness'); // Timidez
            $table->tinyInteger('perfectionism'); // Perfeccionismo
            $table->tinyInteger('pride'); // Orgulho
            $table->tinyInteger('impatience'); // Impaciência
            $table->tinyInteger('diff_persevering'); // Dificuldade em perseverar
            $table->tinyInteger('diff_safety_confidence'); // Dificuldade na segurança e confiança
            $table->tinyInteger('egocentrism'); // Egocentrismo
            $table->tinyInteger('diff_sharing'); // Dificuldade em partilhar
            $table->tinyInteger('need_attention_selfesteem'); // Necessidade de chamar atenção a si - falta de autoestima
            $table->tinyInteger('anxiety'); // Ansiedade
            $table->tinyInteger('resentment_difficulty'); // Mágoa ou dificuldade em elaborar um ressentimento
            $table->tinyInteger('inadequate_vocab'); // Vocabulário inadequado
            $table->tinyInteger('lack_respect'); // Falta de respeito
            $table->tinyInteger('lie_inauthenticity'); // Mentira e Inaltenticidade
            $table->tinyInteger('laziness_inertia'); // Preguiça e inércia
            $table->tinyInteger('lack_empathy'); // Falta de Empatia
            $table->tinyInteger('lack_prudence_care'); // Falta de prudência e cuidado

            // Positive Qualities
            $table->tinyInteger('patience'); // Paciência
            $table->tinyInteger('cooperation'); // Cooperação
            $table->tinyInteger('humility'); // Humildade
            $table->tinyInteger('flexibility'); // Flexibilidade
            $table->tinyInteger('respect'); // Respeito
            $table->tinyInteger('love'); // Amor
            $table->tinyInteger('perseverance'); // Perseverança
            $table->tinyInteger('security'); // Segurança
            $table->tinyInteger('authenticity'); // Autenticidade
            $table->tinyInteger('trust'); // Confiança
            $table->tinyInteger('courage'); // Coragem
            $table->tinyInteger('effort_achievement'); // Esforço de Realização
            $table->tinyInteger('life_learning_feeling'); // Sentimento de Aprendiza da vida
            $table->tinyInteger('divine_affiliation_feeling'); // Sentimento de filiação divina (conexão com uma inteligência superior no universo)
            $table->tinyInteger('concentration_attention'); // Concentração e atenção
            $table->tinyInteger('self_control'); // Autodomínio
            $table->tinyInteger('forgiveness'); // Perdão
            $table->tinyInteger('tolerance'); // Tolerância
            $table->tinyInteger('calmness'); // Calma
            $table->tinyInteger('self_esteem'); // Autovalorização
            $table->tinyInteger('empathy'); // Empatia
            $table->tinyInteger('altruism'); // Altruísmo
            $table->tinyInteger('assertiveness'); // Assertividade
            $table->tinyInteger('obedience'); // Obediência (no sentido de confiar nas orientações do adulto por isso as segue)
            $table->tinyInteger('docility'); // Docilidade
            $table->tinyInteger('truth'); // Verdade
            $table->tinyInteger('gratitude'); // Gratidão
            $table->tinyInteger('generosity'); // Generosidade
            $table->tinyInteger('prudence_care'); // Prudência/Cuidado


            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('family_member_id')->references('id')->on('families_members');
            $table->foreign('group_member_id')->references('id')->on('groups_members');

            $table->index('therapist_id');
            $table->index('family_id');
            $table->index('family_member_id');
            $table->index('group_member_id');
        });

        // Family Evaluations: Family Responsable Evaluation of the Child
        Schema::create('families_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('group_member_id');
            $table->tinyInteger('type')->default(1); // Evaluation Type
            $table->tinyInteger('meeting_type')->default(0); // 0 = Primeiro encontro, 1 = encontro quinzenal, 2 = último encontro
            $table->date('meeting_date');

            // Emotions
            $table->tinyInteger('anger'); // Raiva
            $table->tinyInteger('anxiety'); // Ansiedade
            $table->tinyInteger('sadness'); // Tristeza
            $table->tinyInteger('fear'); // Medo
            $table->tinyInteger('impatience'); // Impaciência
            $table->tinyInteger('rigidity'); // Rigidez
            $table->tinyInteger('agitation'); // Agitação

            // Answers to the following questions are given on a scale of 1 to 10
            $table->tinyInteger('concentration_attention_level'); // // por sua observação, medir de 0 (nada) e 10 (muito), qual o nível de concentração e atenção a sua criança tem demonstrado ter neste momento:
            $table->tinyInteger('cooperation_level'); // por sua observação, medir de 0 (nada) e 10 (muito), qual o nível de cooperação em realizar os deveres a sua criança tem demonstrado ter neste momento:
            $table->tinyInteger('emotional_regulation_level'); // Por sua observação, medir de 0 (nada) e 10 (muito), qual o nível de prática em regulação emocional a sua criança tem demonstrado ter quando percebe em desequilíbrio neste momento:
            $table->tinyInteger('learning_taste_level'); // Por sua observação, medir de 0 (nada) e 10 (muito), qual o nível de gosto pela aprendizagem escolar sua criança está demonstrando ter na escola neste momento:


            // Child Qualities
            $table->tinyInteger('patience'); // Paciência
            $table->tinyInteger('cooperation'); // Cooperação
            $table->tinyInteger('humility'); // Humildade
            $table->tinyInteger('flexibility'); // Flexibilidade
            $table->tinyInteger('respect'); // Respeito
            $table->tinyInteger('love'); // Amor
            $table->tinyInteger('perseverance'); // Perseverança
            $table->tinyInteger('security'); // Segurança
            $table->tinyInteger('authenticity'); // Autenticidade
            $table->tinyInteger('trust'); // Confiança
            $table->tinyInteger('courage'); // Coragem
            $table->tinyInteger('effort_achievement'); // Esforço de Realização
            $table->tinyInteger('life_learning_feeling'); // Sentimento de Aprendiza da vida
            $table->tinyInteger('divine_affiliation_feeling'); // Sentimento de filiação divina (conexão com uma inteligência superior no universo)
            $table->tinyInteger('concentration_attention'); // Concentração e atenção
            $table->tinyInteger('self_control'); // Autodomínio
            $table->tinyInteger('forgiveness'); // Perdão
            $table->tinyInteger('tolerance'); // Tolerância
            $table->tinyInteger('calmness'); // Calma
            $table->tinyInteger('self_esteem'); // Autovalorização
            $table->tinyInteger('empathy'); // Empatia
            $table->tinyInteger('altruism'); // Altruísmo
            $table->tinyInteger('assertiveness'); // Assertividade
            $table->tinyInteger('obedience'); // Obediência (no sentido de confiar nas orientações do adulto por isso as segue)
            $table->tinyInteger('docility'); // Docilidade
            $table->tinyInteger('truth'); // Verdade
            $table->tinyInteger('gratitude'); // Gratidão
            $table->tinyInteger('generosity'); // Generosidade
            $table->tinyInteger('prudence_care'); // Prudência/Cuidado

            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('family_member_id')->references('id')->on('families_members');
            $table->foreign('group_member_id')->references('id')->on('groups_members');

            $table->index('therapist_id');
            $table->index('family_id');
            $table->index('family_member_id');
            $table->index('group_member_id');
        });

        // Child Evaluations: Child Self Evaluation
        Schema::create('children_evaluations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('group_member_id');
            $table->tinyInteger('type')->default(2); // Evaluation Type
            $table->tinyInteger('meeting_type')->default(0); // 0 = Primeiro encontro, 1 = encontro quinzenal, 2 = último encontro
            $table->date('meeting_date');

            // Subjective Answers
            $table->text('like_most_parents'); // O que você mais gosta em seus pais?
            $table->text('mom_unhappy'); // O que sua mãe faz que não te deixa feliz?
            $table->text('dad_unhappy'); // O que sua pai faz que não te deixa feliz?
            $table->text('ask_mom'); // Se pudesse pedir algo para sua mãe, o que mais pediria para ela agora?
            $table->text('ask_dad'); // Se pudesse pedir algo para seu, o que mais pediria para ele agora?

            $table->tinyInteger('aunt_like'); // Sobre a tia que fica com você na sala do Educandário, o quanto você gosta dela de 0 a 10? (0 não gosta nada e 10 gosta muito)

            $table->timestamps();

            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('family_id')->references('id')->on('families');
            $table->foreign('family_member_id')->references('id')->on('families_members');
            $table->foreign('group_member_id')->references('id')->on('groups_members');

            $table->index('therapist_id');
            $table->index('family_id');
            $table->index('family_member_id');
            $table->index('group_member_id');
        });

        Schema::create('calendar_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('family_id');
            $table->unsignedBigInteger('family_member_id');
            $table->unsignedBigInteger('group_member_id');
            $table->unsignedBigInteger('group_schedule_id');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('calendar_schedules');
        Schema::dropIfExists('therapists_evaluations');
        Schema::dropIfExists('families_evaluations');
        Schema::dropIfExists('children_evaluations');
        Schema::dropIfExists('groups_schedules');
        Schema::dropIfExists('groups_members');
        Schema::dropIfExists('families_members');
        Schema::dropIfExists('families');
        Schema::dropIfExists('groups');
        Schema::dropIfExists('users_profiles');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
};
