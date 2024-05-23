@php
    $evaluationTypes = [
        0 => 'therapist',
        1 => 'family',
        2 => 'child'
    ];
@endphp


<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Avaliações') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="sm:flex">
                <div class="items-center mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3 inline-flex" action="{{ route('families.evaluations') }}" method="GET">
                        <label for="search" class="sr-only">Buscar</label>
                        <div class="relative lg:w-64 xl:w-96">
                            <div class="relative text-gray-500 focus-within:text-gray-600">
                                <input type="text" name="search" id="search" value="{{ request()->search ?? '' }}" class="pl-4 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-2 focus:ring-primary-300 block w-full p-2.5 focus:outline-none" placeholder="Buscar">
                                <button class="absolute inset-y-0 right-0 px-4 text-sm font-medium text-white transition-colors duration-150 bg-gray-600 border border-transparent rounded-r-md active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-purple">
                                    <i class="bi bi-search"></i>
                                </button>
                              </div>
                        </div>

                        <div class="relative ml-4" x-data="{ filterFamilyType: false }" @click.outside="filterFamilyType = false" @close.stop="filterFamilyType = false">
                            <button type="button" @click="filterFamilyType = ! filterFamilyType" class="mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                                <span data-bs-toggle="tooltip" data-bs-title="Selecione e clique na Lupa">Filtrar por</span>
                                <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="filterFamilyType"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                style="display: none;"
                                @click="filterFamilyType = false">
                                <div class="absolute z-50 w-60 pt-4 mt-2 bg-white rounded-lg shadow">
                                    <ul class="space-y-2 text-sm">
                                        <li class="flex items-center">
                                            <input id="filterByDocument" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="memberDocument" @if (request()->filterFamilyType == "memberDocument") checked @endif>
                                            <label for="filterByDocument" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">CPF da Criança</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByMemberName" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="memberName" @if (request()->filterFamilyType == "memberName") checked @endif>
                                            <label for="filterByMemberName" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nome da Criança</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="relative ml-0" x-data="{ filterEvaluationType: false }" @click.outside="filterEvaluationType = false" @close.stop="filterEvaluationType = false">
                            <button type="button" @click="filterEvaluationType = ! filterEvaluationType" class="mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                                <span data-bs-toggle="tooltip" data-bs-title="Selecione e clique na Lupa">Tipo de Avaliação</span>
                                <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="filterEvaluationType"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                style="display: none;"
                                @click="filterEvaluationType = false">
                                <div class="absolute z-50 w-60 pt-4 mt-2 bg-white rounded-lg shadow">
                                    <ul class="space-y-2 text-sm">
                                        <li class="flex items-center">
                                            <input id="filterByEvalAll" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="all" @if (request()->filterEvaluationType == "all") checked @endif>
                                            <label for="filterByEvalAll" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Todos</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByEvalTherapist" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="therapist" @if (request()->filterEvaluationType == "therapist") checked @endif>
                                            <label for="filterByEvalTherapist" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Profissional</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByEvalChild" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="child" @if (request()->filterEvaluationType == "child") checked @endif>
                                            <label for="filterByEvalChild" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Percepção da Criança</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByEvalFamily" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="family" @if (request()->filterEvaluationType == "family") checked @endif>
                                            <label for="filterByEvalFamily" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Percepção dos Pais</label>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="py-0 mt-6 mb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="w-full overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="w-full overflow-x-auto">
                        <table class="w-full whitespace-no-wrap">
                            <thead>
                                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                    <th class="px-4 py-3">Criança</th>
                                    <th class="px-4 py-3">Documento</th>
                                    <th class="px-4 py-3">Terapeuta</th>
                                    <th class="px-4 py-3 text-center">Tipo de Avaliação</th>
                                    <th class="px-4 py-3 text-center">Data do Encontro</th>
                                    <th class="px-4 py-3">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($evaluations as $evaluation)
                                <tr class="text-gray-700 hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full" src="{{ Storage::url('uploads/'.$evaluation->familyMember->avatar) }}" alt="" loading="lazy">
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ $evaluation->familyMember->name }}</div>
                                                @isset($evaluation->familyMember->groupMember)
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ $evaluation->groupMember->group->name }}</div>
                                                    <div class="font-semibold text-xs text-gray-600 dark:text-gray-400">{{ $evaluation->groupMember->groupSchedule->getDayNameAttribute() }}, {{ $evaluation->groupMember->groupSchedule->start }} às {{ $evaluation->groupMember->groupSchedule->end }}</div>
                                                @endisset
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">{{ formatCPF($evaluation->familyMember->document) }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">
                                        <div class="flex items-center text-sm">
                                            <div>
                                                <div class="font-semibold">{{ $evaluation->therapist->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-xs whitespace-nowrap text-center">
                                        @if ($evaluation->type == 0)
                                            <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:bg-orange-700 dark:text-orange-100">Avaliação Profissional</span>
                                        @endif
                                        @if ($evaluation->type == 2)
                                            <span class="px-2 py-1 font-semibold leading-tight text-blue-700 bg-blue-100 rounded-full dark:bg-blue-700 dark:text-blue-100">Percepção da Criança</span>
                                        @endif
                                        @if ($evaluation->type == 1)
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Percepção dos Pais</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap text-center">{{ \Carbon\Carbon::parse($evaluation->meeting_date)->format('d/m/y') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a data-bs-toggle="tooltip" data-bs-title="Ver Avaliação" href="{{ route('families.evaluations.view', ['id' => $evaluation->id, 'evalType' => $evaluationTypes[$evaluation->type] ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-pencil-square"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="flex w-full justify-center items-end my-2">
                             {{ $evaluations->links('pagination::tailwind') }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
