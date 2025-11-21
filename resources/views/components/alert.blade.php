@props(['type' => 'info', 'dismissible' => true])

@php
    $classes = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info',
        'danger' => 'alert-danger'
    ];
    $icons = [
        'success' => '✓',
        'error' => '✕',
        'warning' => '⚠',
        'info' => 'ℹ',
        'danger' => '✕'
    ];
    $borderColors = [
        'success' => '#28a745',
        'error' => '#dc3545',
        'danger' => '#dc3545',
        'warning' => '#ffc107',
        'info' => '#17a2b8'
    ];
    $class = $classes[$type] ?? $classes['info'];
    $icon = $icons[$type] ?? $icons['info'];
    $borderColor = $borderColors[$type] ?? $borderColors['info'];
@endphp

<div class="alert {{ $class }} {{ $dismissible ? 'alert-dismissible fade show' : '' }} d-flex align-items-center shadow-sm" role="alert" 
     style="border-left: 4px solid; border-left-color: {{ $borderColor }};">
    <span class="me-2" style="font-size: 1.2rem;">{{ $icon }}</span>
    <div class="flex-grow-1">
        {{ $slot }}
    </div>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>

