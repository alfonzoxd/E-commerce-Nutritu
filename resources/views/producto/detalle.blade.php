@extends('layouts.app')
<style>
  body {
    background: url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
    background-size: cover;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.4);
    pointer-events: none;
    z-index: -1;
  }

  .zoom-image {
    transform-origin: center center;
    cursor: zoom-in;
  }

  .card-translucent {
    background: rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 1rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
  }
</style>

@section('title', $producto['nombre'])

@section('content')
<div data-aos="fade-up"
     class="max-w-4xl mx-auto card-translucent transition transform hover:scale-105 duration-300 p-6 flex flex-col lg:flex-row gap-8">
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
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const xPercent = (x / rect.width) * 100;
        const yPercent = (y / rect.height) * 100;

        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;
        img.style.transform = 'scale(1.5)'; 
      });

      img.addEventListener('mouseleave', e => {
        img.style.transformOrigin = 'center center';
        img.style.transform = 'scale(1)';
      });
    });
  </script>
@endsection
