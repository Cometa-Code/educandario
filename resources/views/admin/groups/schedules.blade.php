<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
    <div class="flex w-full items-end justify-between mb-4">
        <h3 class="text-2xl font-bold pb-2">Horários</h3>
        @if ($superAdmin) <button type="button" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-3 py-2.5 text-center ml-4" data-bs-toggle="modal" data-bs-target="#modalAddSchedule"><i class="bi bi-plus"></i> Adicionar Horário</button> @endif
    </div>
    @if ($superAdmin)
        <form id="modalAddSchedule" class="modal fade" style="display: none;" aria-hidden="true" role="dialog" method="POST" action="{{ route('admin.groups.edit.schedules.create', ['id' => $group->id ]) }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="group_id" value="{{ $group->id }}">
            <div class="modal-dialog modal-xs modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar Horário</h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <label for="schedule_active" class="block text-gray-700 font-bold mb-2">Ativo</label>
                            <select name="schedule_active" id="schedule_active" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="1">Ativo</option>
                                <option value="0">Desativado</option>
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="schedule_day" class="block text-gray-700 font-bold mb-2">Dia</label>
                            <select name="schedule_day" id="schedule_day" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                @foreach ((new \App\Models\GroupSchedule)->getDaysAttribute() as $dayId => $dayName)
                                    <option value="{{ $dayId }}">{{ $dayName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="schedule_start" class="block text-gray-700 font-bold mb-2">Horário Inicio</label>
                            <input type="time" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="schedule_start" name="schedule_start" value="">
                        </div>
                        <div class="form-group mb-2">
                            <label for="schedule_end" class="block text-gray-700 font-bold mb-2">Horário Final</label>
                            <input type="time" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="schedule_end" name="schedule_end" value="">
                        </div>

                        <div class="text-end lex w-full items-end justify-end mt-4">
                            <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-2 py-2.5 text-center">Adicionar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        @error('schedule_active')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
        @error('schedule_day')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
        @error('schedule_start')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
        @error('schedule_end')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
        @enderror
    @endif

    @foreach ($group->schedules as $schedule)
    <form id="modalEditGroupSchedule{{$schedule->id}}" class="modal fade" style="display: none;" aria-hidden="true" role="dialog" method="POST" action="{{ route('admin.groups.edit.schedules.update', ['id' => $group->id ]) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="group_id" value="{{ $group->id }}">
        <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
        <div class="modal-dialog modal-xs modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar</h5>
                </div>
                <div class="modal-header">
                    <h6 class="">Cadastrado em {{ \Carbon\Carbon::parse($schedule->created_at)->format('d/m/y \á\s H:i:s') }} </h6>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="schedule_active" class="block text-gray-700 font-bold mb-2">Ativo</label>
                        <select name="schedule_active" id="schedule_active" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="1" @if($schedule->active == 1) selected @endif>Ativo</option>
                            <option value="0" @if($schedule->active == 0) selected @endif>Desativado</option>
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="schedule_day" class="block text-gray-700 font-bold mb-2">Dia</label>
                        <select name="schedule_day" id="schedule_day" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            @foreach ($schedule->getDaysAttribute() as $dayId => $dayName)
                                <option value="{{ $dayId }}" @if($schedule->day == $dayId) selected @endif>{{ $dayName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-2">
                        <label for="schedule_start" class="block text-gray-700 font-bold mb-2">Horário Inicio</label>
                        <input type="time" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="schedule_start" name="schedule_start" value="{{ $schedule->start }}">
                    </div>
                    <div class="form-group mb-2">
                        <label for="schedule_end" class="block text-gray-700 font-bold mb-2">Horário Final</label>
                        <input type="time" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="schedule_end" name="schedule_end" value="{{ $schedule->end }}">
                    </div>
                    <div class="text-end lex w-full items-end justify-end mt-4">
                        <button type="submit" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach

    <div class="w-full overflow-x-auto" id="schedulesArea">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Dia</th>
                    <th class="px-2 py-3">Horário Inicial</th>
                    <th class="px-2 py-3">Horário Final</th>
                    <th class="px-2 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Crianças</th>
                    <th class="px-4 py-3 text-center">Ação</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @foreach ($group->schedules as $schedule)
                    <tr class="text-gray-700 hover:bg-gray-50">
                        <td class="px-4 py-3 font-extrabold font-xs">{{ $schedule->id }}</td>
                        <td class="px-2 py-3 text-sm whitespace-nowrap">{{ $schedule->getDayNameAttribute() }}</td>
                        <td class="px-2 py-3 text-sm">{{ $schedule->getStartAttribute($schedule->start) }}</td>
                        <td class="px-4 py-3 text-sm">{{ $schedule->getEndAttribute($schedule->end) }}</td>
                        <td class="px-2 py-3 text-xs text-center">
                            @if ($schedule->active == 1)
                                <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Ativo</span>
                            @endif
                            @if ($schedule->active == 0)
                                <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Desativado</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-center">{{ $schedule->members->count() }}</td>
                        <td class="px-4 py-3 whitespace-nowrap text-center">
                            <!-- graphics goto button -->
                            <span class="py-2" data-bs-toggle="tooltip" data-bs-title="Editar Horário">
                                <button
                                    type="button"
                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEditGroupSchedule{{$schedule->id}}">
                                        <i class="bi bi-pencil"></i>
                                </button>
                            </span>

                            @if ($superAdmin && $schedule->members->count() < 1)
                                <form id="destroySchedule-{{ $schedule->id }}" onsubmit="confirmDelete('destroySchedule-{{ $schedule->id }}');return false;" action="{{ route('admin.groups.edit.schedules.destroy', ['id' => $schedule->id ]) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="group_schedule_id" value="{{ $schedule->id }}">
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
