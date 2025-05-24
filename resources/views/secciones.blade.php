@extends('layouts.app')

@section('title', $categoria
    ? ucfirst($categorias[$categoria])
    : 'Todas las Secciones')

@section('content')
  <h1 class="text-3xl font-semibold mb-4">
    {{ $categoria
       ? $categorias[$categoria]
       : 'Todos los Productos' }}
  </h1>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    @forelse($productos as $prod)
    @if(request('buscar'))
    <p class="text-sm text-gray-600 mb-4">
        Resultados para: <strong>{{ request('buscar') }}</strong>
    </p>
    @endif

      <a href="{{ route('producto.detalle', $loop->index) }}"
        class="bg-white p-4 rounded shadow flex flex-col hover:shadow-lg transition">
        <img src="{{ asset($prod['imagen']) }}" alt="{{ $prod['nombre'] }}" class="h-32 w-full object-cover mb-2 rounded">
        <h2 class="font-bold text-lg">{{ $prod['nombre'] }}</h2>
        <p class="text-sm flex-grow">{{ Str::limit($prod['descripcion_text'], 80) }}</p>
        <div class="mt-2 font-semibold">S/. {{ number_format($prod['precio'],2) }}</div>
    </a>
    @empty
      <p>No hay productos en esta categoría.</p>
    @endforelse
  </div>
@endsection
