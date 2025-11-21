<section>
    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('patch')

        <!-- Avatar Upload -->
        <div class="text-center mb-4">
            <label for="avatar" class="cursor-pointer">
                <div class="avatar-container d-inline-block">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                             alt="{{ $user->name }}" 
                             class="avatar-image"
                             id="avatarPreview">
                    @else
                        <div class="avatar-placeholder" id="avatarPreview">
                            <i class="fas fa-user fa-3x"></i>
                        </div>
                    @endif
                    <div class="avatar-overlay">
                        <i class="fas fa-camera"></i>
                    </div>
                </div>
            </label>
            <input type="file" 
                   id="avatar" 
                   name="avatar" 
                   accept="image/*" 
                   class="d-none"
                   onchange="previewAvatar(this)">
            <p class="text-muted mt-2 small">
                <i class="fas fa-info-circle me-1"></i>
                Haz clic en la imagen para cambiar tu foto de perfil
            </p>
            @error('avatar')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <x-input-label for="name" :value="__('Nombre completo')" />
            <x-text-input id="name" 
                         name="name" 
                         type="text" 
                         class="modern-input mt-1 block w-full" 
                         :value="old('name', $user->name)" 
                         required 
                         autofocus 
                         autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" />
            <x-text-input id="email" 
                         name="email" 
                         type="email" 
                         class="modern-input mt-1 block w-full" 
                         :value="old('email', $user->email)" 
                         required 
                         autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="btn btn-modern btn-primary hover-glow">
                <i class="fas fa-save me-2"></i>{{ __('Guardar Cambios') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="text-sm text-success fw-bold"
                >
                    <i class="fas fa-check-circle me-1"></i>{{ __('¡Guardado!') }}
                </p>
            @endif
        </div>
    </form>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
</section>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                preview.outerHTML = `<img src="${e.target.result}" alt="Preview" class="avatar-image" id="avatarPreview">`;
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
