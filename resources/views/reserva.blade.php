@extends('layouts.app')

@section('title', 'Reservas | Sal & Sabor')

@section('content')
<style>
    .mesa-item {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 3px solid;
        position: relative;
        margin: 10px;
    }
    
    .mesa-item.libre {
        background: #d4edda;
        border-color: #28a745;
        color: #155724;
    }
    
    .mesa-item.libre:hover {
        transform: scale(1.1);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    
    .mesa-item.ocupada {
        background: #f8d7da;
        border-color: #dc3545;
        color: #721c24;
        cursor: not-allowed;
        opacity: 0.6;
    }
    
    .mesa-item.reservada {
        background: #fff3cd;
        border-color: #ffc107;
        color: #856404;
        cursor: not-allowed;
        opacity: 0.7;
    }
    
    .mesa-item.selected {
        background: #d62828;
        border-color: #b71f1f;
        color: white;
        transform: scale(1.15);
        box-shadow: 0 8px 20px rgba(214, 40, 40, 0.4);
    }
    
    .mesa-numero {
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    .mesa-capacidad {
        font-size: 0.75rem;
        margin-top: 2px;
    }
    
    .mesas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 15px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .legend {
        display: flex;
        gap: 20px;
        justify-content: center;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 4px;
        border: 2px solid;
    }
</style>

<div class="container py-5">
    <h1 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
        <i class="fas fa-calendar-check me-2 float-animation"></i>Reserva tu Mesa
    </h1>

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

    <div class="row">
        <!-- Formulario -->
        <div class="col-lg-5 mb-4 scroll-reveal">
            <div class="form-modern p-4">
                <form method="POST" action="{{ route('reserva.store') }}" id="reservaForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nombre" class="form-label fw-bold">
                            <i class="fas fa-user me-2 text-primary"></i>Nombre completo
                        </label>
                        <input type="text" id="nombre" name="nombre" 
                               class="modern-input form-control @error('nombre') is-invalid @enderror" 
                               placeholder="Ingresa tu Nombre" 
                               value="{{ old('nombre', auth()->user()->name ?? '') }}" 
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">
                            <i class="fas fa-envelope me-2 text-primary"></i>Email (opcional)
                        </label>
                        <input type="email" id="email" name="email" 
                               class="modern-input form-control @error('email') is-invalid @enderror" 
                               placeholder="tu@email.com" 
                               value="{{ old('email', auth()->user()->email ?? '') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="telefono" class="form-label fw-bold">
                            <i class="fas fa-phone me-2 text-primary"></i>Teléfono
                        </label>
                        <input type="text" id="telefono" name="telefono" 
                               class="modern-input form-control @error('telefono') is-invalid @enderror" 
                               placeholder="987654321" 
                               value="{{ old('telefono') }}" 
                               required>
                        @error('telefono')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="personas" class="form-label fw-bold">
                            <i class="fas fa-users me-2 text-primary"></i>Cantidad de personas
                        </label>
                        <select id="personas" name="personas" 
                                class="modern-input form-select @error('personas') is-invalid @enderror" 
                                required
                                onchange="actualizarMesasDisponibles()">
                            <option value="">Selecciona cantidad</option>
                            @for($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ old('personas') == $i ? 'selected' : '' }}>
                                    {{ $i }} {{ $i == 1 ? 'persona' : 'personas' }}
                                </option>
                            @endfor
                        </select>
                        @error('personas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="fecha" class="form-label fw-bold">
                            <i class="fas fa-calendar me-2 text-primary"></i>Fecha
                        </label>
                        <input type="date" id="fecha" name="fecha" 
                               class="modern-input form-control @error('fecha') is-invalid @enderror" 
                               value="{{ old('fecha', $fecha ?? date('Y-m-d')) }}" 
                               min="{{ date('Y-m-d') }}" 
                               required
                               onchange="actualizarMesasDisponibles()">
                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="hora" class="form-label fw-bold">
                            <i class="fas fa-clock me-2 text-primary"></i>Hora
                        </label>
                        <input type="time" id="hora" name="hora" 
                               class="modern-input form-control @error('hora') is-invalid @enderror" 
                               value="{{ old('hora', $hora ?? '') }}" 
                               required
                               onchange="actualizarMesasDisponibles()">
                        @error('hora')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <input type="hidden" id="mesa_id" name="mesa_id" value="{{ old('mesa_id') }}">

                    <div class="mb-4">
                        <label class="form-label fw-bold">
                            <i class="fas fa-sticky-note me-2 text-primary"></i>Notas adicionales (opcional)
                        </label>
                        <textarea name="notas" 
                                  class="modern-input form-control" 
                                  rows="3" 
                                  placeholder="Alguna preferencia especial...">{{ old('notas') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-modern btn-primary w-100 hover-glow">
                        <i class="fas fa-check me-2"></i>Confirmar Reserva
                    </button>
                </form>
            </div>
        </div>

        <!-- Selector de Mesas -->
        <div class="col-lg-7 scroll-reveal">
            <div class="modern-card p-4">
                <h4 class="fw-bold mb-4 text-center">
                    <i class="fas fa-chair me-2 text-primary"></i>Selecciona tu Mesa
                </h4>
                
                <!-- Leyenda -->
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color libre" style="background: #d4edda; border-color: #28a745;"></div>
                        <span>Libre</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color ocupada" style="background: #f8d7da; border-color: #dc3545;"></div>
                        <span>Ocupada</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color reservada" style="background: #fff3cd; border-color: #ffc107;"></div>
                        <span>Reservada</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color selected" style="background: #d62828; border-color: #b71f1f;"></div>
                        <span>Seleccionada</span>
                    </div>
                </div>

                <!-- Información de Reserva (se muestra cuando se selecciona una mesa con reserva) -->
                <div id="info-reserva" class="alert alert-info d-none mb-3" style="display: none !important;">
                    <h6 class="fw-bold mb-2">
                        <i class="fas fa-info-circle me-2"></i>Información de Reserva
                    </h6>
                    <div id="reserva-detalle">
                        <p class="mb-1"><strong>Reservado por:</strong> <span id="reserva-nombre"></span></p>
                        <p class="mb-1"><strong>Estado:</strong> <span id="reserva-estado"></span></p>
                        <p class="mb-2"><strong>Fecha y Hora:</strong> <span id="reserva-fecha-hora"></span></p>
                        <div id="reserva-acciones" class="d-flex gap-2">
                            <button type="button" class="btn btn-sm btn-danger" id="btn-cancelar-reserva">
                                <i class="fas fa-times me-1"></i>Cancelar Reserva
                            </button>
                            <button type="button" class="btn btn-sm btn-warning" id="btn-cambiar-mesa" data-bs-toggle="modal" data-bs-target="#modalCambiarMesa">
                                <i class="fas fa-exchange-alt me-1"></i>Cambiar Mesa
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Grid de Mesas -->
                <div class="mesas-grid" id="mesas-grid">
                    @if(isset($mesas) && $mesas->count() > 0)
                        @foreach($mesas as $mesa)
                            @php
                                try {
                                    $fechaCheck = $fecha ?? date('Y-m-d');
                                    $horaCheck = $hora ?? date('H:i');
                                    $disponible = $mesa->estaDisponible($fechaCheck, $horaCheck);
                                    $clase = $mesa->estado ?? 'libre';
                                    if (!$disponible && $clase == 'libre') {
                                        $clase = 'reservada';
                                    }
                                    // Obtener reserva activa si existe
                                    $reservaActiva = $mesa->reservas()
                                        ->where('estado', '!=', 'cancelada')
                                        ->where('estado', '!=', 'completada')
                                        ->whereDate('fecha', $fechaCheck)
                                        ->where('hora', $horaCheck)
                                        ->with('usuario')
                                        ->first();
                                } catch (\Exception $e) {
                                    $clase = $mesa->estado ?? 'libre';
                                    $reservaActiva = null;
                                }
                            @endphp
                            <div class="mesa-item {{ $clase }} {{ old('mesa_id') == $mesa->id ? 'selected' : '' }}"
                                 data-mesa-id="{{ $mesa->id }}"
                                 data-capacidad="{{ $mesa->capacidad }}"
                                 data-estado="{{ $mesa->estado ?? 'libre' }}"
                                 data-reserva-id="{{ $reservaActiva ? $reservaActiva->id : '' }}"
                                 onclick="seleccionarMesa({{ $mesa->id }}, {{ $mesa->capacidad }}, '{{ $clase }}', {{ $reservaActiva ? $reservaActiva->id : 'null' }})">
                                <div class="mesa-numero">{{ $mesa->numero }}</div>
                                <div class="mesa-capacidad">
                                    <i class="fas fa-users"></i> {{ $mesa->capacidad }}
                                </div>
                                @if($reservaActiva)
                                    <small class="text-muted" style="font-size: 0.65rem; margin-top: 2px;">
                                        <i class="fas fa-user"></i> {{ $reservaActiva->usuario ? $reservaActiva->usuario->name : $reservaActiva->nombre }}
                                    </small>
                                @elseif(!empty($mesa->ubicacion))
                                    <small class="text-muted" style="font-size: 0.6rem;">{{ $mesa->ubicacion }}</small>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="w-100 text-center p-4">
                            <p class="text-muted mb-3">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay mesas configuradas.
                            </p>
                            <small class="text-muted">
                                Si acabas de ejecutar las migraciones, recarga la página.
                            </small>
                        </div>
                    @endif
                </div>
                
                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Selecciona una fecha, hora y cantidad de personas para ver las mesas disponibles
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Cambiar Mesa -->
<div class="modal fade" id="modalCambiarMesa" tabindex="-1" aria-labelledby="modalCambiarMesaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCambiarMesaLabel">
                    <i class="fas fa-exchange-alt me-2"></i>Cambiar de Mesa
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCambiarMesa" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="cambiar-reserva-id" name="reserva_id">
                    <input type="hidden" id="cambiar-fecha" name="fecha">
                    <input type="hidden" id="cambiar-hora" name="hora">
                    <div class="mb-3">
                        <label for="nueva_mesa_id" class="form-label">Selecciona la nueva mesa:</label>
                        <select id="nueva_mesa_id" name="nueva_mesa_id" class="form-select" required>
                            <option value="">Selecciona una mesa...</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Se mostrarán solo las mesas disponibles para la fecha y hora seleccionadas.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check me-1"></i>Confirmar Cambio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let mesaSeleccionada = null;
let reservaActual = null;

function seleccionarMesa(mesaId, capacidad, estado, reservaId = null) {
    // Si la mesa está ocupada, no permitir selección
    if (estado === 'ocupada') {
        return;
    }
    
    // Remover selección anterior
    document.querySelectorAll('.mesa-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Agregar selección nueva
    const mesaElement = document.querySelector(`[data-mesa-id="${mesaId}"]`);
    if (mesaElement) {
        mesaElement.classList.add('selected');
        document.getElementById('mesa_id').value = mesaId;
        mesaSeleccionada = mesaId;
        
        // Si tiene reserva, obtener información
        if (reservaId) {
            obtenerInfoReserva(mesaId, reservaId);
        } else {
            ocultarInfoReserva();
        }
    }
}

function obtenerInfoReserva(mesaId, reservaId) {
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    
    if (!fecha || !hora) {
        ocultarInfoReserva();
        return;
    }
    
    fetch(`{{ route('reserva.obtener-reserva-mesa') }}?mesa_id=${mesaId}&fecha=${fecha}&hora=${hora}`)
        .then(response => response.json())
        .then(data => {
            if (data.existe && data.reserva) {
                mostrarInfoReserva(data.reserva);
                reservaActual = data.reserva;
            } else {
                ocultarInfoReserva();
            }
        })
        .catch(error => {
            console.error('Error al obtener información de reserva:', error);
            ocultarInfoReserva();
        });
}

function mostrarInfoReserva(reserva) {
    const infoDiv = document.getElementById('info-reserva');
    const nombreSpan = document.getElementById('reserva-nombre');
    const estadoSpan = document.getElementById('reserva-estado');
    const fechaHoraSpan = document.getElementById('reserva-fecha-hora');
    const accionesDiv = document.getElementById('reserva-acciones');
    
    nombreSpan.textContent = reserva.usuario_nombre || reserva.nombre;
    
    // Formatear estado
    const estados = {
        'pendiente': 'Pendiente',
        'confirmada': 'Confirmada',
        'cancelada': 'Cancelada',
        'completada': 'Completada'
    };
    estadoSpan.textContent = estados[reserva.estado] || reserva.estado;
    estadoSpan.className = reserva.estado === 'confirmada' ? 'badge bg-success' : 
                           reserva.estado === 'pendiente' ? 'badge bg-warning' : 
                           reserva.estado === 'cancelada' ? 'badge bg-danger' : 'badge bg-secondary';
    
    // Formatear fecha y hora
    const fecha = new Date(reserva.fecha);
    const fechaFormateada = fecha.toLocaleDateString('es-ES', { day: '2-digit', month: '2-digit', year: 'numeric' });
    fechaHoraSpan.textContent = `${fechaFormateada} a las ${reserva.hora}`;
    
    // Mostrar/ocultar botones según permisos
    if (reserva.puede_cancelar) {
        accionesDiv.style.display = 'flex';
        document.getElementById('btn-cancelar-reserva').onclick = () => cancelarReserva(reserva.id);
        document.getElementById('btn-cambiar-mesa').onclick = () => prepararCambioMesa(reserva.id);
    } else {
        accionesDiv.style.display = 'none';
    }
    
    infoDiv.classList.remove('d-none');
    infoDiv.style.display = 'block';
}

function ocultarInfoReserva() {
    const infoDiv = document.getElementById('info-reserva');
    infoDiv.classList.add('d-none');
    infoDiv.style.display = 'none';
    reservaActual = null;
}

function cancelarReserva(reservaId) {
    if (!confirm('¿Estás seguro de que deseas cancelar esta reserva?')) {
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('/reserva') }}/${reservaId}/cancelar`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    document.body.appendChild(form);
    form.submit();
}

function prepararCambioMesa(reservaId) {
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const personas = document.getElementById('personas').value;
    
    document.getElementById('cambiar-reserva-id').value = reservaId;
    document.getElementById('cambiar-fecha').value = fecha;
    document.getElementById('cambiar-hora').value = hora;
    
    // Cargar mesas disponibles
    cargarMesasParaCambio(fecha, hora, personas, reservaId);
}

function cargarMesasParaCambio(fecha, hora, personas, reservaIdExcluir) {
    fetch(`{{ route('reserva.obtener-mesas') }}?fecha=${fecha}&hora=${hora}&personas=${personas}`)
        .then(response => response.json())
        .then(mesas => {
            const select = document.getElementById('nueva_mesa_id');
            select.innerHTML = '<option value="">Selecciona una mesa...</option>';
            
            mesas.forEach(mesa => {
                // Excluir la mesa actual de la reserva
                if (mesa.id != reservaActual?.mesa_id && mesa.disponible) {
                    const option = document.createElement('option');
                    option.value = mesa.id;
                    option.textContent = `${mesa.numero} - Capacidad: ${mesa.capacidad} personas`;
                    select.appendChild(option);
                }
            });
            
            if (select.options.length === 1) {
                select.innerHTML = '<option value="">No hay mesas disponibles</option>';
            }
        })
        .catch(error => {
            console.error('Error al cargar mesas:', error);
        });
}

// Manejar envío del formulario de cambiar mesa
document.getElementById('formCambiarMesa').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const reservaId = document.getElementById('cambiar-reserva-id').value;
    const nuevaMesaId = document.getElementById('nueva_mesa_id').value;
    const fecha = document.getElementById('cambiar-fecha').value;
    const hora = document.getElementById('cambiar-hora').value;
    
    if (!nuevaMesaId) {
        alert('Por favor, selecciona una mesa.');
        return;
    }
    
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ url('/reserva') }}/${reservaId}/cambiar-mesa`;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = '{{ csrf_token() }}';
    form.appendChild(csrfToken);
    
    const nuevaMesaInput = document.createElement('input');
    nuevaMesaInput.type = 'hidden';
    nuevaMesaInput.name = 'nueva_mesa_id';
    nuevaMesaInput.value = nuevaMesaId;
    form.appendChild(nuevaMesaInput);
    
    const fechaInput = document.createElement('input');
    fechaInput.type = 'hidden';
    fechaInput.name = 'fecha';
    fechaInput.value = fecha;
    form.appendChild(fechaInput);
    
    const horaInput = document.createElement('input');
    horaInput.type = 'hidden';
    horaInput.name = 'hora';
    horaInput.value = hora;
    form.appendChild(horaInput);
    
    document.body.appendChild(form);
    form.submit();
});

function actualizarMesasDisponibles() {
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const personas = document.getElementById('personas').value;
    
    if (!fecha || !hora || !personas) {
        ocultarInfoReserva();
        return;
    }
    
    fetch(`{{ route('reserva.obtener-mesas') }}?fecha=${fecha}&hora=${hora}&personas=${personas}`)
        .then(response => response.json())
        .then(mesas => {
            const grid = document.getElementById('mesas-grid');
            grid.innerHTML = '';
            
            // Limpiar selección anterior
            mesaSeleccionada = null;
            document.getElementById('mesa_id').value = '';
            ocultarInfoReserva();
            
            mesas.forEach(mesa => {
                const mesaDiv = document.createElement('div');
                
                // Determinar clase según disponibilidad y reserva
                let clase = 'libre';
                if (mesa.estado === 'ocupada') {
                    clase = 'ocupada';
                } else if (mesa.reserva) {
                    clase = 'reservada';
                } else if (mesa.disponible) {
                    clase = 'libre';
                }
                
                mesaDiv.className = `mesa-item ${clase}`;
                mesaDiv.setAttribute('data-mesa-id', mesa.id);
                mesaDiv.setAttribute('data-capacidad', mesa.capacidad);
                mesaDiv.setAttribute('data-estado', mesa.estado);
                if (mesa.reserva) {
                    mesaDiv.setAttribute('data-reserva-id', mesa.reserva.id);
                }
                
                const reservaId = mesa.reserva ? mesa.reserva.id : null;
                mesaDiv.onclick = () => {
                    if (clase !== 'ocupada') {
                        seleccionarMesa(mesa.id, mesa.capacidad, clase, reservaId);
                    }
                };
                
                let contenido = `
                    <div class="mesa-numero">${mesa.numero}</div>
                    <div class="mesa-capacidad">
                        <i class="fas fa-users"></i> ${mesa.capacidad}
                    </div>
                `;
                
                if (mesa.reserva) {
                    contenido += `<small class="text-muted" style="font-size: 0.65rem; margin-top: 2px;">
                        <i class="fas fa-user"></i> ${mesa.reserva.usuario_nombre || mesa.reserva.nombre}
                    </small>`;
                } else if (mesa.ubicacion) {
                    contenido += `<small class="text-muted" style="font-size: 0.6rem;">${mesa.ubicacion}</small>`;
                }
                
                mesaDiv.innerHTML = contenido;
                grid.appendChild(mesaDiv);
            });
            
            if (mesas.length === 0) {
                grid.innerHTML = '<p class="text-center text-muted w-100">No hay mesas disponibles para esta fecha y hora</p>';
            }
        })
        .catch(error => {
            console.error('Error al obtener mesas:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('revealed');
                }, index * 200);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.scroll-reveal').forEach(el => {
        observer.observe(el);
    });
    
    // Actualizar mesas al cargar si hay valores
    const fecha = document.getElementById('fecha').value;
    const hora = document.getElementById('hora').value;
    const personas = document.getElementById('personas').value;
    
    if (fecha && hora && personas) {
        actualizarMesasDisponibles();
    }
});
</script>

@endsection
