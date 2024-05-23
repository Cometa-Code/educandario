<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Relatórios & Gráficos') }}
        </h2>
    </x-slot>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3 inline-flex" action="{{ route('admin.reports') }}" method="GET">
                        <label for="search" class="sr-only">Buscar</label>
                        <div class="relative lg:w-64 xl:w-72">
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
                                            <input id="filterByEvalTherapist" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="therapist" @if (request()->filterEvaluationType == "therapist") checked @endif>
                                            <label for="filterByEvalTherapist" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Profissional</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByEvalFamily" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterEvaluationType" value="family" @if (request()->filterEvaluationType == "family") checked @endif>
                                            <label for="filterByEvalFamily" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Percepção dos Pais</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="relative flex items-center ml-auto space-x-2 sm:space-x-3">
                            <div class="mr-4 inline-flex items-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2">
                                <span>Data Inicial</span>
                                <input type="date" id="startDate" name="startDate" value="{{ request()->startDate ?? '' }}" class="ml-2 text-gray-900 bg-white border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-0.5">
                                <span class="ml-4">Data Final</span>
                                <input type="date" id="endDate" name="endDate" value="{{ request()->endDate ?? '' }}" class="ml-2 text-gray-900 bg-white border border-gray-300 focus:outline-none focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-2 py-0.5">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full overflow-hidden">
                <div class="w-full overflow-x-auto">
                    @foreach ($familyMembers as $familyMember)
                        @php
                            $evalData = [];

                            foreach ($familyMember['evaluations'] as $evalL) {
                                if (!isset($evalData[$evalL->meeting_date])) {
                                    $evalData[$evalL->meeting_date] = [];
                                }
                                if ($evalL->type == 0) {
                                    $evalData[$evalL->meeting_date][] = [
                                        "Type" => 0,
                                        "Positive" => $evalL->getPositiveQualitiesScoreAttribute(),
                                        "Negative" => $evalL->getNegativeQualitiesScoreAttribute()
                                    ];
                                } else {
                                    $evalData[$evalL->meeting_date][] = [
                                        "Type" => 1,
                                        "Qualities" => $evalL->getChildQualitiesScoreAttribute(),
                                        "Answers" => $evalL->getScaleAnswersScoreAttribute(),
                                        "Emotions" => $evalL->getEmotionsScoreAttribute()
                                    ];
                                }
                            }

                            $finalData = [];
                            foreach ($evalData as $evalKey => $evalValue) {

                                foreach ($evalValue as $eval) {

                                    if (!isset($finalData[$evalKey])) {
                                        $finalData[$evalKey] = [
                                            "Positive" => 0,
                                            "Negative" => 0,
                                            "Qualities" => 0,
                                            "Answers" => 0,
                                            "Emotions" => 0
                                        ];
                                    }
                                    if ($eval['Type'] == 0) {
                                        $finalData[$evalKey]["Type"] = 0;
                                        $finalData[$evalKey]["Positive"] += $eval['Positive'];
                                        $finalData[$evalKey]["Negative"] += $eval['Negative'];
                                    } else {
                                        $finalData[$evalKey]["Type"] = 1;
                                        $finalData[$evalKey]["Qualities"] += $eval['Qualities'];
                                        $finalData[$evalKey]["Answers"] += $eval['Answers'];
                                        $finalData[$evalKey]["Emotions"] += $eval['Emotions'];
                                    }
                                }
                            }
                        @endphp
                    <div class="grid grid-rows-1 gap-2 mb-8">
                        <div class="col-span-1 p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800 text-gray-700 hover:bg-gray-50">
                            <div class="font-semibold font-xl">Nome: {{ $familyMember['name'] }}</div>
                            <div class="font-normal font-xs">Documento: {{ formatCPF($familyMember['document']) }}</div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 mb-8">
                            <div class="flex items-center col-span-2 p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                                <canvas id="myLineChart{{$familyMember["id"]}}"></canvas>
                                <script>
                                    const myLineChart{{$familyMember["id"]}} = document.getElementById('myLineChart{{$familyMember["id"]}}');
                                    const myLineChartLabels{{$familyMember["id"]}} = [
                                        @foreach ($finalData as $evalDate => $totals)
                                            '{{ $evalDate }}',
                                        @endforeach
                                    ];
                                    const myLineChartDataSets{{$familyMember["id"]}} = [
                                        @if ($evalType == 0)
                                            {
                                                label: 'Habilidades Percebidas',
                                                data: [
                                                    @foreach ($finalData as $evalDate => $totals)
                                                        {{ $totals['Positive'] }},
                                                    @endforeach
                                                    ],
                                                borderColor: 'rgb(0, 128, 0)',
                                                backgroundColor: 'rgb(0, 128, 0)',
                                            },
                                            {
                                                label: 'Dificuldades Apresentadas',
                                                data: [
                                                    @foreach ($finalData as $evalDate => $totals)
                                                        {{ $totals['Negative'] }},
                                                    @endforeach
                                                    ],
                                                borderColor: 'rgb(255, 0, 0)',
                                                backgroundColor: 'rgb(255, 0, 0)',
                                            },
                                        @else
                                            {
                                                label: 'Demonstração de Habilidades',
                                                data: [
                                                    @foreach ($finalData as $evalDate => $totals)
                                                        {{ $totals['Qualities'] }},
                                                    @endforeach
                                                    ],
                                                borderColor: 'rgb(0, 128, 0)',
                                                backgroundColor: 'rgb(0, 128, 0)',
                                            },
                                            {
                                                label: 'Nível das Respostas',
                                                data: [
                                                    @foreach ($finalData as $evalDate => $totals)
                                                        {{ $totals['Answers'] }},
                                                    @endforeach
                                                    ],
                                                borderColor: 'rgb(245, 245, 0)',
                                                backgroundColor: 'rgb(245, 245, 0)',
                                            },
                                            {
                                                label: 'Emoções Frequentes',
                                                data: [
                                                    @foreach ($finalData as $evalDate => $totals)
                                                        {{ $totals['Emotions'] }},
                                                    @endforeach
                                                    ],
                                                borderColor: 'rgb(0, 0, 255)',
                                                backgroundColor: 'rgb(0, 0, 255)',
                                            },
                                        @endif
                                    ];
                                    new Chart(myLineChart{{$familyMember["id"]}}, {
                                        type: 'line',
                                        data: {
                                            labels: myLineChartLabels{{$familyMember["id"]}},
                                            datasets: myLineChartDataSets{{$familyMember["id"]}}
                                        },
                                        options: { scales: { y: { suggestedMin: 30, suggestedMax: 50 } } }
                                    });
                                </script>
                            </div>
                            <div class="flex items-center col-span-1 p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                                <canvas id="myPizzaChart{{$familyMember['id']}}"></canvas>
                                <script>
                                    const myPizzaChart{{$familyMember["id"]}} = document.getElementById('myPizzaChart{{$familyMember["id"]}}');
                                    const myPizzaChartLabels{{$familyMember["id"]}} = [
                                        @if($evalType == 0)
                                        'Habilidades Percebidas', 'Dificuldades Apresentadas'
                                        @else
                                        'Demonstração de Habilidades', 'Nível das Respostas', 'Emoções Frequentes'
                                        @endif
                                    ];
                                    @php
                                        $dataPieSum = [];
                                        if ($evalType == 0) {
                                            $dataPieSum['Positive'] = 0;
                                            $dataPieSum['Negative'] = 0;
                                            foreach ($finalData as $evalDate => $totals) {
                                                $dataPieSum['Positive'] += $totals['Positive'];
                                                $dataPieSum['Negative'] += $totals['Negative'];
                                            }
                                        } else {
                                            $dataPieSum['Qualities'] = 0;
                                            $dataPieSum['Answers'] = 0;
                                            $dataPieSum['Emotions'] = 0;
                                            foreach ($finalData as $evalDate => $totals) {
                                                $dataPieSum['Qualities'] += $totals['Qualities'];
                                                $dataPieSum['Answers'] += $totals['Answers'];
                                                $dataPieSum['Emotions'] += $totals['Emotions'];
                                            }
                                        }
                                    @endphp
                                    const myPizzaChartDataSets{{$familyMember["id"]}} = [
                                        @if ($evalType == 0)
                                            {
                                                label: 'Avaliação Prosissonal',
                                                data: [
                                                    {{ $dataPieSum['Positive'] }},
                                                    {{ $dataPieSum['Negative'] }}
                                                    ],
                                                backgroundColor: [
                                                    'rgb(255, 99, 132)',
                                                    'rgb(54, 162, 235)',
                                                ],
                                            },
                                        @else
                                            {
                                                label: 'Percepção dos Pais',
                                                data: [
                                                    {{ $dataPieSum['Qualities'] }},
                                                    {{ $dataPieSum['Answers'] }},
                                                    {{ $dataPieSum['Emotions'] }}
                                                    ],
                                                backgroundColor: [
                                                    'rgb(255, 99, 132)',
                                                    'rgb(54, 162, 235)',
                                                    'rgb(255, 205, 86)',
                                                ],
                                            }
                                        @endif
                                    ];
                                    new Chart(myPizzaChart{{$familyMember["id"]}}, {
                                    type: 'pie',
                                    data: {
                                        labels: myPizzaChartLabels{{$familyMember["id"]}},
                                        datasets: myPizzaChartDataSets{{$familyMember["id"]}}
                                        },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            title: {
                                                display: true,
                                                text: 'Soma do Período'
                                            }
                                        }
                                    },
                                });
                                </script>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
