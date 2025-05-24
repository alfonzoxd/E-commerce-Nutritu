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

  @if(count($carrito))
    <table class="w-full bg-white rounded shadow overflow-hidden">
      <thead class="bg-gray-100">
        <tr class="text-left">
          <th class="px-4 py-2">Producto</th>
          <th class="px-4 py-2">Cantidad</th>
          <th class="px-4 py-2">Precio Unitario</th>
          <th class="px-4 py-2">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php $total = 0; @endphp
        @foreach($carrito as $item)
          @php
            $sub = $item['cantidad'] * $item['precio'];
            $total += $sub;
          @endphp
          <tr class="border-t">
            <td class="px-4 py-2">{{ $item['producto'] }}</td>
            <td class="px-4 py-2">{{ $item['cantidad'] }}</td>
            <td class="px-4 py-2">S/. {{ number_format($item['precio'],2) }}</td>
            <td class="px-4 py-2">S/. {{ number_format($sub,2) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot class="bg-gray-100">
        <tr>
          <td colspan="3" class="px-4 py-2 font-bold text-right">Total</td>
          <td class="px-4 py-2 font-bold">S/. {{ number_format($total,2) }}</td>
        </tr>
      </tfoot>
    </table>

    <div class="mt-6 text-right">
      <button class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 disabled:opacity-50" disabled>
        Finalizar Compra
      </button>
    </div>
  @else
    <p>Tu carrito está vacío.</p>
  @endif
@endsection
