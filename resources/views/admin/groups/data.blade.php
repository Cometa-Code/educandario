<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            @if (empty($group))
                {{ __('Nova Turma') }}
            @else
                {{ __('Editar Turma') }}
            @endif
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                @if(session()->has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-2" role="alert">
                        <strong class="font-bold">Sucesso!</strong>
                        <span class="block sm:inline">{{ session()->get('message') }}</span>
                    </div>
                @endif
                @if(session()->has('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2" role="alert">
                        <strong class="font-bold">Erro!</strong>
                        <span class="block sm:inline">{{ session()->get('message') }}</span>
                    </div>
                @endif

                @if (empty($group))
                    <form action="{{ route('admin.groups.store') }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.groups.update', ['id' => $group->id]) }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $group->id }}">
                @endif
                    @csrf

                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nome</label>
                            <input type="text" name="name" id="name" value="{{ $group->name ?? old('name') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o nome da Turma" />
                            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>

                    </div>
                    <div class="flex w-full items-end justify-end">
                        <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Salvar</button>
                    </div>
                </form>
            </div>
            @if(!empty($group))
                @include('admin.groups.schedules')
            @endif
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



