<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','NutriTÚ Shop')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  @stack('styles')
  <style>
    /* Animaciones personalizadas para el dropdown */
    .dropdown-menu {
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px) scale(0.95);
      transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .dropdown:hover .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0) scale(1);
    }

    .dropdown-item {
      transform: translateX(-10px);
      opacity: 0;
      transition: all 0.2s ease;
    }

    .dropdown:hover .dropdown-item {
      transform: translateX(0);
      opacity: 1;
    }

    .dropdown:hover .dropdown-item:nth-child(1) { transition-delay: 0.1s; }
    .dropdown:hover .dropdown-item:nth-child(2) { transition-delay: 0.15s; }
    .dropdown:hover .dropdown-item:nth-child(3) { transition-delay: 0.2s; }
    .dropdown:hover .dropdown-item:nth-child(4) { transition-delay: 0.25s; }
    .dropdown:hover .dropdown-item:nth-child(5) { transition-delay: 0.3s; }

    .dropdown-arrow {
      transition: transform 0.3s ease;
    }

    .dropdown:hover .dropdown-arrow {
      transform: rotate(180deg);
    }
  </style>
</head>
@stack('scripts')
<body class="flex flex-col min-h-screen">

<div class="bg-gradient-to-r from-green-100 via-white to-green-100 mb-6 shadow border-b border-green-200">
  <div class="container mx-auto px-4 py-6 flex flex-col items-center">

    <a href="{{ route('home') }}">
      <img src="{{ asset('images/logo.png') }}" alt="Logo NutriTÚ" class="h-20 w-auto mb-4">
    </a>

    <div class="w-full max-w-4xl flex items-center justify-between">

      <nav class="flex items-center space-x-6">
        <a href="{{ route('home') }}" class="text-green-700 font-semibold hover:text-green-500 transition-colors duration-200">Inicio</a>

        <div class="relative dropdown">
          <button class="flex items-center text-green-700 font-semibold hover:text-green-500 cursor-pointer transition-colors duration-200">
            <span>Categorías</span>
            <svg class="ml-1 h-4 w-4 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
          </button>

          <div class="dropdown-menu absolute left-0 mt-2 w-64 bg-white rounded-xl shadow-2xl border border-green-100 z-50 overflow-hidden">
            <div class="py-3">
              @foreach($categorias as $slug => $label)
                <a href="{{ route('secciones', $slug) }}"
                   class="dropdown-item flex items-center px-6 py-3 text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-green-100 hover:text-green-700 transition-all duration-200 border-l-4 border-transparent hover:border-green-400">
                  <div class="w-2 h-2 bg-green-400 rounded-full mr-3 opacity-0 transition-opacity duration-200 group-hover:opacity-100"></div>
                  <span class="font-medium">{{ $label }}</span>
                  <svg class="ml-auto h-4 w-4 text-green-400 opacity-0 transition-all duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                  </svg>
                </a>
              @endforeach
            </div>

            <!-- Elemento decorativo en la parte inferior -->
            <div class="h-1 bg-gradient-to-r from-green-400 via-green-500 to-green-600"></div>
          </div>
        </div>

        <a href="{{ route('contactanos') }}" class="text-green-700 font-semibold hover:text-green-500 transition-colors duration-200">Contáctanos</a>
      </nav>

      <div class="flex items-center space-x-4">
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

        <!-- Instagram Link -->
        <a href="https://www.instagram.com/nutritu_23/" target="_blank" rel="noopener noreferrer"
           class="text-green-700 hover:text-pink-500 transition-colors duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 7.377a4.623 4.623 0 100 9.246 4.623 4.623 0 000-9.246zm0 7.627a3.004 3.004 0 110-6.008 3.004 3.004 0 010 6.008z"/>
            <circle cx="16.804" cy="7.207" r="1.078"/>
            <path d="M20.533 6.111A4.605 4.605 0 0017.9 3.479a6.606 6.606 0 00-2.186-.42c-.963-.042-1.268-.054-3.71-.054s-2.755 0-3.71.054a6.554 6.554 0 00-2.184.42 4.6 4.6 0 00-2.633 2.632 6.585 6.585 0 00-.419 2.186c-.043.962-.056 1.267-.056 3.71 0 2.442 0 2.753.056 3.71.015.748.156 1.486.419 2.187a4.61 4.61 0 002.634 2.632 6.584 6.584 0 002.185.45c.963.042 1.268.055 3.71.055s2.755 0 3.71-.055a6.615 6.615 0 002.186-.419 4.613 4.613 0 002.633-2.633c.263-.7.404-1.438.419-2.186.043-.962.056-1.267.056-3.71s0-2.753-.056-3.71a6.581 6.581 0 00-.421-2.217zm-1.218 9.532a5.043 5.043 0 01-.311 1.688 2.987 2.987 0 01-1.712 1.711 4.985 4.985 0 01-1.67.311c-.95.044-1.218.055-3.654.055-2.438 0-2.687 0-3.655-.055a4.96 4.96 0 01-1.669-.311 2.985 2.985 0 01-1.719-1.711 5.08 5.08 0 01-.311-1.669c-.043-.95-.053-1.218-.053-3.654 0-2.437 0-2.686.053-3.655a5.038 5.038 0 01.311-1.687c.305-.789.93-1.41 1.719-1.712a5.01 5.01 0 011.669-.311c.951-.043 1.218-.055 3.655-.055s2.687 0 3.654.055a4.96 4.96 0 011.67.311 2.991 2.991 0 011.712 1.712 5.08 5.08 0 01.311 1.669c.043.951.054 1.218.054 3.655 0 2.436 0 2.698-.043 3.654h-.011z"/>
          </svg>
        </a>

        <a href="{{ route('carrito') }}" class="text-green-700 hover:text-green-500 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m14-9l2 9M9 21a1 1 0 102 0 1 1 0 10-2 0zm6 0a1 1 0 102 0 1 1 0 10-2 0z" />
            </svg>
        </a>
      </div>

    </div>
  </div>
</div>

<main class="flex-grow container mx-auto px-4">
  @yield('content')
</main>

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
