@extends('layouts.app')

@section('title', 'Seguimiento de Pedido | Sal & Sabor')

@section('content')
<style>
    .tracking-timeline {
        position: relative;
        padding: 2rem 0;
    }
    
    .timeline-item {
        position: relative;
        padding-left: 3rem;
        margin-bottom: 2rem;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 3px solid #e9ecef;
        background: white;
        z-index: 2;
    }
    
    .timeline-item.active::before {
        background: #d62828;
        border-color: #d62828;
        animation: pulse 2s infinite;
    }
    
    .timeline-item.completed::before {
        background: #28a745;
        border-color: #28a745;
    }
    
    .timeline-item::after {
        content: '';
        position: absolute;
        left: 9px;
        top: 20px;
        width: 2px;
        height: calc(100% + 1rem);
        background: #e9ecef;
        z-index: 1;
    }
    
    .timeline-item:last-child::after {
        display: none;
    }
    
    .timeline-item.completed::after {
        background: #28a745;
    }
    
    .status-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .status-card.active {
        border: 2px solid #d62828;
        box-shadow: 0 10px 30px rgba(214, 40, 40, 0.2);
    }
    
    .status-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.8;
        }
    }
    
    .code-display {
        background: linear-gradient(135deg, #d62828 0%, #b71f1f 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        letter-spacing: 3px;
    }
</style>

<div class="container py-5">
    @if(isset($error))
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="modern-card p-5 text-center">
                    <i class="fas fa-exclamation-triangle fa-4x text-warning mb-4"></i>
                    <h3 class="fw-bold mb-3">{{ $error }}</h3>
                    <a href="{{ route('profile.edit') }}" class="btn btn-modern btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-center mb-5 gradient-text fw-bold scroll-reveal" style="font-size: 2.5rem;">
                    <i class="fas fa-truck me-2 float-animation"></i>Seguimiento de Pedido
                </h1>

                <!-- Código de Seguimiento -->
                @if($pedido->codigo_seguimiento)
                <div class="code-display mb-4 scroll-reveal">
                    <small class="d-block mb-2" style="opacity: 0.9;">Código de Seguimiento</small>
                    <div id="codigo-seguimiento">{{ $pedido->codigo_seguimiento }}</div>
                </div>
                @endif

                <!-- Información del Pedido -->
                <div class="modern-card p-4 mb-4 scroll-reveal">
                    <h4 class="fw-bold mb-3">
                        <i class="fas fa-info-circle me-2 text-primary"></i>Información del Pedido
                    </h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Pedido #{{ $pedido->id }}</strong>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Total:</strong> S/ {{ number_format($pedido->total, 2) }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Método de Pago:</strong> {{ $pedido->metodo_pago }}
                        </div>
                    </div>
                </div>

                <!-- Timeline de Seguimiento -->
                <div class="modern-card p-4 scroll-reveal">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-route me-2 text-primary"></i>Estado del Pedido
                    </h4>
                    
                    <div class="tracking-timeline" id="tracking-timeline">
                        <!-- Recibido -->
                        @php
                            $estadoSeguimiento = $pedido->estado_seguimiento ?? 'recibido';
                        @endphp
                        <div class="timeline-item {{ in_array($estadoSeguimiento, ['recibido', 'preparando', 'listo', 'en_camino', 'entregado']) ? 'completed' : '' }} {{ $estadoSeguimiento == 'recibido' ? 'active' : '' }}">
                            <div class="status-card {{ $pedido->estado_seguimiento == 'recibido' ? 'active' : '' }}">
                                <div class="status-icon bg-success text-white mx-auto">
                                    <i class="fas fa-check"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Pedido Recibido</h5>
                                <p class="text-muted mb-2">Hemos recibido tu pedido correctamente</p>
                                @if($pedido->fecha_recibido)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $pedido->fecha_recibido->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Preparando -->
                        <div class="timeline-item {{ in_array($estadoSeguimiento, ['preparando', 'listo', 'en_camino', 'entregado']) ? 'completed' : '' }} {{ $estadoSeguimiento == 'preparando' ? 'active' : '' }}">
                            <div class="status-card {{ $estadoSeguimiento == 'preparando' ? 'active' : '' }}">
                                <div class="status-icon bg-info text-white mx-auto">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <h5 class="fw-bold mb-2">En Preparación</h5>
                                <p class="text-muted mb-2">Nuestros chefs están preparando tu pedido</p>
                                @if($pedido->fecha_preparando)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $pedido->fecha_preparando->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Listo -->
                        <div class="timeline-item {{ in_array($estadoSeguimiento, ['listo', 'en_camino', 'entregado']) ? 'completed' : '' }} {{ $estadoSeguimiento == 'listo' ? 'active' : '' }}">
                            <div class="status-card {{ $estadoSeguimiento == 'listo' ? 'active' : '' }}">
                                <div class="status-icon bg-warning text-white mx-auto">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Listo para Envío</h5>
                                <p class="text-muted mb-2">Tu pedido está listo y será enviado pronto</p>
                                @if($pedido->fecha_listo)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $pedido->fecha_listo->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- En Camino -->
                        <div class="timeline-item {{ in_array($estadoSeguimiento, ['en_camino', 'entregado']) ? 'completed' : '' }} {{ $estadoSeguimiento == 'en_camino' ? 'active' : '' }}">
                            <div class="status-card {{ $estadoSeguimiento == 'en_camino' ? 'active' : '' }}">
                                <div class="status-icon bg-primary text-white mx-auto">
                                    <i class="fas fa-truck"></i>
                                </div>
                                <h5 class="fw-bold mb-2">En Camino</h5>
                                <p class="text-muted mb-2">Tu pedido está en camino a tu dirección</p>
                                @if($pedido->fecha_en_camino)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $pedido->fecha_en_camino->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        <!-- Entregado -->
                        <div class="timeline-item {{ $estadoSeguimiento == 'entregado' ? 'completed active' : '' }}">
                            <div class="status-card {{ $estadoSeguimiento == 'entregado' ? 'active' : '' }}">
                                <div class="status-icon bg-success text-white mx-auto">
                                    <i class="fas fa-check-double"></i>
                                </div>
                                <h5 class="fw-bold mb-2">Entregado</h5>
                                <p class="text-muted mb-2">Tu pedido ha sido entregado exitosamente</p>
                                @if($pedido->fecha_entregado)
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $pedido->fecha_entregado->format('d/m/Y H:i') }}
                                    </small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mapa de Rastreo en Tiempo Real -->
                @if($pedido->estado_seguimiento == 'en_camino' || $pedido->estado_seguimiento == 'listo')
                <div class="modern-card p-4 mt-4 scroll-reveal">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-map-marked-alt me-2 text-primary"></i>Rastreo en Tiempo Real
                    </h4>
                    
                    <div id="map-container" style="height: 400px; border-radius: 15px; overflow: hidden; position: relative;">
                        <div id="map" style="width: 100%; height: 100%;"></div>
                        <div id="map-loading" class="d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: #f8f9fa;">
                            <div class="text-center">
                                <div class="spinner mb-3"></div>
                                <p class="text-muted">Cargando mapa...</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 p-3 bg-light rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <strong><i class="fas fa-map-marker-alt me-2 text-danger"></i>Dirección de Entrega:</strong>
                                <p class="mb-0 text-muted">{{ $pedido->direccion_entrega ?? $pedido->direccion }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong><i class="fas fa-clock me-2 text-primary"></i>Última Actualización:</strong>
                                <p class="mb-0 text-muted">
                                    @if($pedido->ultima_actualizacion_ubicacion)
                                        {{ $pedido->ultima_actualizacion_ubicacion->diffForHumans() }}
                                    @else
                                        Hace unos momentos
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="text-center mt-4">
                    <a href="{{ route('profile.edit') }}" class="btn btn-modern btn-primary">
                        <i class="fas fa-arrow-left me-2"></i>Volver a Mis Pedidos
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Google Maps API -->
@if(!empty($pedido) && (
    ($pedido->estado_seguimiento == 'en_camino' || $pedido->estado_seguimiento == 'listo') ||
    ($pedido->latitud && $pedido->longitud)
))
<script>
// Variables globales para el mapa
let coordenadasRestaurante = { lat: -16.4090, lng: -71.5350 }; // Arequipa

// Definir función initMap antes de cargar el script
window.initMap = function() {
    const loadingDiv = document.getElementById('map-loading');
    const mapContainer = document.getElementById('map-container');
    
    if (!mapContainer) return;
    
    // Coordenadas iniciales
    let lat = @json($pedido->latitud);
    let lng = @json($pedido->longitud);
    
    if (!lat || !lng) {
        lat = coordenadasRestaurante.lat;
        lng = coordenadasRestaurante.lng;
    }
    
    const ubicacionInicial = { lat: parseFloat(lat), lng: parseFloat(lng) };
    
    // Crear mapa
    mapa = new google.maps.Map(document.getElementById('map'), {
        zoom: 14,
        center: ubicacionInicial,
        mapTypeControl: true,
        streetViewControl: true,
        fullscreenControl: true,
        styles: [
            {
                featureType: "poi",
                elementType: "labels",
                stylers: [{ visibility: "off" }]
            }
        ]
    });
    
    // Marcador del restaurante
    const marcadorRestaurante = new google.maps.Marker({
        position: coordenadasRestaurante,
        map: mapa,
        title: 'Sal & Sabor',
        icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 10,
            fillColor: '#d62828',
            fillOpacity: 1,
            strokeColor: '#ffffff',
            strokeWeight: 2
        },
        label: {
            text: '🏪',
            fontSize: '20px'
        }
    });
    
    // Info window del restaurante
    const infoRestaurante = new google.maps.InfoWindow({
        content: '<div style="padding: 10px;"><h6 class="fw-bold mb-1">🏪 Sal & Sabor</h6><p class="mb-0">Arequipa, Perú</p></div>'
    });
    marcadorRestaurante.addListener('click', () => infoRestaurante.open(mapa, marcadorRestaurante));
    
    // Marcador del pedido
    if (lat && lng) {
        marcador = new google.maps.Marker({
            position: ubicacionInicial,
            map: mapa,
            title: 'Tu Pedido',
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                scale: 12,
                fillColor: '#4285F4',
                fillOpacity: 1,
                strokeColor: '#ffffff',
                strokeWeight: 3
            },
            animation: google.maps.Animation.DROP
        });
        
        // Info window del pedido
        const infoWindow = new google.maps.InfoWindow({
            content: `
                <div style="padding: 10px; min-width: 200px;">
                    <h6 class="fw-bold mb-2">🚚 Tu Pedido</h6>
                    <p class="mb-1"><strong>Estado:</strong> {{ ucfirst($estadoSeguimiento ?? 'En camino') }}</p>
                    <p class="mb-0"><small><i class="fas fa-map-marker-alt me-1"></i>{{ $pedido->direccion_entrega ?? $pedido->direccion }}</small></p>
                </div>
            `
        });
        
        marcador.addListener('click', () => {
            infoWindow.open(mapa, marcador);
        });
        
        // Dibujar ruta si está en camino
        @if(($pedido->estado_seguimiento ?? '') == 'en_camino')
        dibujarRuta(coordenadasRestaurante, ubicacionInicial);
        @endif
    }
    
    // Ocultar loading
    if (loadingDiv) {
        loadingDiv.style.display = 'none';
    }
};
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbKbN8nVgQ&callback=initMap&libraries=places,directions" async defer></script>
@endif

