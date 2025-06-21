@extends('layouts.app')

@push('styles')
<style>
  body {
    background: url("{{ asset('images/fondo.jpg') }}") no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255, 255, 255, 0.6);
    pointer-events: none;
    z-index: -1;
  }

  .payment-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
  }

  .step-indicator {
    position: relative;
  }

  .step-indicator::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 100%;
    width: 50px;
    height: 2px;
    background: #e5e7eb;
    transform: translateY(-50%);
  }

  .step-indicator.active::after {
    background: #3b82f6;
  }

  .step-indicator:last-child::after {
    display: none;
  }

  .input-group {
    position: relative;
  }

  .input-group input:focus + label,
  .input-group input:not(:placeholder-shown) + label {
    transform: translateY(-25px) scale(0.85);
    color: #3b82f6;
  }

  .input-group label {
    position: absolute;
    left: 12px;
    top: 12px;
    color: #6b7280;
    transition: all 0.2s ease;
    pointer-events: none;
    background: white;
    padding: 0 4px;
  }

  .card-preview {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 15px;
    color: white;
    position: relative;
    overflow: hidden;
  }

  .card-preview::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: shimmer 3s infinite;
  }

  @keyframes shimmer {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }

  .pulse-animation {
    animation: pulse 2s infinite;
  }

  @keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
  }

  .alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
  }

  .alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
  }

  .alert-error {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
  }

  /* Mejorar la legibilidad del texto sobre la imagen de fondo */
  .text-title {
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    color: #1f2937;
  }

  .text-subtitle {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
    color: #374151;
  }

  .step-text {
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);
    color: #1f2937;
  }
</style>
@endpush

@section('title', 'Checkout - Pasarela de Pagos')

