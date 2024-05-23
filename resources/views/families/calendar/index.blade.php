<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Encontros Agendados') }}
        </h2>
    </x-slot>

    <div class="py-0 mt-6 mb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="w-full overflow-hidden shadow-sm sm:rounded-lg">
                <div class="w-full overflow-x-auto">
                    <div class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                        <div class="container-7xl flex-grow-1 container-p-y app-calendar-wrapper">
                            <div class="row g-0">
                                <div class="col app-calendar-sidebar">
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
        let eventLoadRoute = "{!! route('families.calendar.load') !!}";

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
            });
            calendar.render();
        });
    </script>
</x-app-layout>