<script>
// Variables globales
@if(!isset($error) && isset($pedido))
let pedidoId = {{ $pedido->id }};
let intervalo;
let mapa = null;
let marcador = null;
let ruta = null;

// Dibujar ruta entre dos puntos
function dibujarRuta(origen, destino) {
    if (!mapa || typeof google === 'undefined' || !google.maps) {
        return;
    }
    
    const directionsService = new google.maps.DirectionsService();
    const directionsRenderer = new google.maps.DirectionsRenderer({
        map: mapa,
        suppressMarkers: true,
        polylineOptions: {
            strokeColor: '#d62828',
            strokeWeight: 4,
            strokeOpacity: 0.8
        }
    });
    
    directionsService.route({
        origin: origen,
        destination: destino,
        travelMode: google.maps.TravelMode.DRIVING
    }, (result, status) => {
        if (status === 'OK') {
            directionsRenderer.setDirections(result);
            ruta = directionsRenderer;
        }
    });
}

// Actualizar ubicación del marcador
function actualizarUbicacionMapa(lat, lng) {
    if (marcador && mapa) {
        const nuevaUbicacion = new google.maps.LatLng(lat, lng);
        marcador.setPosition(nuevaUbicacion);
        mapa.setCenter(nuevaUbicacion);
        
        // Actualizar ruta si existe
        if (ruta) {
            dibujarRuta(coordenadasRestaurante, nuevaUbicacion);
        }
        
        // Animación de movimiento
        marcador.setAnimation(google.maps.Animation.BOUNCE);
        setTimeout(() => {
            if (marcador) {
                marcador.setAnimation(null);
            }
        }, 2000);
    }
}

