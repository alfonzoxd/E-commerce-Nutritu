@extends('layouts.app')

@section('title', $categoria
    ? ucfirst($categorias[$categoria])
    : 'Todas las Secciones')

@push('styles')
<style>
  body {
    background: url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
    background-size: cover;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.6);
    pointer-events: none;
    z-index: -1;
  }
</style>
@endpush

@section('content')
  <h1 class="text-3xl font-semibold mb-4">
    {{ $categoria ? $categorias[$categoria] : 'Todos los Productos' }}
  </h1>

  @if(request('buscar'))
    <p class="text-sm text-gray-600 mb-4">
      Resultados para: <strong>{{ request('buscar') }}</strong>
    </p>
  @endif

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($productos as $prod)
  <a href="{{ route('producto.detalle', $loop->index) }}"
     class="bg-white bg-opacity-90 p-4 rounded-lg shadow hover:shadow-lg transition transform hover:scale-105 duration-300 flex flex-col relative">

    @if(isset($prod['categoria']))
      <span class="absolute top-2 left-2 bg-green-600 text-black px-2 py-1 text-xs rounded">
        {{ config('productos.categorias')[$prod['categoria']] ?? '' }}
      </span>
    @endif

    <img src="{{ asset($prod['imagen']) }}"
         alt="{{ $prod['nombre'] }}"
         class="h-40 mx-auto mb-2 object-contain" />

    <h2 class="font-bold text-lg text-center">{{ $prod['nombre'] }}</h2>
    <p class="text-sm flex-grow text-gray-700 text-center">
      {{ Str::limit($prod['descripcion_text'], 80) }}
    </p>
    <div class="mt-2 font-semibold text-center text-gray-900">
      S/. {{ number_format($prod['precio'], 2) }}
    </div>
  </a>
    @empty
    <p>No hay productos en esta categoría.</p>
    @endforelse
  </div>
@endsection
