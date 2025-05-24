{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','NutriTÚ Shop')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  @stack('styles')
</head>
@stack('scripts')
<body class="flex flex-col min-h-screen">

  {{-- CONTENEDOR: Logo arriba, navegación abajo --}}
<div class="bg-gradient-to-r from-green-100 via-white to-green-100 mb-6 shadow border-b border-green-200">
    <div class="container mx-auto px-4 py-6 flex flex-col items-center">

      {{-- Logo --}}
      <a href="{{ route('home') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo NutriTÚ" class="h-20 w-auto mb-4">
      </a>

      {{-- Navegación + Buscador en la misma fila --}}
      <div class="w-full max-w-4xl flex items-center justify-between">

        {{-- Menú de secciones --}}
        <nav class="flex items-center space-x-6">
          <a href="{{ route('home') }}" class="text-green-700 font-semibold hover:text-green-500">Inicio</a>

          <div class="relative group">
            <span class="text-green-700 font-semibold hover:text-green-500 cursor-pointer">Categorías</span>
            <ul class="absolute hidden group-hover:block bg-white bg-opacity-80 shadow mt-2 z-50 rounded">
              @foreach($categorias as $slug => $label)
                <li>
                  <a href="{{ route('secciones', $slug) }}"
                     class="block px-4 py-2 hover:bg-green-200">
                    {{ $label }}
                  </a>
                </li>
              @endforeach
            </ul>
          </div>

          <a href="{{ route('carrito') }}" class="text-green-700 font-semibold hover:text-green-500">Carrito</a>
          <a href="{{ route('contactanos') }}" class="text-green-700 font-semibold hover:text-green-500">Contáctanos</a>
        </nav>

        {{-- Buscador --}}
        <form action="{{ route('secciones') }}" method="GET" class="relative">
          <input
            type="text"
            name="buscar"
            placeholder="Buscar..."
            class="w-48 focus:w-64 transition-all duration-300 ease-in-out border border-green-300 rounded-full px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white bg-opacity-90"
          >
          <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-green-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
            </svg>
          </button>
        </form>

      </div>
    </div>
  </div>

  {{-- CONTENIDO PRINCIPAL --}}
  <main class="flex-grow container mx-auto px-4">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  <footer class="mt-10 bg-white bg-opacity-80 shadow py-4 text-center border-t border-gray-200 text-green-700 font-semibold hover:text-green-500">
    © {{ date('Y') }} NutriTÚ. Todos los derechos reservados.
  </footer>

  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 800,
      once: true,
    });
  </script>
</body>
</html>
