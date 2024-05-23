@php
    $evaluationTypes = [
        0 => 'therapist',
        1 => 'family',
        2 => 'child'
    ];
@endphp


<x-app-layout>
    <style>
        .bg-custom-cards {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .custom-card-home {
            width: 48%;
            padding: 30px 50px;
            margin-bottom: 50px;
            border-radius: 10px;
            cursor: pointer;
            -webkit-box-shadow: -1px 0px 16px -4px rgba(217,217,217,1);
            -moz-box-shadow: -1px 0px 16px -4px rgba(217,217,217,1);
            box-shadow: -1px 0px 16px -4px rgba(217,217,217,1);
            background-color: #FFF;
            display: flex;
            align-items: center;
            transition: .2s;

            height: 130px;
        }

        .custom-card-home:hover {
            -webkit-box-shadow: -1px 0px 16px -4px rgba(179,179,179,1);
            -moz-box-shadow: -1px 0px 16px -4px rgba(179,179,179,1);
            box-shadow: -1px 0px 16px -4px rgba(179,179,179,1);
            transition: .2s;
        }

        .custom-card-home img {
            width: 80px;
        }

        .custom-card-home h1 {
            font-size: 30px;
            font-weight: bold;
            color: rgb(255, 149, 0);
            margin-left: 30px;
        }

        @media screen and (max-width: 940px) {
            .bg-custom-cards {
                flex-direction: column
            }

            .custom-card-home {
                width: 100%;
            }
        }
    </style>

    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Avaliações') }}
        </h2>
    </x-slot>

    @if(!request()->has('filterGroupType'))
        <div class="bg-custom-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
            <a href="/admin/evaluations?search=&filterGroupType=all" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TODAS AS TURMAS</h1>
            </a>

            <a href="/admin/evaluations?search=&filterGroupType=1" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TURMA DE 4 ANOS</h1>
            </a>

            <a href="/admin/evaluations?search=&filterGroupType=2" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TURMA DE 5 A 6 ANOS</h1>
            </a>

            <a href="/admin/evaluations?search=&filterGroupType=3" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TURMA DE 7 A 8 ANOS</h1>
            </a>

            <a href="/admin/evaluations?search=&filterGroupType=4" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TURMA DE 9 A 10 ANOS</h1>
            </a>

            <a href="/admin/evaluations?search=&filterGroupType=5" class="custom-card-home">
                <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
                <h1>TURMA DE 11 A 12 ANOS</h1>
            </a>
        </div>
    @endif

    @if(request()->has('filterGroupType'))
        <div class="py-2">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="sm:flex">
                    <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                        <form class="lg:pr-3 inline-flex" action="{{ route('admin.evaluations') }}" method="GET">
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
                                    Filtrar por
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
                                                <input id="filterByResName" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="resDocument" @if (request()->filterFamilyType == "resDocument") checked @endif>
                                                <label for="filterByResName" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">CPF Responsável</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="filterByPhone" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="resName" @if (request()->filterFamilyType == "resName") checked @endif>
                                                <label for="filterByPhone" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nome Responsável</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="filterByDocument" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="memberDocument" @if (request()->filterFamilyType == "memberDocument") checked @endif>
                                                <label for="filterByDocument" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">CPF da Criança</label>
                                            </li>
                                            <li class="flex items-center">
                                                <input id="filterByPhone" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="memberName" @if (request()->filterFamilyType == "memberName") checked @endif>
                                                <label for="filterByPhone" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nome da Criança</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="relative ml-0" x-data="{ filterGroupType: false }" @click.outside="filterGroupType = false" @close.stop="filterGroupType = false">
                                <button type="button" @click="filterGroupType = ! filterGroupType" class="mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                                    Filtrar por Turma
                                    <svg class="w-4 h-4 ml-2" aria-hidden="true" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="filterGroupType"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    style="display: none;"
                                    @click="filterGroupType = false">
                                    <div class="absolute z-50 w-60 pt-4 mt-2 bg-white rounded-lg shadow">
                                        <ul class="space-y-2 text-sm">
                                            <li class="flex items-center">
                                                <input id="filterByGroupAll" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterGroupType" value="all" @if (request()->filterGroupType == "all") checked @endif>
                                                <label for="filterByGroupAll" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Todos</label>
                                            </li>
                                            @foreach ($groups as $group)
                                                <li class="flex items-center">
                                                    <input id="filterByGroup{{ $group->id }}" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterGroupType" value="{{ $group->id }}" @if (request()->filterGroupType == $group->id) checked @endif>
                                                    <label for="filterByGroup{{ $group->id }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">{{ $group->name }} @if (request()->filterGroupType == "{{ $group->id }}") checked @endif </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="relative ml-0" x-data="{ filterEvaluationType: false }" @click.outside="filterEvaluationType = false" @close.stop="filterEvaluationType = false">
                                <button type="button" @click="filterEvaluationType = ! filterEvaluationType" class="mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2.5">
                                    Tipo de Avaliação
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
                    <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                        <x-btn-link :href="route('admin.families.members')" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
                            <i class="bi bi-plus"></i> Adicionar avaliação
                        </x-btn-link>

                        <!--<x-btn-link :href="route('admin.evaluations')" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
                            <i class="bi bi-plus"></i> Novar Avalia
                        </x-btn-link>
                        <a href="#" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd"></path>
                            </svg> Export
                        </a>-->
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
                                        <th class="px-4 py-3">Responsável</th>
                                        <th class="px-4 py-3 text-center">Tipo</th>
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
                                                    <div class="font-semibold">{{ $evaluation->familyMember->family->responsable_name }}</div>
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ $evaluation->familyMember->family->email }}</div>
                                                    <div class="font-semibold text-xs text-gray-600 dark:text-gray-400">{{ formatPhone($evaluation->familyMember->family->phone) }}</div>
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
                                            <a data-bs-toggle="tooltip" href="{{ route('admin.evaluations.edit', ['id' => $evaluation->id, 'evalType' => $evaluationTypes[$evaluation->type] ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Ver avaliação</a>
                                            @if ($superAdmin)
                                                <form id="destroyEvaluation-{{ $evaluation->id }}" onsubmit="confirmDelete('destroyEvaluation-{{ $evaluation->id }}');return false;" action="{{ route('admin.evaluations.destroy', ['id' => $evaluation->id, 'evalType' => $evaluationTypes[$evaluation->type] ]) }}" method="POST" class="inline-flex">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="evaluation_id" value="{{ $evaluation->id }}">
                                                    <button data-bs-toggle="tooltip" data-bs-title="Excluir" type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"><i class="bi bi-trash-fill"></i></button>
                                                </form>
                                            @endif
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
    @endif

    <script>
        function confirmDelete(formId) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger mr-2'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Você tem certeza disso?',
                text: "Essa ação é irreversível!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sim, deletar!',
                cancelButtonText: 'Não, cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            })
        }
    </script>
</x-app-layout>
