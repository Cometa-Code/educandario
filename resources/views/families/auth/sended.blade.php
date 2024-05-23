<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Email -->
    <div>
        <p class="text-center text-lg">
            Um link de acesso foi enviado para o seu e-mail.<br/>
            Por favor, verificar sua caixa de entrada/spam.<br/>
        </p>
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-btn-link :href="route('families.login')" class="inline-flex items-center justify-center w-1/2 px-3 py-2 border border-transparent rounded-lg text-sm font-medium text-center text-white bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-primary-300 transition ease-in-out duration-150 sm:w-auto">
            Voltar
        </x-btn-link>
    </div>
</x-guest-layout>
