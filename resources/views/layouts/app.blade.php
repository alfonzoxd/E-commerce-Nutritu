<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title','NutriTÚ Shop')</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
@stack('scripts')

<body class="flex flex-col min-h-screen bg-gray-100">
  <header class="bg-white shadow mb-6">
    <nav class="container mx-auto p-4 flex justify-between items-center">
      <a href="{{ route('home') }}" class="text-2xl font-bold">NutriTÚ</a>

      {{-- Barra de búsqueda --}}
      <form action="{{ route('secciones') }}" method="GET" class="relative ml-4 w-full max-w-md">
        <input
          type="text"
          name="buscar"
          placeholder="Buscar productos..."
          class="w-full border rounded-full px-4 py-2 pl-10 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
        <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
               viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/>
          </svg>
        </button>
      </form>

      {{-- Navegación --}}
      <ul class="flex space-x-4">
        <li><a href="{{ route('home') }}">Inicio</a></li>
        <li class="relative group">
          <ul class="absolute hidden group-hover:block bg-white shadow mt-2 z-50">
            @foreach($categorias as $slug => $label)
              <li>
                <a href="{{ route('secciones', $slug) }}"
                   class="block px-4 py-2 hover:bg-gray-100">
                  {{ $label }}
                </a>
              </li>
            @endforeach
          </ul>
        </li>
        <li><a href="#">Carrito</a></li>
      </ul>
    </nav>
  </header>

  <main class="flex-grow container mx-auto px-4">
    @yield('content')
  </main>

  <footer class="bg-white shadow py-4 text-center">
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
