<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="flex w-full items-end justify-between mb-4">
        <h3 class="text-2xl font-bold pb-2">Crianças da Família</h3>
        <button type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center ml-4" data-bs-toggle="modal" data-bs-target="#modalAddMember"><i class="bi bi-plus"></i> Adicionar Criança</button>
    </div>

    <form id="modalAddMember" class="modal fade" style="display: none;" aria-hidden="true" role="dialog" method="POST" action="{{ route('admin.families.edit.members.create', ['id' => $family->id ]) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="family_id" value="{{ $family->id }}">
        <div class="modal-dialog modal-xs modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Criança</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="member_name" class="block text-gray-700 font-bold mb-2">Nome</label>
                        <input type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_name" name="member_name">
                    </div>
                    <div class="form-group mb-2">
                        <label for="member_document" class="block text-gray-700 font-bold mb-2">Documento</label>
                        <input type="number" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_document" name="member_document">
                    </div>
                    <div class="form-group mb-2">
                        <label for="member_birth_date" class="block text-gray-700 font-bold mb-2">Data de Nascimento</label>
                        <input type="date" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_birth_date" name="member_birth_date">
                    </div>
                    <div class="form-group mb-2">
                        <label for="member_image" class="block text-gray-700 font-bold mb-2">Foto</label>
                        <input type="file" id="member_image" name="member_image" value="" class="shadow-sm form-file block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            JPG, JPEG ou PNG. Máximo 2MB.
                        </div>
                    </div>
                    @if($superAdmin)
                    <div class="form-group mb-2">
                        <label for="member_therapist_id" class="block text-gray-700 font-bold mb-2">Terapeuta</label>
                        <select name="member_therapist_id" id="member_therapist_id" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($therapists as $therapist)
                                <option value="{{ $therapist->id }}">{{ $therapist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group mb-2">
                        <label for="member_group_schedule" class="block text-gray-700 font-bold mb-2">Turma/Horário</label>
                        <select name="member_group_schedule" id="member_group_schedule" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($groupsArray as $scheduleId => $groupSchedule)
                                <option value="{{ $scheduleId }}">{{ $groupSchedule['name'] }}, {{ $groupSchedule['day'] }}, {{ $groupSchedule['start'] }} às {{ $groupSchedule['end'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="text-end lex w-full items-end justify-end mt-4">
                        <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">Adicionar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @error('member_name')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_document')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_birth_date')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_image')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_therapist_id')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_group_schedule')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror

    @foreach ($familyMembers as $familyMember)
    <form id="modalEditMember{{$familyMember->id}}" class="modal fade" style="display: none;" aria-hidden="true" role="dialog" method="POST" enctype="multipart/form-data" @if ($superAdmin) action="{{ route('admin.families.edit.members.update', ['id' => $family->id ]) }}" @else action="#" onsubmit="false" @endif>
        @csrf
        <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
        <div class="modal-dialog modal-xs modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@if ($superAdmin) Editar @else Visualizar @endif #{{$familyMember->id}} - {{$familyMember->name}} </h5>
                </div>
                <div class="modal-header">
                    <h6 class="">Cadastrado em {{ \Carbon\Carbon::parse($familyMember->created_at)->format('d/m/y \á\s H:i:s') }} </h6>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="member_name" class="block text-gray-700 font-bold mb-2">Nome</label>
                        <input type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_name" name="member_name" value="{{ $familyMember->name }}" @if (!$superAdmin) disabled @endif>
                    </div>
                    <div class="form-group mb-2">
                        <label for="member_document" class="block text-gray-700 font-bold mb-2">Documento</label>
                        <input @if ($superAdmin) type="number" @else type="text" @endif class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_document" name="member_document" @if ($superAdmin) value="{{ $familyMember->document }}" @else value="{{ formatCPF($familyMember->document) }}" @endif @if (!$superAdmin) disabled @endif>
                    </div>
                    <div class="form-group mb-2">
                        <label for="member_birth_date" class="block text-gray-700 font-bold mb-2">Data de Nascimento</label>
                        <input type="date" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_birth_date" name="member_birth_date" value="{{ \Carbon\Carbon::parse($familyMember->birth_date)->format('Y-m-d') }}" @if (!$superAdmin) disabled @endif>
                    </div>
                    <div class="form-group mb-2">
                            <div class="items-center sm:flex 2xl:flex sm:space-x-4 xl:space-x-2 2xl:space-x-4">
                                <img class="rounded-lg w-28 h-28 sm:mb-0 xl:mb-0 2xl:mb-0" src="{{ Storage::url('uploads/'.$familyMember->avatar) }}">
                                <div class="space-x-2">
                                    <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Foto</h3>
                                    @if($superAdmin)
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        JPG, JPEG ou PNG. Máximo 2MB.
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <input type="file" id="member_image" name="member_image" value="{{ old('member_image') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    </div>
                                    @endif
                                </div>
                            </div>
                    </div>
                    @if($superAdmin)
                    <div class="form-group mb-2">
                        <label for="member_therapist_id" class="block text-gray-700 font-bold mb-2">Terapeuta</label>

                        <select name="member_therapist_id" id="member_therapist_id" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($therapists as $therapist)
                                <option value="{{ $therapist->id }}" @if($familyMember->therapist_id == $therapist->id) selected @endif>{{ $therapist->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="form-group mb-2">
                        <label for="member_group_schedule" class="block text-gray-700 font-bold mb-2">Turma/Horário</label>
                        @if($superAdmin)
                        <select name="member_group_schedule" id="member_group_schedule" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($groupsArray as $scheduleId => $groupSchedule)
                                <option value="{{ $scheduleId }}" @if($familyMember->groupMember->groupSchedule->id == $scheduleId) selected @endif>{{ $groupSchedule['name'] }}, {{ $groupSchedule['day'] }}, {{ $groupSchedule['start'] }} às {{ $groupSchedule['end'] }}</option>
                            @endforeach
                        </select>
                        @else
                        <input type="text" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_group_schedule" name="member_group_schedule" value="{{ $familyMember->groupMember->group->name }}, {{ $familyMember->groupMember->groupSchedule->getDayNameAttribute() }}, {{ $familyMember->groupMember->groupSchedule->start }} às {{ $familyMember->groupMember->groupSchedule->end }}" disabled>
                        @endif
                    </div>
                    <div class="text-end lex w-full items-end justify-end mt-4">
                        @if($superAdmin)
                        <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center">Salvar</button>
                        @else
                        <button type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center" data-bs-dismiss="modal">Fechar</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach


    <div class="w-full overflow-x-auto" id="familyMembersArea">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Nome</th>
                    <th class="px-2 py-3">Documento</th>
                    <th class="px-2 py-3">Nascimento</th>
                    @if($superAdmin)
                    <th class="px-4 py-3">Terapeuta</th>
                    @endif
                    <th class="px-2 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Avaliar</th>
                    <th class="px-4 py-3 text-center">Ação</th>
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
                        @if($superAdmin)
                        <td class="px-4 py-3 text-sm">{{ $familyMember->therapist->name }}</td>
                        @endif
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
                            <!-- graphics goto button -->
                            <a data-bs-toggle="tooltip" data-bs-title="Ver Relatórios" href="{{ route('admin.reports', ['search' => $familyMember->document, 'filterFamilyType' => 'memberDocument']) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-purple-600 border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 rounded-lg"><i class="bi bi-pie-chart-fill"></i></a>

                            <a data-bs-toggle="tooltip" data-bs-title="Ver Avaliações" href="{{ route('admin.evaluations', ['search' => $familyMember->document, 'filterFamilyType' => 'memberDocument']) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 rounded-lg"><i class="bi bi-arrow-right"></i></a>

                            <span class="py-2" @if ($superAdmin)data-bs-toggle="tooltip" data-bs-title="Editar Membro" @else data-bs-toggle="tooltip" data-bs-title="Visualizar Membro" @endif>
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditMember{{$familyMember->id}}">
                                        <i class="bi bi-pencil"></i>
                                </button>
                            </span>

                            @if ($superAdmin)
                                <form id="destroyFamilyMember-{{ $familyMember->id }}" onsubmit="confirmDelete('destroyFamilyMember-{{ $familyMember->id }}');return false;" action="{{ route('admin.families.edit.members.destroy', ['id' => $familyMember->id ]) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="family_member_id" value="{{ $familyMember->id }}">
                                    <button data-bs-toggle="tooltip" data-bs-title="Excluir" type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
