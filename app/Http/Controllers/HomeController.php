<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $datos;

    public function __construct()
    {
        $this->datos = config('productos');
    }

    public function index(Request $request)
    {
        $data = config('productos');
        $categoriasSeleccionadas = $request->get('categorias', []);
        $orden = $request->get('orden');

        $productos = collect($data['productos']);

        if (!empty($categoriasSeleccionadas)) {
            $productos = $productos->filter(function ($item) use ($categoriasSeleccionadas) {
                return in_array($item['categoria'], $categoriasSeleccionadas);
            });
        }

        $productos = $productos->map(function ($item) {
            $item['imagen'] = is_array($item['imagen']) ? ($item['imagen'][0] ?? '') : $item['imagen'];
            $item['descripcion_text'] = is_array($item['descripcion']) ? implode(', ', $item['descripcion']) : $item['descripcion'];
            return $item;
        });

        if ($orden) {
            $productos = $productos->sort(function ($a, $b) use ($orden) {
                switch ($orden) {
                    case 'precio_asc':
                        return $a['precio'] <=> $b['precio'];
                    case 'precio_desc':
                        return $b['precio'] <=> $a['precio'];
                    case 'nombre_asc':
                        return strcmp($a['nombre'], $b['nombre']);
                    case 'nombre_desc':
                        return strcmp($b['nombre'], $a['nombre']);
                    default:
                        return 0;
                }
            });
        }


        return view('home', [
            'destacados' => $productos->values()->all(),
        ]);
    }

    public function secciones(Request $request, $categoria = null)
    {
        $buscar = $request->input('buscar');

        $productos = collect($this->datos['productos'])
            ->when($categoria, fn($q) => $q->where('categoria', $categoria))
            ->when($buscar, fn($q) => $q->filter(
                fn($item) => str_contains(strtolower($item['nombre']), strtolower($buscar))
            ))
            ->map(function($p) {
                $p['imagenes'] = $p['imagen'];
                $p['imagen']   = is_array($p['imagenes']) ? $p['imagenes'][0] : $p['imagenes'];

                $p['descripcion_text'] = is_array($p['descripcion'])
                    ? implode(' ', $p['descripcion'])
                    : $p['descripcion'];

                return $p;
            })
            ->all();
        return view('secciones', compact('productos', 'categoria'));
    }

    public function detalle($id)
    {
        $productos = collect($this->datos['productos'])->values();

        if (! isset($productos[$id])) {
            abort(404);
        }

        $p = $productos[$id];
        $p['imagenes'] = $p['imagen'] ?? [];
        $p['imagenes'] = is_array($p['imagenes']) ? $p['imagenes'] : [$p['imagenes']];

        $p['descripcion_text'] = is_array($p['descripcion'])
            ? implode('||', $p['descripcion'])
            : $p['descripcion'];

        return view('producto.detalle', ['producto' => $p, 'id' => $id]);
    }

    public function agregarCarrito(Request $request, $id)
    {
        $cantidad = max(1, (int) $request->input('cantidad', 1));

        $productos = collect($this->datos['productos'])->values();
        if (! isset($productos[$id])) {
            return redirect()->back();
        }
        $p = $productos[$id];

        $carrito = session('carrito', []);

        if (isset($carrito[$id])) {
            $nuevaCantidad = $carrito[$id]['cantidad'] + $cantidad;
            $carrito[$id]['cantidad'] = min(10, $nuevaCantidad);
        } else {
            $carrito[$id] = [
                'producto' => $p['nombre'],
                'precio'   => $p['precio'],
                'cantidad' => $cantidad,
            ];
        }

        session(['carrito' => $carrito]);

        return redirect()->route('producto.detalle', ['id' => $id])
                        ->with('success', 'Producto añadido al carrito con éxito.');
    }



    public function carrito()
    {
        $carrito = session('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function contactanos()
    {
        return view('contactanos');
    }

    public function eliminarDelCarrito($id)
    {
        $carrito = session('carrito', []);
        if (isset($carrito[$id])) {
            unset($carrito[$id]);
            session(['carrito' => $carrito]);
        }
        return redirect()->route('carrito');
    }
}
