<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="flex w-full items-end justify-between mb-4">
        <h3 class="text-2xl font-bold pb-2">Crianças da Família</h3>
    </div>

    <div class="w-full overflow-x-auto" id="familyMembersArea">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-2 py-3">Documento</th>
                    <th class="px-2 py-3">Nascimento</th>
                    <th class="px-4 py-3">Terapeuta</th>
                    <th class="px-2 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Avaliar</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach ($familyMembers as $familyMember)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm">
                            <div class="flex items-center text-sm">
                                <div class="relative hidden w-12 h-12 mr-2 rounded-full md:block">
                                    <img class="object-cover w-full h-full rounded-full" src="{{ Storage::url('uploads/'.$familyMember->avatar) }}" alt="" loading="lazy">
                                    <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                </div>
                                <div>
                                    <div class="font-semibold">{{ $familyMember->name }}</div>
                                    @isset($familyMember->groupMember)
                                        <div class="text-xs text-gray-600 dark:text-gray-400">{{ $familyMember->groupMember->group->name }}</div>
                                        <div class="font-semibold text-xs text-gray-600 dark:text-gray-400">{{ $familyMember->groupMember->groupSchedule->getDayNameAttribute() }}, {{ $familyMember->groupMember->groupSchedule->start }} às {{ $familyMember->groupMember->groupSchedule->end }}</div>
                                    @endisset
                                </div>
                            </div>
                        </td>
                        <td class="px-2 py-3 text-sm whitespace-nowrap">{{ formatCPF($familyMember->document) }}</td>
                        <td class="px-2 py-3 text-sm">{{ \Carbon\Carbon::parse($familyMember->birth_date)->format('d/m/Y') }}</td>
                        <td class="px-4 py-3 text-sm">{{ $familyMember->therapist->name }}</td>
                        <td class="px-2 py-3 text-xs">
                            @if ($familyMember->status == 0)
                                <span class="px-2 py-1 font-semibold leading-tight text-orange-700 bg-orange-100 rounded-full dark:text-white dark:bg-orange-600">Atendimento</span>
                            @endif
                            @if ($familyMember->status == 1)
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Concluído</span>
                            @endif
                            @if ($familyMember->status == 2)
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Cancelado</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap items-center">
                            <div class="flex flex-col gap-1 items-center text-xs">
                                <div class="w-full">
                                    <form action="{{ route('families.evaluations.create', ['id' => $familyMember->id ]) }}" method="GET" class="inline-flex w-full">
                                        @csrf
                                        <button type="submit" class="items-center px-2 py-1 font-medium text-center w-full text-green-700 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-1 focus:ring-green-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-people-fill"></i> Percepção Pais</button>
                                    </form>
                                </div>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
