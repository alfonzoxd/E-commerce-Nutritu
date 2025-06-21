<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'No hay productos en tu carrito.');
        }

        return view('checkout', compact('carrito'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string',
            'documento' => 'required|string',
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'codigo_postal' => 'required|string',
            'metodo_pago' => 'required|in:visa,mastercard,paypal,yape',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe tener un formato válido.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'documento.required' => 'El documento es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'codigo_postal.required' => 'El código postal es obligatorio.',
            'metodo_pago.required' => 'Debe seleccionar un método de pago.',
        ]);

        if (in_array($request->metodo_pago, ['visa', 'mastercard'])) {
            $request->validate([
                'numero_tarjeta' => 'required|string|min:16',
                'titular' => 'required|string|max:255',
                'expiracion' => 'required|string|size:5',
                'cvv' => 'required|string|min:3|max:4',
            ], [
                'numero_tarjeta.required' => 'El número de tarjeta es obligatorio.',
                'numero_tarjeta.min' => 'El número de tarjeta debe tener al menos 16 dígitos.',
                'titular.required' => 'El nombre del titular es obligatorio.',
                'expiracion.required' => 'La fecha de expiración es obligatoria.',
                'expiracion.size' => 'La fecha de expiración debe tener el formato MM/AA.',
                'cvv.required' => 'El CVV es obligatorio.',
                'cvv.min' => 'El CVV debe tener al menos 3 dígitos.',
            ]);
        }

        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = 0;
        foreach ($carrito as $item) {
            $subtotal += $item['cantidad'] * $item['precio'];
        }
        $envio = 5.00;
        $igv = ($subtotal + $envio) * 0.18;
        $total = $subtotal + $envio + $igv;

        $pagoExitoso = true;

        if ($pagoExitoso) {
            $pedido = [
                'id' => uniqid('order_'),
                'cliente' => $request->only(['nombre', 'email', 'telefono', 'documento']),
                'direccion' => $request->only(['direccion', 'ciudad', 'codigo_postal']),
                'metodo_pago' => $request->metodo_pago,
                'productos' => $carrito,
                'subtotal' => $subtotal,
                'envio' => $envio,
                'igv' => $igv,
                'total' => $total,
                'fecha' => now(),
                'estado' => 'procesado'
            ];

            session(['ultimo_pedido' => $pedido]);

            session()->forget('carrito');

            return redirect()->route('carrito')->with('success', '¡Pago procesado exitosamente! Tu pedido #' . $pedido['id'] . ' ha sido confirmado. Recibirás un correo de confirmación en breve.');
        } else {
            return redirect()->route('checkout')->with('error', 'Hubo un problema procesando tu pago. Por favor, intenta nuevamente.');
        }
    }
}
