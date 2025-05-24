@extends('layouts.app')

@section('title','home')

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

  <div class="mb-8">
    <div class="swiper shadow-lg rounded-lg overflow-hidden">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="{{ asset('images/banner4.jpg') }}" alt="Banner 1"
               class="w-full h-80 md:h-120 object-cover">
        </div>
        <div class="swiper-slide">
          <img src="{{ asset('images/banner1.jpg') }}" alt="Banner 2"
               class="w-full h-80 md:h-120 object-cover">
        </div>
        <div class="swiper-slide">
          <img src="{{ asset('images/banner2.jpg') }}" alt="Banner 3"
               class="w-full h-80 md:h-120 object-cover">
        </div>
        <div class="swiper-slide">
          <img src="{{ asset('images/banner3.jpg') }}" alt="Banner 4"
               class="w-full h-80 md:h-120 object-cover">
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>


  <div class="flex">
    <aside class="w-64 pr-6">
      <h2 class="text-xl font-semibold mb-4">Categorías</h2>
      <form method="GET" action="{{ route('home') }}" id="filtro-form">
        @foreach(config('productos.categorias') as $key => $label)
          <div class="mb-2">
            <label class="inline-flex items-center">
              <input type="checkbox" name="categorias[]" value="{{ $key }}"
                     {{ in_array($key, request()->get('categorias', [])) ? 'checked' : '' }}
                     class="form-checkbox text-green-600">
              <span class="ml-2">{{ $label }}</span>
            </label>
          </div>
        @endforeach

        <div class="mt-4">
          <label for="orden" class="block mb-1 font-semibold">Ordenar por:</label>
          <select name="orden" id="orden"
                  class="w-full border border-dark bg-transparent text-black rounded px-3 py-2">
            <option value="">-- Seleccionar --</option>
            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio ascendente</option>
            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio descendente</option>
            <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
            <option value="nombre_desc" {{ request('orden') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
          </select>
        </div>

        <button type="submit"
                class="mt-4 px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700 transition">
          Filtrar
        </button>
      </form>
    </aside>

    <div class="flex-1">
      <h1 class="text-3xl font-semibold mb-4">Productos Destacados</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($destacados as $key => $prod)
          <div data-aos="fade-up"
               data-aos-delay="{{ $loop->index * 100 }}"
               class="relative bg-white bg-opacity-90 p-4 rounded shadow hover:shadow-lg transition transform hover:scale-105 duration-300 flex flex-col">

            <span class="absolute top-2 left-2 bg-green-600 text-black px-2 py-1 text-xs rounded">
              {{ config('productos.categorias')[$prod['categoria']] }}
            </span>

            <button type="button"
                    class="absolute top-2 right-2 text-gray-400 hover:text-red-500 favorito-btn"
                    data-id="{{ $key }}"
                    aria-label="Agregar a favoritos">
              <svg xmlns="http://www.w3.org/2000/svg"
                   class="h-6 w-6 fill-current"
                   viewBox="0 0 20 20">
                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.343l-6.828-6.829a4 4 0 010-5.656z"/>
              </svg>
            </button>

            <a href="{{ route('producto.detalle', $key) }}" class="mt-6 flex-grow">
              <img src="{{ asset($prod['imagen']) }}"
                   alt="{{ $prod['nombre'] }}"
                   class="h-32 mx-auto mb-2">
              <h2 class="font-bold text-lg">{{ $prod['nombre'] }}</h2>
              <p>{{ Str::limit($prod['descripcion_text'], 60) }}</p>
              <div class="mt-2 font-semibold">S/. {{ number_format($prod['precio'], 2) }}</div>
            </a>
          </div>
        @empty
          <p>No se encontraron productos en esta categoría.</p>
        @endforelse
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const favoritos = JSON.parse(localStorage.getItem('favoritos') || '[]');
    favoritos.forEach(id => {
      const btn = document.querySelector(`.favorito-btn[data-id="${id}"]`);
      if (btn) btn.classList.add('text-red-500');
    });
    document.querySelectorAll('.favorito-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const idx = favoritos.indexOf(id);
        if (idx !== -1) {
          favoritos.splice(idx, 1);
          this.classList.remove('text-red-500');
        } else {
          favoritos.push(id);
          this.classList.add('text-red-500');
        }
        localStorage.setItem('favoritos', JSON.stringify(favoritos));
      });
    });
    document.getElementById('orden').addEventListener('change', function () {
      document.getElementById('filtro-form').submit();
    });
  });
</script>
@endpush
