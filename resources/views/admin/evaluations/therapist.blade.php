@php
    $emptyTherapistEvaluationModel = new App\Models\TherapistEvaluation();

    $negative_qualities = $emptyTherapistEvaluationModel->getNegativeQualitiesAttributes();
    $positive_qualities = $emptyTherapistEvaluationModel->getPositiveQualitiesAttributes();
@endphp

<x-app-layout>
    <x-slot name="header">
            <h2 class="text-2xl font-semibold text-gray-700  ">
            @if (empty($evaluation))
                {{ __('Nova Avaliação:') }}
            @else
                {{ __('Editar Avaliação') }}
            @endif
            <span class="text-lg text-slate-600">Avaliação da Profissional sobre cada encontro Terapêutico</span>
            </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if (empty($evaluation))
                <form action="{{ route('admin.evaluations.store.therapist') }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                @elseif (!empty($evaluation) && $superAdmin)

                <div class="grid grid-cols-6 gap-6 mb-8">
                    <div class="col-span-6 sm:col-span-3">
                        <a href="{{ route('admin.families.edit', ['id' => $familyMember->family->id, '#familyMembersArea' ]) }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center border-1">Ver Família</a>
                    </div>
                </div>

                <form action="{{ route('admin.evaluations.update.therapist', ['id' => $evaluation->id]) }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                    <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">
                @else

                <div class="grid grid-cols-6 gap-6 mb-8">
                    <div class="col-span-6 sm:col-span-3">
                        <a href="{{ route('admin.families.edit', ['id' => $familyMember->family->id, '#familyMembersArea' ]) }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center border-1">Ver Família</a>
                    </div>
                </div>

                <form action="#" method="POST" class="mx-auto" onsubmit="false">
                @endif

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
                    @if (!empty($evaluation) || $superAdmin)
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        @if ($superAdmin)
                        <div class="col-span-6 sm:col-span-3">
                            <label for="meeting_date" class="block text-gray-700 font-bold mb-2">Data Encontro</label>
                            <input type="date" name="meeting_date" id="meeting_date" value="{{ $evaluation->meeting_date ?? old('meeting_date') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @error('meeting_date')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        @else
                        <div class="col-span-6 sm:col-span-3">
                            <label for="meeting_date" class="block text-gray-700 font-bold mb-2">Realizado Em: <!--\Carbon\Carbon::parse($evaluation->meeting_date)->format('Y-m-d')--> </label>
                            <input type="date" name="meeting_date" id="meeting_date" value="{{ $evaluation->meeting_date ?? old('meeting_date') }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                        </div>
                        @endif
                    </div>
                    @endif
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="child_presence" class="block text-gray-700 font-bold mb-2">Presença da Criança:</label>
                            @if ($superAdmin || empty($evaluation))
                            <select name="child_presence" id="child_presence" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="" selected>Selecione...</option>
                                <option value="0" @if (($evaluation->child_presence ?? old('child_presence')) === 0) selected @endif>Não esteve presente</option>
                                <option value="1" @if (($evaluation->child_presence ?? old('child_presence')) === 1) selected @endif>Esteve presente</option>
                            </select>
                            @else
                            <input type="text" name="child_presence" id="child_presence" value="{{ $evaluation->child_presence == 1 ? 'Esteve presente' : 'Não esteve presente' }}" class="shadow-sm w-full px-4 py-2 border bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" disabled></input>
                            @endif
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
                                        <input @if(!$superAdmin && !empty($evaluation)) disabled @endif id="{{ $qualityKey }}" name="{{ $qualityKey }}" value="1" @checked($evaluation[$qualityKey] ?? old($qualityKey)) type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
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
                                        <input @if(!$superAdmin && !empty($evaluation)) disabled @endif id="{{ $qualityKey }}" name="{{ $qualityKey }}" value="1" @checked($evaluation[$qualityKey] ?? old($qualityKey)) type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
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
                        @if ($superAdmin || empty($evaluation))
                            <a href="{{ route('admin.families.edit', ['id' => $familyMember->family->id, '#familyMembersArea' ]) }}" class="text-gray-700 hover:text-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center border-1 mx-2">Cancelar</a>
                            <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center border-1">Salvar</button>
                        @else
                            <a href="{{ redirect()->getUrlGenerator()->previous() }}" class="text-gray-700 hover:text-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center border-1 mx-2">Voltar</a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
