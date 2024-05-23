<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Calendário') }}
        </h2>
    </x-slot>
    <form id="modalAddCalendar" class="modal fade" style="display: none;" aria-hidden="true" role="dialog" method="POST" action="{{ route('admin.calendar.schedule') }}" enctype="multipart/form-data">
        @csrf
        <div class="modal-dialog modal-xs modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agendar Turma</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label for="member_meeting_date" class="block text-gray-700 font-bold mb-2">Data do Encontro</label>
                        <input type="date" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="member_meeting_date" name="member_meeting_date">
                    </div>
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
    @error('member_meeting_date')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror
    @error('member_group_schedule')
        <p class="text-red-500 text-xs italic">{{ $message }}</p>
    @enderror

    <div class="py-0 mt-6 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full overflow-x-auto">
                    <div class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <div class="container-7xl flex-grow-1 container-p-y app-calendar-wrapper">
                            <div class="row g-0">
                                <div class="col app-calendar-sidebar">
                                    <div class="border-bottom p-4 my-sm-0 mb-3">
                                        <div class="d-grid">
                                          <button data-bs-toggle="modal" data-bs-target="#modalAddCalendar" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-indigo-500 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
                                            <i class="bi bi-plus"></i> Novo Agendamento
                                          </button>
                                        </div>
                                    </div>
                                    <div class="shadow-none border-0">
                                        <div class="card-body pb-3">
                                            <!-- Filter -->
                                            <div class="mb-3 ms-3">
                                                <small class="text-small text-muted text-uppercase align-middle">Turma e Cores</small>
                                            </div>

                                            <div class="app-calendar-events-filter ms-3 text-sm text-muted align-middle pointer-events-none">
                                                @foreach ($groupColors as $groupName => $gColor)
                                                <div class="form-check {{ $gColor }} mb-2">
                                                    <input class="form-check-input input-filter" type="checkbox" id="select{{$gColor}}" data-value="" checked="">
                                                    <label class="form-check-label" for="select{{$gColor}}">{{ $groupName }}</label>
                                                </div>

                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="app-calendar-content">
                                        <div class="shadow-none border-0">
                                            <div class="card-body pb-3">
                                                <div id="calendar"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <script>
        let eventLoadRoute = "{!! route('admin.calendar.load') !!}";

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                buttonText: {
                    today: 'Hoje',
                    month: 'Mês',
                    week: 'Semana',
                    day: 'Dia',
                },
                locale: 'pt-BR',
                initialView: 'dayGridMonth',
                displayEventTime: true,
                navLinks: true,
                editable: false,
                dayMaxEvents: true,
                events: eventLoadRoute,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'listDay,listWeek,dayGridMonth'
                },
                views: {
                    listDay: { buttonText: 'Dia' },
                    listWeek: { buttonText: 'Semana' },
                    dayGridMonth: { buttonText: 'Mês' },
                    next : { buttonText: 'Este Mês' },
                    prev : { buttonText: 'Mês Anterior' },
                    today: { buttonText: 'Hoje' }
                },
                eventTimeFormat: { // like '14:30:00'
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false,
                    hour12: false
                },
                // context menu using javascript vanilla
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    // close any other context menu
                    document.querySelectorAll('.context-menu-open').forEach(function(contextMenu) { contextMenu.remove(); });

                    // create context menu with View and Exclude a href, includes a header with X to closes the context menu
                    var contextMenu = document.createElement('div');
                    let destroyRoute = "{{ route('admin.calendar.destroy', ['id' => 0]) }}".replace('/0', '/' + info.event.id);

                    var formTherapist = document.createElement('form');
                    formTherapist.action = info.event.extendedProps.evalTherapist;
                    formTherapist.method = 'GET';
                    formTherapist.className = 'flex inline-flex w-full';
                    formTherapist.innerHTML = `
                        <input type="hidden" name="family_member_id" value="${info.event.id}">
                        <input type="hidden" name="evalType" value="therapist">
                        <button type="submit" class="w-full fc-event fc-event-start fc-event-end fc-event-past fc-daygrid-event fc-daygrid-dot-event">
                            <div class="fc-event-time ml-2"> <i class="bi bi-pencil"></i> </div>
                            <div class="fc-event-title" style="flex-grow: 0 !important;">Avaliação Terapeuta</div>
                        </button>
                    `;

                    contextMenu.className = 'text-md fc fc-media-screen fc-direction-ltr fc-theme-standard fc-popover context-menu-open';
                    contextMenu.innerHTML = `
                        <div class="fc-popover-header text-sm" style="background-color: rgba(115, 103, 240, .16) !important; color: #7367f0;">
                            <span class="fc-popover-title">Opções: <b>${info.event.title}</b></span>
                            <button type="button" class="fc-popover-close context-menu-close">
                                <span class="fc-icon fc-icon-x"></span>
                            </button>
                        </div>
                        <div class="fc-popover-body">
                            <div class="fc-daygrid-event-harness">
                                <a href="${info.event.url}" class="fc-event fc-event-start fc-event-end fc-event-past fc-daygrid-event fc-daygrid-dot-event">
                                    <div class="fc-event-time ml-2"> <i class="bi bi-arrow-right"></i> </div>
                                    <div class="fc-event-title">Ver Perfil</div>
                                </a>
                            </div>
                            <div class="fc-daygrid-event-harness">
                                ${formTherapist.outerHTML}
                            </div>
                            <div class="fc-daygrid-event-harness">
                                <a href="${destroyRoute}" class="fc-event fc-event-start fc-event-end fc-event-past fc-daygrid-event fc-daygrid-dot-event">
                                    <div class="fc-event-time ml-2"> <i class="bi bi-x"></i> </div>
                                    <div class="fc-event-title">Excluir</div>
                                </a>
                            </div>
                        </div>
                    `;
                    //contextMenu.innerHTML = '<div class="fc-popover-header"><span class="fc-popover-title">Opções</span><span class="fc-popover-close fc-icon fc-icon-x context-menu-close" title="Close"></span></div><div class="fc-popover-body">aaa</div>';
                    document.body.appendChild(contextMenu);
                    contextMenu.style.position = 'absolute';
                    contextMenu.style.top = info.jsEvent.clientY + 'px';
                    contextMenu.style.left = info.jsEvent.clientX + 'px';
                    contextMenu.style.width = '15rem';
                    contextMenu.style.zIndex = 9999;
                    // close context menu
                    contextMenu.querySelector('.context-menu-close').addEventListener('click', function() { contextMenu.remove(); });

                    // close context menu if click outside
                    var closeContextMenu = function(event) {
                        if (!contextMenu.contains(event.target) && !info.el.contains(event.target)) {
                            contextMenu.remove();
                            document.removeEventListener('click', closeContextMenu);
                        }
                    };
                    document.addEventListener('click', closeContextMenu);
                }
            });
            calendar.render();
        });
    </script>
</x-app-layout>
