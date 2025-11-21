<section>
    <form method="post" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Contraseña Actual')" />
            <x-text-input id="update_password_current_password" 
                         name="current_password" 
                         type="password" 
                         class="modern-input mt-1 block w-full" 
                         autocomplete="current-password" 
                         required />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Nueva Contraseña')" />
            <x-text-input id="update_password_password" 
                         name="password" 
                         type="password" 
                         class="modern-input mt-1 block w-full" 
                         autocomplete="new-password" 
                         required />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>Mínimo 8 caracteres
            </small>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirmar Nueva Contraseña')" />
            <x-text-input id="update_password_password_confirmation" 
                         name="password_confirmation" 
                         type="password" 
                         class="modern-input mt-1 block w-full" 
                         autocomplete="new-password" 
                         required />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-modern btn-primary hover-glow">
                <i class="fas fa-save me-2"></i>{{ __('Guardar Cambios') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-success fw-bold"
                >
                    <i class="fas fa-check-circle me-1"></i>{{ __('¡Contraseña actualizada!') }}
                </p>
            @endif
        </div>
    </form>
</section>
