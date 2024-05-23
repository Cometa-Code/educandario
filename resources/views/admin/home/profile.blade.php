@php
    $user = auth()->user();
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
        <h2 class="mt-4 text-2xl font-semibold text-gray-700 ">
            {{ __('Perfil') }}
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

                <form action="{{ route('admin.profile.update') }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                                    <img id="userImageImg" class="rounded-lg w-28 h-28 sm:mb-0 xl:mb-0 2xl:mb-0" src="{{ Storage::url('uploads/'.($user->profile->avatar ?? ''))  }}">
                                    <div>
                                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Foto</h3>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            JPG, JPEG ou PNG. Máximo 2MB.
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <input type="file" id="userImage" name="userImage" value="{{ old('userImage') }}" class="inline-flex items-center py-2 px-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('userImage')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="name" class="block text-gray-700 font-bold mb-2">Nome</label>
                            <input type="text" name="name" id="name" value="{{ $user->name ?? old('name') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o nome completo" />
                            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-gray-700 font-bold mb-2">E-mail de acesso</label>
                            <input disabled type="text" name="email" id="email" value="{{ $user->email }}" class="shadow-sm w-full px-4 py-2 border rounded-md bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="E-mail de acesso a conta" />
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="document" class="block text-gray-700 font-bold mb-2">Documento</label>
                            <input type="document" name="document" id="document" value="{{ $user->profile->document ?? '' }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"></input>
                            @error('document') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="birth_date" class="block text-gray-700 font-bold mb-2">Data de Nascimento</label>
                            <input type="text" name="birth_date" id="birth_date" value="{{ $user->profile->birth_date ?? '' }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"></input>
                            @error('birth_date') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="specialty" class="block text-gray-700 font-bold mb-2">Especialidade</label>
                            <input type="text" name="specialty" id="specialty" value="{{ $user->profile->specialty ?? '' }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o Telefone/Whatsapp com DDD"></input>
                            @error('specialty') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">Telefone</label>
                            <input type="number" name="phone" id="phone" value="{{ $user->profile->phone ?? '' }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o Telefone/Whatsapp com DDD"></input>
                            @error('phone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">

                    </div>
                    <hr class="mb-4 mt-4">
                    <h3 class="text-2xl font-bold pb-4">Endereço</h3>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="address" class="block text-gray-700 font-bold mb-2">Logradouro:</label>
                            <input type="text" name="address" id="address" value="{{ $user->profile->address ?? old('address') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o Logradouro">
                            @error('address')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-4 mb-8">
                        <div class="col-span-4 sm:col-span-2">
                            <label for="zip" class="block text-gray-700 font-bold mb-2">CEP:</label>
                            <input type="text" name="zip" id="zip" value="{{ $user->profile->zip ?? old('zip') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o CEP">
                            @error('zip')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="city" class="block text-gray-700 font-bold mb-2">Cidade:</label>
                            <input type="text" name="city" id="city" value="{{ $user->profile->city ?? old('city') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a Cidade">
                            @error('city')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="state" class="block text-gray-700 font-bold mb-2">Estado:</label>
                            <select id="state" name="state" class="form-select block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Selecione o Estado</option>
                                @foreach ($states as $state => $stateName)
                                    <option value="{{ $state }}" @if (($user->profile->state ?? old('state')) == $state) selected @endif>{{ $stateName }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="flex w-full items-end justify-end">
                        <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Atualizar</button>
                    </div>
                </form>
            </div>
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex w-full items-end justify-between mb-4">
                    <h3 class="text-2xl font-bold pb-2">Nova Senha</h3>
                </div>
                <form action="{{ route('admin.profile.password') }}" method="POST" class="mx-auto" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-9 gap-9 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="old_password" class="block text-gray-700 font-bold mb-2">Senha Atual</label>
                            <input type="password" name="old_password" id="old_password" value="" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite a senha atual" />
                            @error('old_password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="password" class="block text-gray-700 font-bold mb-2">Nova Senha</label>
                            <input type="text" name="password" id="password" value="" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite a Nova senha" />
                            @error('password') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirme Nova Senha</label>
                            <input type="text" name="password_confirmation" id="password_confirmation" value="" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Confirme a Nova senha" />
                            @error('password_confirmation') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="flex w-full items-end justify-end">
                        <button class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Alterar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('userImage').addEventListener('change', evt => {
            let file = document.getElementById('userImage').files[0];
            console.log(file);
            if (file) {
                var reader = new FileReader();
                reader.onload = function(){
                    document.getElementById('userImageImg').src = reader.result
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>



