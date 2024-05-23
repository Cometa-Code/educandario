<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create("pt_BR");
        // use pt-br faker provider
        $faker->addProvider(new \Faker\Provider\pt_BR\Person($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\Address($faker));
        $faker->addProvider(new \Faker\Provider\pt_BR\PhoneNumber($faker));

        $today = Carbon::now()->setTimezone('America/Sao_Paulo');

        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@educandario.com',
            'superadmin' => true,
            'password' => Hash::make('123456'),
            'active' => true,
        ]);

        $therapist = \App\Models\User::create([
            'name' => 'Terapeuta',
            'email' => 'terapeuta@educandario.com',
            'superadmin' => false,
            'password' => Hash::make('123456'),
            'active' => true,
        ]);

        $groups = [
            "Turma De 4 Anos" => [
                [ "day" => 2, "start" => "8:00", "end" => "9:20" ],
                [ "day" => 2, "start" => "13:30", "end" => "14:50" ],
            ],
            "Turma De 5 À 6 Anos" => [
                [ "day" => 2, "start" => "10:40", "end" => "12:00" ],
                [ "day" => 2, "start" => "14:00", "end" => "15:20" ],
            ],
            "Turma De 7 À 8 Anos" => [
                [ "day" => 2, "start" => "15:40", "end" => "17:00" ],
            ],
            "Turma De 9 À 10 Anos" => [
                [ "day" => 7, "start" => "8:30", "end" => "9:50" ],
                [ "day" => 2, "start" => "10:40", "end" => "12:00" ],
            ],
            "Turma De 11 À 12 Anos" => [
                [ "day" => 7,  "start" => "8:30", "end" => "9:50" ],
                [ "day" => 2,  "start" => "8:30", "end" => "9:50" ],
            ]
        ];

        foreach ($groups as $groupName => $schedules) {
            $group = \App\Models\Group::create([
                'name' => $groupName
            ]);

            foreach ($schedules as $schedule) {
                \App\Models\GroupSchedule::create([
                    'group_id' => $group->id,
                    'day' => $schedule['day'],
                    'start' => $schedule['start'],
                    'end' => $schedule['end'],
                ]);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $familyName = $faker->firstName() ." ". $faker->lastName();
            $family = \App\Models\Family::create([
                'responsable_name' => $familyName,
                'responsable_document' => $faker->cpf(false),
                // get all name of familyName, lowercase and remove spaces and remove all special characters, add @educandario.com
                'email' => Str::slug($familyName, '') . '@educandario.com',
                'active' => true,
                'phone' => $faker->areaCode().$faker->cellphone(false),
                'address' => $faker->streetAddress(),
                'city' => $faker->city(),
                'state' => $faker->stateAbbr(),
                'zip' => $faker->postcode(),
                'avatar' => $faker->image('public/storage/uploads', 400, 300, 'people', false)
            ]);

            $members = [
                [
                    'family_id' => $family->id,
                    'therapist_id' => $admin->id,
                    'name' => $faker->firstName() ." ". $faker->lastName(),
                    'document' => $faker->cpf(false),
                    // set birth_date for childs with 3 to 12 years old using faker
                    'birth_date' => $faker->dateTimeBetween('-12 years', '-3 years')->format('Y-m-d'),
                    // set random image avatars using faker image url
                    'avatar' => $faker->image('public/storage/uploads', 400, 300, 'people', false),
                ],
                [
                    'family_id' => $family->id,
                    'therapist_id' => $therapist->id,
                    'name' => $faker->firstName() ." ". $faker->lastName(),
                    'document' => $faker->cpf(false),
                    'birth_date' => $faker->dateTimeBetween('-12 years', '-3 years')->format('Y-m-d'),
                    'avatar' => $faker->image('public/storage/uploads', 400, 300, 'people', false),
                ],
                [
                    'family_id' => $family->id,
                    'therapist_id' => $admin->id,
                    'name' => $faker->firstName() ." ". $faker->lastName(),
                    'document' => $faker->cpf(false),
                    'birth_date' => $faker->dateTimeBetween('-12 years', '-3 years')->format('Y-m-d'),
                    'avatar' => $faker->image('public/storage/uploads', 400, 300, 'people', false),
                ]
            ];

            foreach ($members as $member) {
                $familyMember = \App\Models\FamilyMember::create($member);
                // Add Random GroupSchedule to FamilyMember
                $group = \App\Models\Group::inRandomOrder()->first();
                $groupSchedule = \App\Models\GroupSchedule::where('group_id', $group->id)->inRandomOrder()->first();
                \App\Models\GroupMember::create([
                    'group_id' => $group->id,
                    'family_member_id' => $familyMember->id,
                    'group_schedule_id' => $groupSchedule->id,
                    'status' => 0
                ]);
            }
        }

        $familyMembers = \App\Models\FamilyMember::all();
        foreach ($familyMembers as $familyMember) {
            // create 10 random therapists evaluations
            $meetingType = 0;
            for ($i = 0; $i < 6; $i++) {
                $meetingDate = Carbon::now()->setTimezone('America/Sao_Paulo');
                if ($meetingType == 0) { $meetingDate = $meetingDate->subDays(rand(60, 90)); }
                if ($meetingType == 1) { $meetingDate = $meetingDate->subDays(rand(20, 50)); }
                if ($meetingType == 2) { $meetingDate = $meetingDate->subDays(rand(0, 10)); }

                $evaluation = \App\Models\TherapistEvaluation::create([
                    'therapist_id' => $familyMember->therapist_id,
                    'family_id' => $familyMember->family->id,
                    'family_member_id' => $familyMember->id,
                    'group_member_id' => $familyMember->groupMember->id,
                    'meeting_type' => $meetingType,
                    'meeting_date' => $meetingDate,

                    'child_presence' => rand(0, 1),
                    // Negative Qualities
                    'lack_learn_taste' => rand(0, 1),
                    'rigidity' => rand(0, 1),
                    'agit_hyperact' => rand(0, 1),
                    'inflexibility' => rand(0, 1),
                    'shyness' => rand(0, 1),
                    'perfectionism' => rand(0, 1),
                    'pride' => rand(0, 1),
                    'impatience' => rand(0, 1),
                    'diff_persevering' => rand(0, 1),
                    'diff_safety_confidence' => rand(0, 1),
                    'egocentrism' => rand(0, 1),
                    'diff_sharing' => rand(0, 1),
                    'need_attention_selfesteem' => rand(0, 1),
                    'anxiety' => rand(0, 1),
                    'resentment_difficulty' => rand(0, 1),
                    'inadequate_vocab' => rand(0, 1),
                    'lack_respect' => rand(0, 1),
                    'lie_inauthenticity' => rand(0, 1),
                    'laziness_inertia' => rand(0, 1),
                    'lack_empathy' => rand(0, 1),
                    'lack_prudence_care' => rand(0, 1),

                    // Positive Qualities
                    'patience' => rand(0, 1),
                    'cooperation' => rand(0, 1),
                    'humility' => rand(0, 1),
                    'flexibility' => rand(0, 1),
                    'respect' => rand(0, 1),
                    'love' => rand(0, 1),
                    'perseverance' => rand(0, 1),
                    'security' => rand(0, 1),
                    'authenticity' => rand(0, 1),
                    'trust' => rand(0, 1),
                    'courage' => rand(0, 1),
                    'effort_achievement' => rand(0, 1),
                    'life_learning_feeling' => rand(0, 1),
                    'divine_affiliation_feeling' => rand(0, 1),
                    'concentration_attention' => rand(0, 1),
                    'self_control' => rand(0, 1),
                    'forgiveness' => rand(0, 1),
                    'tolerance' => rand(0, 1),
                    'calmness' => rand(0, 1),
                    'self_esteem' => rand(0, 1),
                    'empathy' => rand(0, 1),
                    'altruism' => rand(0, 1),
                    'assertiveness' => rand(0, 1),
                    'obedience' => rand(0, 1),
                    'docility' => rand(0, 1),
                    'truth' => rand(0, 1),
                    'gratitude' => rand(0, 1),
                    'generosity' => rand(0, 1),
                    'prudence_care' => rand(0, 1),
                ]);

                if ($i > 0 && $i < 4) $meetingType = 1;
                else $meetingType++;

                if ($meetingType > 2) { $meetingType = 0; }
            }

            // create 10 random family evaluations
            $meetingType = 0;
            for ($i = 0; $i < 3; $i++) {
                if ($meetingType == 1) { $meetingType++; continue; }
                $meetingDate = Carbon::now()->setTimezone('America/Sao_Paulo');
                if ($meetingType == 0) { $meetingDate = $meetingDate->subDays(rand(60, 90)); }
                if ($meetingType == 1) { $meetingDate = $meetingDate->subDays(rand(20, 50)); }
                if ($meetingType == 2) { $meetingDate = $meetingDate->subDays(rand(0, 10)); }

                $evaluation = \App\Models\FamilyEvaluation::create([
                    'therapist_id' => $familyMember->therapist_id,
                    'family_id' => $familyMember->family->id,
                    'family_member_id' => $familyMember->id,
                    'group_member_id' => $familyMember->groupMember->id,
                    'meeting_type' => $meetingType,
                    'meeting_date' => $meetingDate,

                    // Emotions
                    'anger' => rand(0, 1),
                    'anxiety' => rand(0, 1),
                    'sadness' => rand(0, 1),
                    'fear' => rand(0, 1),
                    'impatience' => rand(0, 1),
                    'rigidity' => rand(0, 1),
                    'agitation' => rand(0, 1),

                    // Answers to the following questions are given on a scale of 1 to 10
                    'concentration_attention_level' => rand(0, 10),
                    'cooperation_level' => rand(0, 10),
                    'emotional_regulation_level' => rand(0, 10),
                    'learning_taste_level' => rand(0, 10),

                    // Child Qualities
                    'patience' => rand(0, 1),
                    'cooperation' => rand(0, 1),
                    'humility' => rand(0, 1),
                    'flexibility' => rand(0, 1),
                    'respect' => rand(0, 1),
                    'love' => rand(0, 1),
                    'perseverance' => rand(0, 1),
                    'security' => rand(0, 1),
                    'authenticity' => rand(0, 1),
                    'trust' => rand(0, 1),
                    'courage' => rand(0, 1),
                    'effort_achievement' => rand(0, 1),
                    'life_learning_feeling' => rand(0, 1),
                    'divine_affiliation_feeling' => rand(0, 1),
                    'concentration_attention' => rand(0, 1),
                    'self_control' => rand(0, 1),
                    'forgiveness' => rand(0, 1),
                    'tolerance' => rand(0, 1),
                    'calmness' => rand(0, 1),
                    'self_esteem' => rand(0, 1),
                    'empathy' => rand(0, 1),
                    'altruism' => rand(0, 1),
                    'assertiveness' => rand(0, 1),
                    'obedience' => rand(0, 1),
                    'docility' => rand(0, 1),
                    'truth' => rand(0, 1),
                    'gratitude' => rand(0, 1),
                    'generosity' => rand(0, 1),
                    'prudence_care' => rand(0, 1),
                ]);

                $meetingType++;
                if ($meetingType > 2) { $meetingType = 0; }
            }

            // create 10 random child evaluations with lorem ipsums on answers texts
            $meetingType = 0;
            for ($i = 0; $i < 3; $i++) {
                if ($meetingType == 1) { $meetingType++; continue; }
                $meetingDate = Carbon::now()->setTimezone('America/Sao_Paulo');
                if ($meetingType == 0) { $meetingDate = $meetingDate->subDays(rand(60, 90)); }
                if ($meetingType == 1) { $meetingDate = $meetingDate->subDays(rand(20, 50)); }
                if ($meetingType == 2) { $meetingDate = $meetingDate->subDays(rand(0, 10)); }

                $evaluation = \App\Models\ChildEvaluation::create([
                    'therapist_id' => $familyMember->therapist_id,
                    'family_id' => $familyMember->family->id,
                    'family_member_id' => $familyMember->id,
                    'group_member_id' => $familyMember->groupMember->id,
                    'meeting_type' => $meetingType,
                    'meeting_date' => $meetingDate,

                    // Subjective Answers
                    'like_most_parents' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt',
                    'mom_unhappy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt',
                    'dad_unhappy' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt',
                    'ask_mom' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt',
                    'ask_dad' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla nec odio nec nunc tincidunt tincidunt',

                    'aunt_like' => rand(0, 10),
                ]);

                $meetingType++;
                if ($meetingType > 2) { $meetingType = 0; }
            }
        }

        // Populate CalendarSchedules with GroupSchedules
        $familyMembers = \App\Models\FamilyMember::inRandomOrder()->get();
        // every family member will have a calendar schedule for each group schedule
        foreach ($familyMembers as $familyMember) {
            $groupMember = $familyMember->groupMember;
            $groupSchedule = $groupMember->groupSchedule;
            $today = Carbon::now()->setTimezone('America/Sao_Paulo');
            for ($weekOffset = -4; $weekOffset <= 4; $weekOffset++) {
                // get the week offset from current week
                $currentWeek = $today->copy()->addWeeks($weekOffset)->weekOfYear;
                // get the day of $currentWeek that is the same as $groupSchedule->day
                $dayOfWeek = $today->copy()->setISODate($today->year, $currentWeek, $groupSchedule->day-1)->format('Y-m-d');
                // set $dayOfWeek with the same time as $groupSchedule->start and $groupSchedule->end
                $start = Carbon::parse($dayOfWeek . ' ' . $groupSchedule->start);
                $end = Carbon::parse($dayOfWeek . ' ' . $groupSchedule->end);

                \App\Models\CalendarSchedule::create([
                    'therapist_id' => $familyMember->therapist_id,
                    'family_id' => $familyMember->family->id,
                    'family_member_id' => $familyMember->id,
                    'group_member_id' => $groupMember->id,
                    'group_schedule_id' => $groupSchedule->id,
                    'start' => $start,
                    'end' => $end,
                ]);
            }
        }


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
