<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\PedidoRequest;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PedidosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $pedidos = Pedido::with('product')->get();
        // return Inertia::render('Pedidos/Index', ['pedidos' => $pedidos]);

        return Inertia::render('Pedidos/Index', [
            'pedidos' => Pedido::with('product')->get(),
            'products' => Products::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedidoRequest $request)
    {
        $request->validated();
        try {
            DB::transaction(function () use ($request) {
                Pedido::create($request->all());
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al crear el pedido: ' . $e->getMessage()]);
        }
        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedidoRequest $request, $id)
    {
        $pedido = Pedido::find($id);
        $request->validated();
        try {
            DB::transaction(function () use ($request, $pedido) {
                $pedido->update($request->all());
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al actualizar: ' . $e->getMessage()]);
        }
        return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pedido = Pedido::find($id);
        try {
            DB::transaction(function () use ($pedido) {
                $pedido->delete();
            });
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error al eliminar: ' . $e->getMessage()]);
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido eliminado exitosamente.');
    }

    public function transfer(Request $request, Pedido $pedido)
    {
        $request->validate([
            'action' => 'required|in:viaje_to_real,vendido_to_real,all_to_real', // Nueva acción
            'amount' => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request, $pedido) {
            $fieldFrom = null;
            $amount = $request->amount;

            if ($request->action === 'all_to_real') {
                // Transferir todo (viaje + vendido)
                $pedido->decrement('stock_en_viaje', $pedido->stock_en_viaje);
                $pedido->decrement('stock_en_viaje_vendido', $pedido->stock_en_viaje_vendido);
                $pedido->increment('stock_real', $amount);

                // Actualizar producto
                $product = $pedido->product;
                $product->decrement('stock_en_viaje', $pedido->stock_en_viaje);
                $product->decrement('stock_en_viaje_vendido', $pedido->stock_en_viaje_vendido);
                $product->increment('stock_real', $amount);
            } else {
                // Lógica original para transferencias individuales
                $fieldFrom = $request->action === 'viaje_to_real' 
                    ? 'stock_en_viaje' 
                    : 'stock_en_viaje_vendido';

                $pedido->decrement($fieldFrom, $amount);
                $pedido->increment('stock_real', $amount);

                $product = $pedido->product;
                $product->decrement($fieldFrom, $amount);
                $product->increment('stock_real', $amount);
            }
        });

        return back();
    }
}
