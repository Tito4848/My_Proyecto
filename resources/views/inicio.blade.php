@extends('layouts.app')

@section('content')
<div class="hero">
  <h1>Bienvenido a Sal & Sabor</h1>
</div>

<div class="text-center my-5">
  <p class="fs-5">Creemos en los placeres sencillos de la vida.<br>
  Buena comida, ingredientes frescos y buena vibra.<br>
  Siéntete como en casa.</p>

  <a href="/menu" class="btn btn-danger m-2">Ver menú</a>
  <a href="/reserva" class="btn btn-outline-danger m-2">Reservar mesa</a>
</div>

<div class="row my-4">
  <div class="col-md-6">
    <img src="https://imgmedia.wapa.pe/1200x630/wapa/original/2024/07/20/669c1868a546d369a0226b6f.webp" class="img-fluid rounded shadow">
  </div>
  <div class="col-md-6 d-flex flex-column justify-content-center">
    <h3>La favorita de los fans: Pollo a la Brasa 🍗</h3>
    <p>Preparado al estilo peruano con papas doradas y ají especial. ¡Pide el tuyo ahora!</p>
    <a href="/menu" class="btn btn-danger w-50">Ver más</a>
  </div>
</div>
@endsection
