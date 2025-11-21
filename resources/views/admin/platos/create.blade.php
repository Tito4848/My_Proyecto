@extends('layouts.admin')

@section('title', 'Nuevo Plato')

@section('content')
<div class="admin-header animate-fade-in">
    <div>
        <h1><i class="fas fa-plus-circle me-2 text-primary"></i>Crear Nuevo Plato</h1>
        <p class="text-muted mb-0">Agrega un nuevo plato al menú del restaurante</p>
    </div>
    <div>
        <a href="{{ route('admin.platos.index') }}" class="btn btn-modern btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

@if ($errors->any())
    <x-alert type="error">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif

<div class="modern-card p-4 animate-fade-in">
<form action="{{ route('admin.platos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    {{-- Nombre --}}
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-utensils me-2 text-primary"></i>Nombre del Plato
            </label>
            <input type="text" name="nombre" 
                   class="modern-input form-control @error('nombre') is-invalid @enderror" 
                   value="{{ old('nombre') }}" 
                   placeholder="Ej: Ceviche de Pescado" 
                   required>
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
    </div>

    {{-- Precio --}}
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-tag me-2 text-primary"></i>Precio (S/)
            </label>
            <input type="number" step="0.01" name="precio" 
                   class="modern-input form-control @error('precio') is-invalid @enderror" 
                   value="{{ old('precio') }}" 
                   min="0" 
                   placeholder="0.00" 
                   required>
            @error('precio')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
    </div>

    {{-- Descripción --}}
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-align-left me-2 text-primary"></i>Descripción
            </label>
            <textarea name="descripcion" 
                      class="modern-input form-control @error('descripcion') is-invalid @enderror" 
                      rows="4" 
                      placeholder="Describe el plato, sus ingredientes y características..." 
                      required>{{ old('descripcion') }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Categoría --}}
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-list me-2 text-primary"></i>Categoría
            </label>
            <select name="categoria" class="modern-input form-select">
                <option value="">Selecciona una categoría</option>
                <option value="Entradas" {{ old('categoria') == 'Entradas' ? 'selected' : '' }}>Entradas</option>
                <option value="Platos principales" {{ old('categoria') == 'Platos principales' ? 'selected' : '' }}>Platos Principales</option>
                <option value="Postres" {{ old('categoria') == 'Postres' ? 'selected' : '' }}>Postres</option>
                <option value="Bebidas" {{ old('categoria') == 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
            </select>
    </div>

    {{-- Imagen --}}
        <div class="mb-4">
            <label class="form-label fw-bold">
                <i class="fas fa-image me-2 text-primary"></i>Imagen del Plato
            </label>
            <input type="file" name="imagen" 
                   class="modern-input form-control @error('imagen') is-invalid @enderror" 
                   accept="image/*"
                   onchange="previewImage(this)">
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="form-text text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
            </small>
            <div id="imagePreview" class="mt-3" style="display: none;">
                <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
            </div>
    </div>

    {{-- Botones --}}
        <div class="d-flex gap-2 justify-content-end">
            <a href="{{ route('admin.platos.index') }}" class="btn btn-modern btn-secondary">
                <i class="fas fa-times me-2"></i>Cancelar
            </a>
            <button type="submit" class="btn btn-modern btn-success hover-glow">
                <i class="fas fa-save me-2"></i>Guardar Plato
            </button>
        </div>
</form>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
