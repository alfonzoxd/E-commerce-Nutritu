@extends('layouts.app')

@section('title', $producto['nombre'])

@section('content')
  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-lg p-6 flex flex-col lg:flex-row gap-8">

    {{-- Slider de imágenes --}}
    <div class="swiper flex-1 h-[500px]">
      <div class="swiper-wrapper">
        @foreach($producto['imagenes'] as $img)
          <div class="swiper-slide h-full relative overflow-hidden rounded">
            <img src="{{ asset($img) }}"
                 alt="{{ $producto['nombre'] }}"
                 class="w-full h-full object-cover rounded zoom-image transition-transform duration-300 ease-out"
                 />
          </div>
        @endforeach
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>

    {{-- Información y descripción --}}
    <div class="flex-1 flex flex-col">
      <h1 class="text-4xl font-bold mb-4">{{ $producto['nombre'] }}</h1>
      <ul class="list-disc list-inside mb-4 text-gray-700">
        @foreach(explode('||', $producto['descripcion_text']) as $item)
          <li>{{ $item }}</li>
        @endforeach
      </ul>
      <div class="text-2xl font-semibold mb-6">
        S/. {{ number_format($producto['precio'],2) }}
      </div>

      {{-- Formulario añadir al carrito --}}
      <form action="{{ route('carrito.agregar', $id) }}" method="POST" class="mt-auto">
        @csrf
        <label class="block mb-2 font-medium">Cantidad:</label>
        <input type="number"
               name="cantidad"
               value="1"
               min="1"
               class="w-24 p-2 border rounded mb-4" />

        <button type="submit"
                class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
          Añadir al carrito
        </button>
      </form>
    </div>

  </div>

  <style>
    .zoom-image {
      transform-origin: center center;
      cursor: zoom-in;
    }
  </style>

  <script>
    document.querySelectorAll('.zoom-image').forEach(img => {
      img.addEventListener('mousemove', e => {
        const rect = img.getBoundingClientRect();
        const x = e.clientX - rect.left; // x position within the element.
        const y = e.clientY - rect.top;  // y position within the element.

        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = 'scale(1.5)'; // Zoom aumentado
      });

      img.addEventListener('mouseleave', e => {
        img.style.transformOrigin = 'center center';
        img.style.transform = 'scale(1)';
      });
    });
  </script>
@endsection
