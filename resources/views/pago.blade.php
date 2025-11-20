@extends('layouts.app')

@section('title', 'Pago con Tarjeta')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="text-center text-danger mb-4">Pago con Tarjeta</h3>

                <form action="{{ route('pago.procesar') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre en la Tarjeta</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa nombre de tarjeta" required>
                    </div>

                    <div class="mb-3">
                        <label for="numero" class="form-label">Número de Tarjeta</label>
                        <input type="text" id="numero" name="numero" class="form-control" maxlength="16" placeholder="1234 5678 9012 3456" required>
                    </div>

                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="vencimiento" class="form-label">Vencimiento</label>
                            <input type="text" id="vencimiento" name="vencimiento" class="form-control" placeholder="MM/AA" maxlength="5" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="cvv" class="form-label">CVV</label>
                            <input type="text" id="cvv" name="cvv" class="form-control" maxlength="3" placeholder="123" required>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <h4 class="fw-bold text-danger mb-3">Total a Pagar: S/ {{ number_format($total, 2) }}</h4>
                        <button type="submit" class="btn btn-success w-100">Confirmar Pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
