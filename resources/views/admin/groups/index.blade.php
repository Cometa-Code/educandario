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
            {{ __('Turmas') }}
        </h2>
    </x-slot>

    {{-- <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="sm:flex">
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    @if ($superAdmin)
                    <x-btn-link :href="route('admin.groups.create')" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
                        <i class="bi bi-plus"></i> Nova Turma
                    </x-btn-link>
                    @endif
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
                                    <th class="px-4 py-3 font-extrabold">#</th>
                                    <th class="px-4 py-3">Nome</th>
                                    <th class="px-4 py-3 text-center">Horários</th>
                                    <th class="px-4 py-3 text-center">Crianças</th>
                                    <th class="px-4 py-3 text-center">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($groups as $group)
                                <tr class="text-gray-700 hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm whitespace-nowrap font-extrabold">{{ $group->id }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap font-bold">{{ $group->name }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap text-center">
                                        @foreach ($group->schedules as $schedule)
                                            {{ $schedule->getDayNameAttribute() }} {{ $schedule->start }} - {{ $schedule->end }}<br>
                                        @endforeach
                                    </td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap text-center font-bold">{{ $group->members->count() }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center">
                                        <a data-bs-toggle="tooltip" data-bs-title="Ver Crianças" href="{{ route('admin.families.members', ['filterGroupType' => $group->id ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-blue-900 rounded-lg border border-blue-300 hover:bg-blue-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-people"></i></a>
                                        @if ($superAdmin)
                                        <a data-bs-toggle="tooltip" data-bs-title="Editar" href="{{ route('admin.groups.edit', ['id' => $group->id ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800"><i class="bi bi-pencil-square"></i></a>
                                        @endif
                                        @if ($superAdmin && $group->schedules->count() < 1)
                                            <form id="destroyGroup-{{ $group->id }}" onsubmit="confirmDelete('destroyGroup-{{ $group->id }}');return false;" action="{{ route('admin.groups.destroy', ['id' => $group->id]) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="group_id" value="{{ $group->id }}">
                                                <button data-bs-toggle="tooltip" data-bs-title="Excluir" type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="flex w-full justify-center items-end my-2">
                            {{ $groups->links('pagination::tailwind') }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div> --}}

    <div class="bg-custom-cards max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="/admin/families/members?filterGroupType=1" class="custom-card-home">
            <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
            <h1>TURMA DE 4 ANOS</h1>
        </a>

        <a href="/admin/families/members?filterGroupType=2" class="custom-card-home">
            <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
            <h1>TURMA DE 5 A 6 ANOS</h1>
        </a>

        <a href="/admin/families/members?filterGroupType=3" class="custom-card-home">
            <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
            <h1>TURMA DE 7 A 8 ANOS</h1>
        </a>

        <a href="/admin/families/members?filterGroupType=4" class="custom-card-home">
            <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
            <h1>TURMA DE 9 A 10 ANOS</h1>
        </a>

        <a href="/admin/families/members?filterGroupType=5" class="custom-card-home">
            <img src="https://png.pngtree.com/png-clipart/20230913/original/pngtree-classwork-clipart-smiling-boy-and-girl-with-book-in-hand-cartoon-png-image_11058427.png" alt="">
            <h1>TURMA DE 11 A 12 ANOS</h1>
        </a>
    </div>

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
