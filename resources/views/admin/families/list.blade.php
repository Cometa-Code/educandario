<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Famílias') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="sm:flex">
                <div class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700">
                    <form class="lg:pr-3 inline-flex" action="{{ route('admin.families.list') }}" method="GET">
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
                                            <input id="filterByResName" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="resName" @if (request()->filterFamilyType == "resName") checked @endif>
                                            <label for="filterByResName" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nome Responsável</label>
                                        </li>
                                        <li class="flex items-center">
                                            <input id="filterByResDocument" type="radio" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500" name="filterFamilyType" value="resDocument" @if (request()->filterFamilyType == "resDocument") checked @endif>
                                            <label for="filterByResDocument" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">CPF Responsável</label>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <x-btn-link :href="route('admin.families.create')" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
                        <i class="bi bi-plus"></i> Nova Família
                    </x-btn-link>
                    <!--<a href="#" class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
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
                                    <th class="px-4 py-3">Responsável</th>
                                    <th class="px-4 py-3">Telefone</th>
                                    <th class="px-4 py-3">Documento</th>
                                    <th class="px-4 py-3">E-mail</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Data Cadastro</th>
                                    <th class="px-4 py-3">Ação</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                                @foreach ($families as $family)
                                <tr class="text-gray-700 hover:bg-gray-50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center text-sm">
                                            <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block">
                                                <img class="object-cover w-full h-full rounded-full" src="{{ Storage::url('uploads/'.$family->avatar) }}" alt="" loading="lazy">
                                                <div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>
                                            </div>
                                            <div>
                                                <div class="font-semibold">{{ $family->responsable_name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">{{ formatPhone($family->phone) }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">{{ formatCPF($family->responsable_document) }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $family->email }}</td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($family->active == 1)
                                            <span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Ativo</span>
                                        @endif
                                        @if ($family->active == 0)
                                            <span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100">Inativo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-sm">{{ \Carbon\Carbon::parse($family->created_at)->format('d/m/y \á\s H\hi') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <a data-bs-toggle="tooltip"  href="{{ route('admin.families.edit', ['id' => $family->id ]) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Gerenciar família</a>
                                        @if ($superAdmin)
                                            <form id="destroyFamily-{{ $family->id }}" onsubmit="confirmDelete('destroyFamily-{{ $family->id }}');return false;" action="{{ route('admin.families.destroy', ['id' => $family->id]) }}" method="POST" class="inline-flex">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="family_id" value="{{ $family->id }}">
                                                <button data-bs-toggle="tooltip" data-bs-title="Excluir" type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-800 focus:ring-4 focus:ring-red-300 dark:focus:ring-red-900"><i class="bi bi-trash-fill"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="flex w-full justify-center items-end my-2">
                            {{ $families->links('pagination::tailwind') }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
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
