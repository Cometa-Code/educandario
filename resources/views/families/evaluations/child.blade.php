@php
    $emptyChildEval = new \App\Models\ChildEvaluation();

    $answersAttr = $emptyChildEval->getAnswersAttribute();
    $scaleAnswersAttr = $emptyChildEval->getScaleAnswerAttribute();

@endphp

<x-app-layout>
    <x-slot name="header">
            <h2 class="text-2xl font-semibold text-gray-700  ">
                {{ __('Visualizar Avaliação') }}
            <span class="text-lg text-slate-600">Percepção da Criança sobre os Adultos</span>
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
                    @if (!empty($evaluation))
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="meeting_date" class="block text-gray-700 font-bold mb-2">Realizado Em: <!--\Carbon\Carbon::parse($evaluation->meeting_date)->format('Y-m-d')--> </label>
                            <input type="date" name="meeting_date" id="meeting_date" value="{{ $evaluation->meeting_date ?? old('meeting_date') }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                        </div>
                    </div>
                    @endif
                    <div class="grid grid-cols-6 gap-6 mb-8 mt-12">
                        @foreach ($answersAttr as $qualityKey => $qualityMessage)
                        <div class="col-span-6 sm:col-span-3 border-r-2 border-r-gray-200 pr-4">

                            <h3 class="text-base font-bold text-justify">{{ $qualityMessage }}</h3>

                            <div class="grid grid-cols-1 gap-2">
                                <div class="col-span-4 sm:col-span-2">
                                    <textarea disabled id="{{ $qualityKey }}" name="{{ $qualityKey }}" rows="4" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="">{{ $evaluation[$qualityKey] ?? old($qualityKey) }}</textarea>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3 border-r-2 border-r-gray-200">
                        @foreach ($scaleAnswersAttr as $qualityKey => $qualityMessage )
                            <div class="grid grid-cols-1 gap-2 mb-12">
                                <div class="col-span-4 sm:col-span-2">
                                    <label for="{{ $qualityKey }}" class="inline-flex items-center">
                                        <span class="block text-gray-700 font-bold ml-2 text-md text-justify mr-12">{{ $qualityMessage }}</span>
                                    </label>
                                    <div class="mt-3">
                                        @for ($i = 0; $i <= 10; $i++)
                                            <label class="inline-flex items-center mr-2">
                                                <input disabled type="radio" class="form-radio" name="{{ $qualityKey }}" value="{{ $i }}" @if(($evaluation[$qualityKey] ?? old($qualityKey)) == $i) checked @endif>
                                                <span class="ml-2 text-sm">{{ $i }}</span>
                                            </label>

                                        @endfor
                                    </div>
                                    <span class="span text-center w-full text-xs text-gray-400">Por sua observação, medir de 0 (nada) e 10 (muito).</span>
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
