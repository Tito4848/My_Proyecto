<section class="space-y-4">
    <header>
        <h3 class="text-lg font-medium text-danger fw-bold">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ __('Eliminar Cuenta') }}
        </h3>
        <p class="mt-2 text-sm text-muted">
            {{ __('Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados permanentemente. Antes de eliminar tu cuenta, descarga cualquier información que desees conservar.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn btn-modern btn-danger hover-scale"
    >
        <i class="fas fa-trash me-2"></i>{{ __('Eliminar Cuenta') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 mb-4">
                <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                {{ __('¿Estás seguro de eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 mb-4">
                {{ __('Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar permanentemente tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="fw-bold mb-2" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="modern-input mt-1 block w-full"
                    placeholder="{{ __('Ingresa tu contraseña') }}"
                    required
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="btn btn-modern btn-secondary">
                    <i class="fas fa-times me-2"></i>{{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="btn btn-modern btn-danger hover-scale">
                    <i class="fas fa-trash me-2"></i>{{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
