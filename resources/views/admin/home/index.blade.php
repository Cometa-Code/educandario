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
            {{ __('Início') }}
        </h2>
    </x-slot>

    {{-- <div class="pt-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
                    <!-- Card -->
                    <div class="flex items-center p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total de Crianças</p>
                            <p class="text-lg font-semibold text-gray-700 ">{{ $home["total_members"] }}</p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="flex items-center p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                            <i class="bi bi-cash"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total de Avaliações</p>
                            <p class="text-lg font-semibold text-gray-700 ">{{ $home["total_evalutations"] }}</p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="flex items-center p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                            <i class="bi bi-cart-check-fill"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Total de Famílias</p>
                            <p class="text-lg font-semibold text-gray-700 ">{{ $home["total_families"] }}</p>
                        </div>
                    </div>
                    <!-- Card -->
                    <div class="flex items-center p-4 bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div class="p-3 mr-4 text-yellow-500 bg-yellow-100 rounded-full dark:text-yellow-100 dark:bg-yellow-500">
                            <i class="bi bi-chat-right-dots-fill"></i>
                        </div>
                        <div>
                            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">Atendimentos Finalizados</p>
                            <p class="text-lg font-semibold text-gray-700 ">{{ $home["completed_services"] }}</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="py-0">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-gray-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple">
                <div class="flex items-center">
                    <div class="w-5 h-5 mr-2">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <span>Agendamentos do Dia: {{ \Str::title(\Carbon\Carbon::now()->locale('pt_BR')->isoFormat('dddd')) }} </span>
                </div>
                <span><a class="text-purple-100 hover:text-purple-300" href="{{ route('admin.families.members') }}">Ver mais →</a></span>
            </div>
        </div>
    </div>
    <div class="py-0 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <thead>
                            <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                                <th class="px-4 py-3">Criança</th>
                                <th class="px-4 py-3">Telefone</th>
                                <th class="px-4 py-3">Documento</th>
                                <th class="px-4 py-3">Responsável</th>
                                <th class="px-4 py-3 text-center">Avaliar</th>
                                <th class="px-4 py-3">Cadastro</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                            @foreach ($familyMembers as $familyMember)
                            <tr class="text-gray-700 hover:bg-gray-50">
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <div class="font-semibold">{{ $familyMember->name }}</div>
                                                @isset($familyMember->groupMember)
                                                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ $familyMember->groupMember->group->name }}</div>
                                                    <div class="font-semibold text-xs text-gray-600 dark:text-gray-400">{{ $familyMember->groupMember->groupSchedule->getDayNameAttribute() }}, {{ $familyMember->groupMember->groupSchedule->start }} às {{ $familyMember->groupMember->groupSchedule->end }}</div>
                                                @endisset
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ formatPhone($familyMember->family->phone) }}</td>
                                <td class="px-4 py-3 text-sm">{{ formatCPF($familyMember->document) }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex items-center text-sm">
                                        <div>
                                            <div class="font-semibold">{{ $familyMember->family->responsable_name }}</div>
                                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $familyMember->family->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap items-center">
                                    <div class="flex flex-col gap-1 items-center text-xs">

                                        <div class="w-full">
                                            <form action="{{ route('admin.evaluations.create', ['id' => $familyMember->id, 'evalType' => 'therapist' ]) }}" method="GET" class="inline-flex w-full">
                                                @csrf
                                                <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
                                                <input type="hidden" name="evalType" value="therapist">
                                                <button type="submit" class="items-center px-2 py-1 font-medium text-center w-full text-orange-700 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:ring-orange-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-person-fill"></i> Avaliação Profissional</button>
                                            </form>
                                        </div>
                                        @if($superAdmin)
                                        <div class="w-full">
                                            <form action="{{ route('admin.evaluations.create', ['id' => $familyMember->id, 'evalType' => 'family' ]) }}" method="GET" class="inline-flex w-full">
                                                @csrf
                                                <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
                                                <input type="hidden" name="evalType" value="family">
                                                <button type="submit" class="items-center px-2 py-1 font-medium text-center w-full text-green-700 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:ring-green-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-people-fill"></i> Percepção Pais</button>
                                            </form>
                                        </div>
                                        @endif
                                        <div class="w-full">
                                            <form action="{{ route('admin.evaluations.create', ['id' => $familyMember->id, 'evalType' => 'child' ]) }}" method="GET" class="inline-flex w-full">
                                                @csrf
                                                <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
                                                <input type="hidden" name="evalType" value="child">
                                                <button type="submit" class="items-center px-2 py-1 font-medium text-center w-full text-red-700 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:ring-red-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-people"></i> Percepção Criança</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ route('admin.families.edit', ['id' => $familyMember->family->id, '#familyMembersArea' ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-arrow-right"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div> --}}

    <div class="bg-custom-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="admin/groups" class="custom-card-home">
            <img src="https://img.freepik.com/vetores-premium/amigos-de-criancas-de-todo-o-mundo-em-suas-maos-amizade-multinacional-de-filhos-de-amigos-do-mundo-ilustracao-em-vetor-de-estoque-dos-desenhos-animados-isolada-no-fundo-branco_147064-57.jpg?w=740" alt="">
            <h1>TURMAS</h1>
        </a>

        <a href="admin/reports" class="custom-card-home">
            <img src="https://cdn-icons-png.freepik.com/256/1055/1055644.png?semt=ais_hybrid" alt="">
            <h1>RELATÓRIOS</h1>
        </a>

        <a href="admin/evaluations" class="custom-card-home">
            <img src="https://cdn-icons-png.flaticon.com/512/8662/8662261.png" alt="">
            <h1>AVALIAÇÕES</h1>
        </a>

        <a href="admin/calendar" class="custom-card-home">
            <img src="https://www.mscoe.org/content/uploads/2022/11/kisspng-vector-graphics-calendar-clip-art-illustration-com-va-guiden-5b664ceec792e8.9684280015334310228175.png" alt="">
            <h1>CALENDÁRIO</h1>
        </a>
    </div>
</x-app-layout>
