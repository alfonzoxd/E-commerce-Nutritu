@extends('layouts.app')

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

@section('title','Carrito de Compras')

@section('content')
  <h1 class="text-3xl font-semibold mb-4">Tu Carrito</h1>

  {{-- Mensaje flash --}}
  @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded mb-4">
      {{ session('success') }}
    </div>
  @elseif(session('warning'))
    <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-4">
      {{ session('warning') }}
    </div>
  @elseif(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded mb-4">
      {{ session('error') }}
    </div>
  @endif

  @if(count($carrito))
    <table class="w-full bg-white rounded shadow overflow-hidden">
      <thead class="bg-gray-100">
        <tr class="text-left">
          <th class="px-4 py-2">Producto</th>
          <th class="px-4 py-2">Cantidad</th>
          <th class="px-4 py-2">Precio Unitario</th>
          <th class="px-4 py-2">Subtotal</th>
          <th class="px-4 py-2">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach($carrito as $index => $item)
          @php
            $sub = $item['cantidad'] * $item['precio'];
            $total += $sub;
          @endphp
          <tr class="border-t">
            <td class="px-4 py-2">{{ $item['producto'] }}</td>
            <td class="px-4 py-2">{{ $item['cantidad'] }}</td>
            <td class="px-4 py-2">S/. {{ number_format($item['precio'],2) }}</td>
            <td class="px-4 py-2">S/. {{ number_format($sub,2) }}</td>
            <td class="px-4 py-2">
              <form action="{{ route('carrito.eliminar', $index) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto del carrito?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-100 text-red-700 px-3 py-1 rounded hover:bg-red-200 transition">
                  Eliminar
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-gray-100">
        <tr>
          <td colspan="4" class="px-4 py-2 font-bold text-right">Total</td>
          <td class="px-4 py-2 font-bold">S/. {{ number_format($total,2) }}</td>
        </tr>
      </tfoot>
    </table>

    <div class="mt-6 text-right">
      <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition inline-block">
        Finalizar Compra
      </a>
    </div>
  @else
    <p>Tu carrito está vacío.</p>
  @endif
@endsection