@section('content')
<div class="container mx-auto px-4 py-8">
  <div class="max-w-6xl mx-auto">

    @if ($errors->any())
      <div class="alert alert-error mb-6">
        <strong>Por favor corrige los siguientes errores:</strong>
        <ul class="list-disc list-inside mt-2">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="text-center mb-8">
      <h1 class="text-4xl font-bold text-title mb-2">Finalizar Compra</h1>
      <p class="text-subtitle">Completa tu pedido de forma segura</p>
    </div>

    <div class="flex justify-center items-center mb-8">
      <div class="flex items-center space-x-4">
        <div class="step-indicator active flex items-center">
          <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold">1</div>
          <span class="ml-2 step-text font-medium">Información</span>
        </div>
        <div class="step-indicator flex items-center">
          <div class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold">2</div>
          <span class="ml-2 step-text font-medium">Pago</span>
        </div>
        <div class="step-indicator flex items-center">
          <div class="w-10 h-10 bg-gray-300 text-gray-600 rounded-full flex items-center justify-center font-bold">3</div>
          <span class="ml-2 step-text font-medium">Confirmación</span>
        </div>
      </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">

      <div class="lg:col-span-2">
        <div class="payment-card p-8">
          <form id="checkout-form" action="{{ route('checkout.process') }}" method="POST">
            @csrf

            <!-- Información Personal -->
            <div class="mb-8">
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Información Personal</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div class="input-group">
                  <input type="text" id="nombre" name="nombre" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('nombre') }}" required>
                  <label for="nombre">Nombre Completo</label>
                </div>
                <div class="input-group">
                  <input type="email" id="email" name="email" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('email') }}" required>
                  <label for="email">Correo Electrónico</label>
                </div>
                <div class="input-group">
                  <input type="tel" id="telefono" name="telefono" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('telefono') }}" required>
                  <label for="telefono">Teléfono</label>
                </div>
                <div class="input-group">
                  <input type="text" id="documento" name="documento" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('documento') }}" required>
                  <label for="documento">DNI/Documento</label>
                </div>
              </div>
            </div>

            <!-- Dirección de Envío -->
            <div class="mb-8">
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Dirección de Envío</h3>
              <div class="grid md:grid-cols-2 gap-4">
                <div class="input-group md:col-span-2">
                  <input type="text" id="direccion" name="direccion" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('direccion') }}" required>
                  <label for="direccion">Dirección Completa</label>
                </div>
                <div class="input-group">
                  <input type="text" id="ciudad" name="ciudad" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('ciudad') }}" required>
                  <label for="ciudad">Ciudad</label>
                </div>
                <div class="input-group">
                  <input type="text" id="codigo_postal" name="codigo_postal" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('codigo_postal') }}" required>
                  <label for="codigo_postal">Código Postal</label>
                </div>
              </div>
            </div>

            <!-- Información de Pago -->
            <div class="mb-8">
              <h3 class="text-xl font-semibold mb-4 text-gray-800">Información de Pago</h3>

              <!-- Métodos de Pago -->
              <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <label class="payment-method cursor-pointer">
                  <input type="radio" name="metodo_pago" value="visa" class="sr-only" {{ old('metodo_pago') == 'visa' || !old('metodo_pago') ? 'checked' : '' }}>
                  <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                    <div class="text-2xl mb-2">💳</div>
                    <div class="text-sm font-medium">Visa</div>
                  </div>
                </label>
                <label class="payment-method cursor-pointer">
                  <input type="radio" name="metodo_pago" value="mastercard" class="sr-only" {{ old('metodo_pago') == 'mastercard' ? 'checked' : '' }}>
                  <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                    <div class="text-2xl mb-2">💳</div>
                    <div class="text-sm font-medium">Mastercard</div>
                  </div>
                </label>
                <label class="payment-method cursor-pointer">
                  <input type="radio" name="metodo_pago" value="paypal" class="sr-only" {{ old('metodo_pago') == 'paypal' ? 'checked' : '' }}>
                  <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                    <div class="text-2xl mb-2">🅿️</div>
                    <div class="text-sm font-medium">PayPal</div>
                  </div>
                </label>
                <label class="payment-method cursor-pointer">
                  <input type="radio" name="metodo_pago" value="yape" class="sr-only" {{ old('metodo_pago') == 'yape' ? 'checked' : '' }}>
                  <div class="border-2 border-gray-200 rounded-lg p-4 text-center hover:border-blue-500 transition">
                    <div class="text-2xl mb-2">📱</div>
                    <div class="text-sm font-medium">Yape</div>
                  </div>
                </label>
              </div>

              <!-- Datos de Tarjeta -->
              <div id="card-details" class="space-y-4">
                <div class="input-group">
                  <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " maxlength="19" value="{{ old('numero_tarjeta') }}">
                  <label for="numero_tarjeta">Número de Tarjeta</label>
                </div>
                <div class="grid md:grid-cols-3 gap-4">
                  <div class="input-group">
                    <input type="text" id="titular" name="titular" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " value="{{ old('titular') }}">
                    <label for="titular">Nombre del Titular</label>
                  </div>
                  <div class="input-group">
                    <input type="text" id="expiracion" name="expiracion" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " maxlength="5" value="{{ old('expiracion') }}">
                    <label for="expiracion">MM/AA</label>
                  </div>
                  <div class="input-group">
                    <input type="text" id="cvv" name="cvv" class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 transition" placeholder=" " maxlength="4" value="{{ old('cvv') }}">
                    <label for="cvv">CVV</label>
                  </div>
                </div>
              </div>
            </div>

            <!-- Términos y Condiciones -->
            <div class="mb-6">
              <label class="flex items-center">
                <input type="checkbox" class="mr-2" required>
                <span class="text-sm text-gray-600">Acepto los <a href="#" class="text-blue-600 hover:underline">términos y condiciones</a> y la <a href="#" class="text-blue-600 hover:underline">política de privacidad</a></span>
              </label>
            </div>

            <!-- Botón de Pago -->
            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold py-4 px-6 rounded-lg hover:from-blue-700 hover:to-purple-700 transition duration-300 transform hover:scale-105">
              <span class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Pagar Ahora
              </span>
            </button>

            <!-- Botón para volver al carrito -->
            <div class="mt-4">
              <a href="{{ route('carrito') }}" class="w-full bg-gray-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-gray-600 transition duration-300 flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Volver al Carrito
              </a>
            </div>
          </form>
        </div>
      </div>

      <!-- Resumen del Pedido -->
      <div class="lg:col-span-1">
        <div class="payment-card p-6 sticky top-8">
          <h3 class="text-xl font-semibold mb-4 text-gray-800">Resumen del Pedido</h3>

          <!-- Productos -->
          <div class="space-y-3 mb-6">
            @if(isset($carrito) && count($carrito))
              @php $total = 0; @endphp
              @foreach($carrito as $item)
                @php
                  $sub = $item['cantidad'] * $item['precio'];
                  $total += $sub;
                @endphp
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                  <div>
                    <div class="font-medium text-sm">{{ $item['producto'] }}</div>
                    <div class="text-xs text-gray-500">Cantidad: {{ $item['cantidad'] }}</div>
                  </div>
                  <div class="font-semibold">S/. {{ number_format($sub, 2) }}</div>
                </div>
              @endforeach
            @else
              <div class="text-center py-4 text-gray-500">
                <p>No hay productos en el carrito</p>
              </div>
            @endif
          </div>

          <!-- Totales -->
          <div class="space-y-2 mb-6">
            <div class="flex justify-between">
              <span>Subtotal</span>
              <span>S/. {{ isset($total) ? number_format($total, 2) : '0.00' }}</span>
            </div>
            <div class="flex justify-between">
              <span>Envío</span>
              <span>S/. 5.00</span>
            </div>
            <div class="flex justify-between">
              <span>IGV (18%)</span>
              <span>S/. {{ isset($total) ? number_format(($total + 5) * 0.18, 2) : '0.00' }}</span>
            </div>
            <hr class="my-2">
            <div class="flex justify-between font-bold text-lg">
              <span>Total</span>
              <span>S/. {{ isset($total) ? number_format(($total + 5) * 1.18, 2) : '0.00' }}</span>
            </div>
          </div>

          <!-- Garantías -->
          <div class="space-y-3 text-sm text-gray-600">
            <div class="flex items-center">
              <div class="w-4 h-4 bg-green-100 rounded-full flex items-center justify-center mr-2">
                <svg class="w-2 h-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <span>Pago 100% seguro</span>
            </div>
            <div class="flex items-center">
              <div class="w-4 h-4 bg-green-100 rounded-full flex items-center justify-center mr-2">
                <svg class="w-2 h-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <span>Envío garantizado</span>
            </div>
            <div class="flex items-center">
              <div class="w-4 h-4 bg-green-100 rounded-full flex items-center justify-center mr-2">
                <svg class="w-2 h-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
              </div>
              <span>Soporte 24/7</span>
            </div>
          </div>
        </div>

        <!-- Tarjeta de Vista Previa -->
        <div class="payment-card p-6 mt-6">
          <h4 class="font-semibold mb-4 text-gray-800">Vista Previa de Tarjeta</h4>
          <div class="card-preview p-6 mb-4">
            <div class="flex justify-between items-start mb-8">
              <div class="text-sm opacity-75">BANCO</div>
              <div class="text-sm opacity-75">VISA</div>
            </div>
            <div class="text-lg font-mono tracking-wider mb-6" id="card-number-preview">
              •••• •••• •••• ••••
            </div>
            <div class="flex justify-between items-end">
              <div>
                <div class="text-xs opacity-75">TITULAR</div>
                <div class="font-medium" id="card-holder-preview">NOMBRE APELLIDO</div>
              </div>
              <div>
                <div class="text-xs opacity-75">VENCE</div>
                <div class="font-medium" id="card-expiry-preview">••/••</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const numeroTarjeta = document.getElementById('numero_tarjeta');
  const cardPreview = document.getElementById('card-number-preview');

  numeroTarjeta.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
    e.target.value = formattedValue;

    if (value.length > 0) {
      let maskedValue = value.replace(/\d(?=\d{4})/g, '•');
      cardPreview.textContent = maskedValue.match(/.{1,4}/g)?.join(' ') || '•••• •••• •••• ••••';
    } else {
      cardPreview.textContent = '•••• •••• •••• ••••';
    }
  });

  const expiracion = document.getElementById('expiracion');
  const expiryPreview = document.getElementById('card-expiry-preview');

  expiracion.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
      value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
    expiryPreview.textContent = value || '••/••';
  });

  const titular = document.getElementById('titular');
  const holderPreview = document.getElementById('card-holder-preview');

  titular.addEventListener('input', function(e) {
    holderPreview.textContent = e.target.value.toUpperCase() || 'NOMBRE APELLIDO';
  });

  const cvv = document.getElementById('cvv');
  cvv.addEventListener('input', function(e) {
    e.target.value = e.target.value.replace(/\D/g, '');
  });

  const paymentMethods = document.querySelectorAll('input[name="metodo_pago"]');
  const cardDetails = document.getElementById('card-details');

  paymentMethods.forEach(method => {
    method.addEventListener('change', function() {
      paymentMethods.forEach(m => {
        m.closest('.payment-method').querySelector('div').classList.remove('border-blue-500', 'bg-blue-50');
        m.closest('.payment-method').querySelector('div').classList.add('border-gray-200');
      });

      this.closest('.payment-method').querySelector('div').classList.add('border-blue-500', 'bg-blue-50');
      this.closest('.payment-method').querySelector('div').classList.remove('border-gray-200');

      if (this.value === 'visa' || this.value === 'mastercard') {
        cardDetails.style.display = 'block';
      } else {
        cardDetails.style.display = 'none';
      }
    });
  });

  const selectedMethod = document.querySelector('input[name="metodo_pago"]:checked');
  if (selectedMethod) {
    selectedMethod.dispatchEvent(new Event('change'));
  }

  document.getElementById('checkout-form').addEventListener('submit', function(e) {
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;

    submitBtn.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Procesando...</span>';
    submitBtn.disabled = true;
  });
});
</script>
@endsection
