@extends('layouts.app')

@section('title','home')

@section('content')
  {{-- Carousel --}}
  <div class="mb-8">
    <div class="swiper shadow-lg rounded-lg overflow-hidden">
      <div class="swiper-wrapper">
        <div class="swiper-slide">
          <img src="{{ asset('images/banner1.jpg') }}" alt="Banner 1" class="w-full h-64 object-cover">
        </div>
        <div class="swiper-slide">
          <img src="{{ asset('images/banner2.jpg') }}" alt="Banner 2" class="w-full h-64 object-cover">
        </div>
        <div class="swiper-slide">
          <img src="{{ asset('images/banner3.jpg') }}" alt="Banner 3" class="w-full h-64 object-cover">
        </div>
      </div>
      <div class="swiper-pagination"></div>
      <div class="swiper-button-prev"></div>
      <div class="swiper-button-next"></div>
    </div>
  </div>

  {{-- Filtros + Orden + Productos --}}
  <div class="flex">
    {{-- Filtros de Categoría --}}
    <aside class="w-64 pr-6">
      <h2 class="text-xl font-semibold mb-4">Categorías</h2>
      <form method="GET" action="{{ route('home') }}" id="filtro-form">
        @foreach(config('productos.categorias') as $key => $label)
          <div class="mb-2">
            <label class="inline-flex items-center">
              <input type="checkbox" name="categorias[]" value="{{ $key }}"
                     {{ in_array($key, request()->get('categorias', [])) ? 'checked' : '' }}
                     class="form-checkbox text-indigo-600">
              <span class="ml-2">{{ $label }}</span>
            </label>
          </div>
        @endforeach

        {{-- Select para ordenar --}}
        <div class="mt-4">
          <label for="orden" class="block mb-1 font-semibold">Ordenar por:</label>
          <select name="orden" id="orden"
                  class="w-full border border-gray-300 rounded px-3 py-2">
            <option value="">-- Seleccionar --</option>
            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio ascendente</option>
            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio descendente</option>
            <option value="nombre_asc" {{ request('orden') == 'nombre_asc' ? 'selected' : '' }}>Nombre A-Z</option>
            <option value="nombre_desc" {{ request('orden') == 'nombre_desc' ? 'selected' : '' }}>Nombre Z-A</option>
          </select>
        </div>

        <button type="submit"
                class="mt-4 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          Filtrar
        </button>
      </form>
    </aside>

    {{-- Productos Destacados --}}
    <div class="flex-1">
      <h1 class="text-3xl font-semibold mb-4">Productos Destacados</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($destacados as $key => $prod)
          <div data-aos="fade-up"
               data-aos-delay="{{ $loop->index * 100 }}"
               class="relative bg-white p-4 rounded shadow hover:shadow-lg transition transform hover:scale-105 duration-300 flex flex-col">

            {{-- Etiqueta de Categoría --}}
            <span class="absolute top-2 left-2 bg-indigo-500 text-white px-2 py-1 text-xs rounded">
              {{ config('productos.categorias')[$prod['categoria']] }}
            </span>

            {{-- Botón de Favorito --}}
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

            <a href="{{ route('producto.detalle', $key) }}">
              <img src="{{ asset($prod['imagen']) }}"
                   alt="{{ $prod['nombre'] }}"
                   class="h-32 mx-auto mb-2">
              <h2 class="font-bold text-lg">{{ $prod['nombre'] }}</h2>
              <p class="flex-grow">{{ Str::limit($prod['descripcion_text'], 60) }}</p>
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
    // Manejo de favoritos con localStorage
    const favoritos = JSON.parse(localStorage.getItem('favoritos') || '[]');

    // Inicializar íconos marcados
    favoritos.forEach(id => {
      const btn = document.querySelector(`.favorito-btn[data-id="${id}"]`);
      if (btn) btn.classList.add('text-red-500');
    });

    // Manejar clics en favoritos
    document.querySelectorAll('.favorito-btn').forEach(btn => {
      btn.addEventListener('click', function () {
        const id = this.dataset.id;
        const index = favoritos.indexOf(id);

        if (index !== -1) {
          favoritos.splice(index, 1);
          this.classList.remove('text-red-500');
        } else {
          favoritos.push(id);
          this.classList.add('text-red-500');
        }

        localStorage.setItem('favoritos', JSON.stringify(favoritos));
      });
    });

    // Auto-enviar formulario si se cambia el orden
    document.getElementById('orden').addEventListener('change', function () {
      document.getElementById('filtro-form').submit();
    });
  });
</script>
@endpush
