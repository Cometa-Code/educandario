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
            {{ __('Minha Família') }}
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

                <form action="#" method="POST" class="mx-auto" enctype="multipart/form-data">
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <div class="p-2 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                                    <img id="familyImageImg" class="rounded-lg w-28 h-28 sm:mb-0 xl:mb-0 2xl:mb-0" src="{{ Storage::url('uploads/'.$family->avatar) }}">
                                    <div>
                                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">Foto Responsável</h3>
                                    </div>
                                </div>
                            </div>
                            @error('familyImage')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="responsable_name" class="block text-gray-700 font-bold mb-2">Nome Responsável</label>
                            <input type="text" name="responsable_name" id="responsable_name" value="{{ $family->responsable_name ?? old('responsable_name') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o nome completo do Responsável" disabled />
                            @error('responsable_name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="responsable_document" class="block text-gray-700 font-bold mb-2">Documento Responsável</label>
                            <input type="text" name="responsable_document" id="responsable_document" value="{{ formatCPF($family->responsable_document ?? old('responsable_document')) }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o CPF do Responsável" disabled />
                            @error('responsable_document') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="email" class="block text-gray-700 font-bold mb-2">E-mail</label>
                            <input type="email" name="email" id="email" value="{{ $family->email ?? old('email') }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite e-mail de acesso a conta" disabled></input>
                            @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                        <div class="col-span-6 sm:col-span-3">
                            <label for="phone" class="block text-gray-700 font-bold mb-2">Telefone</label>
                            <input type="text" name="phone" id="phone" value="{{ formatPhone($family->phone) }}" class="shadow-sm w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" placeholder="Digite o Telefone/Whatsapp com DDD" disabled></input>
                            @error('phone') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="mb-4 mt-4">
                    <h3 class="text-2xl font-bold pb-4">Endereço</h3>
                    <div class="grid grid-cols-6 gap-6 mb-8">
                        <div class="col-span-6 sm:col-span-3">
                            <label for="address" class="block text-gray-700 font-bold mb-2">Logradouro:</label>
                            <input type="text" name="address" id="address" value="{{ $family->address ?? old('address') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o Logradouro" disabled>
                            @error('address')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-6 gap-4 mb-8">
                        <div class="col-span-4 sm:col-span-2">
                            <label for="zip" class="block text-gray-700 font-bold mb-2">CEP:</label>
                            <input type="text" name="zip" id="zip" value="{{ $family->zip ?? old('zip') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite o CEP" disabled>
                            @error('zip')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="city" class="block text-gray-700 font-bold mb-2">Cidade:</label>
                            <input type="text" name="city" id="city" value="{{ $family->city ?? old('city') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Digite a Cidade" disabled>
                            @error('city')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-4 sm:col-span-2">
                            <label for="state" class="block text-gray-700 font-bold mb-2">Estado:</label>
                                <input type="text" name="state" id="state" value="{{ $states[$family->state] ?? old('state') }}" class="shadow-sm appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly></input>
                        </div>

                    </div>
                </form>
            </div>
            @if(!empty($family))
                @include('families.home.members')
            @endif
        </div>
    </div>
</x-app-layout>



