@php
    $states = [
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins'
    ];
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            @if (empty($family))
                {{ __('Nova Família') }}
            @else
                {{ __('Editar Família') }}
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

                @if (empty($family))
                    <form action="{{ route('admin.families.store') }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                @else
                    <form action="{{ route('admin.families.update', ['id' => $family->id]) }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="{{ $family->id }}">
                @endif
                    @csrf

                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="responsable_name" class="block text-gray-700 font-bold mb-2">Nome Responsável</label>
                            <input type="text" name="responsable_name" id="responsable_name" value="{{ $family->responsable_name ?? old('responsable_name') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o nome completo do Responsável" @if (!$superAdmin && !empty($family)) disabled @endif />
                            @error('responsable_name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="responsable_document" class="block text-gray-700 font-bold mb-2">Documento Responsável</label>
                            <input type="text" name="responsable_document" id="responsable_document" value="{{ $family->responsable_document ?? old('responsable_document') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o CPF do Responsável" @if (!$superAdmin && !empty($family)) disabled @endif />
                            @error('responsable_document') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-gray-700 font-bold mb-2">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ $family->email ?? old('email') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite e-mail de acesso a conta" @if (!$superAdmin && !empty($family)) disabled @endif></input>
                            @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">Telefone</label>
                            <input type="number" name="phone" id="phone" value="{{ $family->phone ?? old('phone') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o Telefone/Whatsapp com DDD" @if (!$superAdmin && !empty($family)) disabled @endif></input>
                            @error('phone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        @if (!empty($family))
                        <div class="col-span-6 sm:col-span-3">
                            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                                    <img id="familyImageImg" class="rounded-lg w-28 h-28 sm:mb-0 xl:mb-0 2xl:mb-0" src="{{ Storage::url('uploads/'.$family->avatar) }}">
                                    <div>
                                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Foto Responsável</h3>
                                        @if($superAdmin)
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            JPG, JPEG ou PNG. Máximo 2MB.
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <input type="file" id="familyImage" name="familyImage" value="{{ old('familyImage') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @error('familyImage')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        @else
                        <div class="col-span-6 sm:col-span-3">
                            <label for="familyImage" class="block text-gray-700 font-bold mb-2">Foto Responsável</label>
                            <input type="file" id="familyImage" name="familyImage" value="{{ old('familyImage') }}" class="shadow-sm form-file block w-full py-2 px-3 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                JPG, JPEG ou PNG. Máximo 2MB.
                            </div>
                            @error('familyImage')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                        @if (!empty($family))
                        <div class="col-span-6 sm:col-span-3">
                            <label for="active" class="block text-gray-700 font-bold mb-0">Cadastro Ativo</label>
                            @if ($superAdmin)
                                <select id="active" name="active" class="form-select block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm mb-1">
                                    <option value="0" @if ($family->active == 0) selected @endif>Desativado</option>
                                    <option value="1" @if ($family->active == 1) selected @endif>Ativo</option>
                                </select>
                            @else
                                <input type="text" name="active" id="active" value="{{ $family->active == 1 ? 'Ativo' : 'Desativado' }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent mb-1" readonly></input>
                            @endif

                            @error('active')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror

                            <label for="created_at" class="block text-gray-700 font-bold mb-2">Data de Cadastro</label>
                            <input type="text" name="created_at" id="created_at" value="{{ \Carbon\Carbon::parse($family->created_at)->format('d/m/y \á\s H\hi') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" readonly></input>
                        </div>
                        @endif
                    </div>
                    <hr class="mb-4 mt-4">
                    <h3 class="text-2xl font-bold pb-4">Endereço</h3>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="address" class="block text-gray-700 font-bold mb-2">Logradouro:</label>
                            <input type="text" name="address" id="address" value="{{ $family->address ?? old('address') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o Logradouro" @if (!$superAdmin && !empty($family)) disabled @endif>
                            @error('address')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-4 mb-8">
                        <div class="col-span-4 sm:col-span-2">
                            <label for="zip" class="block text-gray-700 font-bold mb-2">CEP:</label>
                            <input type="text" name="zip" id="zip" value="{{ $family->zip ?? old('zip') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o CEP" @if (!$superAdmin && !empty($family)) disabled @endif>
                            @error('zip')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="city" class="block text-gray-700 font-bold mb-2">Cidade:</label>
                            <input type="text" name="city" id="city" value="{{ $family->city ?? old('city') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a Cidade" @if (!$superAdmin && !empty($family)) disabled @endif>
                            @error('city')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="state" class="block text-gray-700 font-bold mb-2">Estado:</label>
                            @if ($superAdmin || empty($family))
                                <select id="state" name="state" class="form-select block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Selecione o Estado</option>
                                    @foreach ($states as $state => $stateName)
                                        <option value="{{ $state }}" @if (($family->state ?? old('state')) == $state) selected @endif>{{ $stateName }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" name="state" id="state" value="{{ $states[$family->state] ?? old('state') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly></input>
                            @endif
                        </div>

                    </div>
                    @if(empty($family) || ($superAdmin && !empty($family)))
                    <div class="flex w-full items-end justify-end">
                        <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Salvar</button>
                    </div>
                    @endif
                </form>
            </div>
            @if(!empty($family))
                @include('admin.families.members')
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

        document.getElementById('familyImage').addEventListener('change', evt => {
            let file = document.getElementById('familyImage').files[0];
            console.log(file);
            if (file) {
                var reader = new FileReader();
                reader.onload = function(){
                    document.getElementById('familyImageImg').src = reader.result
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>