// Actualizar estado en tiempo real cada 10 segundos
function actualizarEstado() {
    fetch(`/pedidos/${pedidoId}/estado`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta');
            }
            return response.json();
        })
        .then(data => {
            // Actualizar timeline según el estado
            const estados = ['recibido', 'preparando', 'listo', 'en_camino', 'entregado'];
            const estadoActual = data.estado_seguimiento || 'recibido';
            
            estados.forEach((estado, index) => {
                const item = document.querySelector(`.timeline-item:nth-child(${index + 1})`);
                if (item) {
                    item.classList.remove('active', 'completed');
                    
                    if (estados.indexOf(estadoActual) > index) {
                        item.classList.add('completed');
                    } else if (estados.indexOf(estadoActual) === index) {
                        item.classList.add('active');
                    }
                }
            });
            
            // Actualizar ubicación en el mapa si está disponible
            if (data.latitud && data.longitud && (estadoActual === 'en_camino' || estadoActual === 'listo')) {
                if (typeof google !== 'undefined' && google.maps) {
                    actualizarUbicacionMapa(parseFloat(data.latitud), parseFloat(data.longitud));
                }
                
                // Mostrar mapa si estaba oculto
                const mapContainer = document.getElementById('map-container');
                if (mapContainer && mapContainer.parentElement) {
                    mapContainer.parentElement.style.display = 'block';
                }
            }
            
            // Si está entregado, detener la actualización
            if (estadoActual === 'entregado') {
                if (intervalo) {
                    clearInterval(intervalo);
                }
                if (marcador) {
                    marcador.setAnimation(null);
                }
            }
        })
        .catch(error => {
            console.error('Error al actualizar estado:', error);
        });
}

// Iniciar actualización automática solo si existe el pedido
if (pedidoId) {
    intervalo = setInterval(actualizarEstado, 10000);
    // Actualizar inmediatamente
    actualizarEstado();
}
@endif
</script>

@endsection

