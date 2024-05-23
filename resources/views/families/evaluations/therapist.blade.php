@php
    $emptyTherapistEvaluationModel = new App\Models\TherapistEvaluation();

    $negative_qualities = $emptyTherapistEvaluationModel->getNegativeQualitiesAttributes();
    $positive_qualities = $emptyTherapistEvaluationModel->getPositiveQualitiesAttributes();
@endphp

<x-app-layout>
    <x-slot name="header">
            <h2 class="text-2xl font-semibold text-gray-700  ">
                {{ __('Visualizar Avaliação') }}
            <span class="text-lg text-slate-600">Avaliação da Profissional sobre cada encontro Terapêutico</span>
            </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form action="#" method="POST" class="mx-auto" onsubmit="false">

                    <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
                    <input type="hidden" name="eval_type" value="{{ $evalType }}">
                    @csrf

                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="therapist_name" class="block text-gray-700 font-bold mb-2">Profissional</label>
                            <input type="text" name="therapist_name" id="therapist_name" value="{{ $familyMember->therapist->name }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled />
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="family_member_name" class="block text-gray-700 font-bold mb-2">Criança</label>
                            <input type="text" name="family_member_name" id="family_member_name" value="{{ $familyMember->name }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled />
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="family_member_group" class="block text-gray-700 font-bold mb-2">Turma</label>
                            <input type="text" name="family_member_group" id="family_member_group" value="{{ $familyMember->groupMember->group->name }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="family_member_schedule" class="block text-gray-700 font-bold mb-2">Horário</label>
                            <input type="text" name="family_member_schedule" id="family_member_schedule" value="{{ $familyMember->groupMember->groupSchedule->getDayNameAttribute() . ", " . $familyMember->groupMember->groupSchedule->start  ." às ".  $familyMember->groupMember->groupSchedule->end }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                        </div>
                    </div>
                    <hr class="mb-12 mt-4">
                    <h3 class="text-2xl font-bold pb-4">Questionário</h3>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="meeting_date" class="block text-gray-700 font-bold mb-2">Realizado Em: <!--\Carbon\Carbon::parse($evaluation->meeting_date)->format('Y-m-d')--> </label>
                            <input type="date" name="meeting_date" id="meeting_date" value="{{ $evaluation->meeting_date ?? old('meeting_date') }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="child_presence" class="block text-gray-700 font-bold mb-2">Presença da Criança:</label>
                            <input type="text" name="child_presence" id="child_presence" value="{{ $evaluation->child_presence == 1 ? 'Esteve presente' : 'Não esteve presente' }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                            @error('child_presence')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3 border-r-2 border-r-gray-200">
                            <h3 class="mt-12 mb-2 text-xl font-bold pb-4 text-justify mr-12">Quais as maiores dificuldades apresentadas neste encontro? </h3>
                            @foreach ($negative_qualities as $qualityKey => $qualityMessage )
                            <div class="grid grid-cols-1 gap-2 mb-2">
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="{{ $qualityKey }}" class="inline-flex items-center">
                                        <input disabled id="{{ $qualityKey }}" name="{{ $qualityKey }}" value="1" @checked($evaluation[$qualityKey] ?? old($qualityKey)) type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="block text-gray-700 font-bold ml-2 text-sm">{{ $qualityMessage }}</span>
                                    </label>
                                    @error($qualityKey)
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <h3 class="mt-12 mb-2 text-xl font-bold pb-4 text-justify mr-12">Quais habilidades você percebe a criança já exercitando durante os encontros?</h3>
                            @foreach ($positive_qualities as $qualityKey => $qualityMessage )
                            <div class="grid grid-cols-1 gap-2 mb-2">
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="{{ $qualityKey }}" class="inline-flex items-center">
                                        <input disabled id="{{ $qualityKey }}" name="{{ $qualityKey }}" value="1" @checked($evaluation[$qualityKey] ?? old($qualityKey)) type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="block text-gray-700 font-bold ml-2 text-sm">{{ $qualityMessage }}</span>
                                    </label>
                                    @error($qualityKey)
                                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex w-full items-end justify-end mt-12">
                        <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="text-gray-700 hover:text-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center border-1 mx-2">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
