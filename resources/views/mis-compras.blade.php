@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-4xl font-extrabold mb-8 text-gray-900">Mis Compras</h1>

    @if($pedidos->isEmpty())
        <p class="text-center text-gray-500 text-lg">No tienes compras registradas aún.</p>
    @else
        <div class="overflow-x-auto rounded-lg shadow-lg border border-gray-200">
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Pedido</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Fecha</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Total</th>
                        <th class="text-left py-4 px-6 text-sm font-semibold text-gray-700 uppercase tracking-wider">Estado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($pedidos as $pedido)
                    <tr class="hover:bg-gray-50 transition-colors duration-200 cursor-pointer">
                        <td class="py-4 px-6 whitespace-nowrap font-medium text-gray-900">#{{ $pedido->id }}</td>
                        <td class="py-4 px-6 whitespace-nowrap text-gray-600">{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td class="py-4 px-6 whitespace-nowrap font-semibold text-green-600">${{ number_format($pedido->total ?? 0, 2) }}</td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            @php
                                $estado = $pedido->estado ?? 'Pendiente';
                                $color = match($estado) {
                                    'Completado' => 'bg-green-100 text-green-800',
                                    'Cancelado' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $color }}">
                                {{ $estado }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
