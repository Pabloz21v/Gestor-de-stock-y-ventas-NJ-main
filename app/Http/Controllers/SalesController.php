<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SaleRequest;
use Inertia\Inertia;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $salesQuery = Sale::with(['product', 'user']);

        if ($user->hasRole('editor')) {
            $salesQuery->where('vendedor', $user->id);
        }

        if ($request->estado) {
            $salesQuery->where('estado', $request->estado);
        }

        if ($request->timeRange) {
            switch ($request->timeRange) {
                case 'morning':
                    $salesQuery->whereTime('created_at', '>=', '00:00:00')->whereTime('created_at', '<', '12:00:00');
                    break;
                case 'afternoon':
                    $salesQuery->whereTime('created_at', '>=', '12:00:00')->whereTime('created_at', '<', '18:00:00');
                    break;
                case 'evening':
                    $salesQuery->whereTime('created_at', '>=', '18:00:00')->whereTime('created_at', '<', '23:59:59');
                    break;
            }
        }

        if ($request->vendedor) {
            $salesQuery->where('vendedor', $request->vendedor);
        }

        if ($request->sortByReg) {
            $salesQuery->orderBy('reg', 'asc');
        }

        $sales = $salesQuery->get();

        return Inertia::render('Sales/Index', [
            'sales' => $sales,
            'filters' => $request->only(['estado', 'timeRange', 'vendedor', 'sortByReg']),
            'users' => User::all()
        ]);
    }

    public function create()
    {
        $products = Products::all();
        $users = User::all();
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        $currentUser = auth()->user();
        return Inertia::render('Sales/Create', [
            'products' => $products,
            'users' => $users,
            'userPermissions' => $userPermissions,
            'currentUser' => $currentUser,
        ]);
    }

    public function store(SaleRequest $request)
    {
        Sale::create($request->validated());
        return redirect()->route('sales.index')->with('success', 'Venta creada exitosamente.');
    }

    public function edit(Sale $sale)
    {
        $products = Products::all();
        $users = User::all();
        $userPermissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();
        $currentUser = auth()->user();
        return Inertia::render('Sales/Edit', [
            'sale' => $sale,
            'products' => $products,
            'users' => $users,
            'userPermissions' => $userPermissions,
            'currentUser' => $currentUser,
        ]);
    }

    public function update(SaleRequest $request, Sale $sale)
    {
        $sale->update($request->validated());
        return redirect()->route('sales.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada exitosamente.');
    }

    public function updateEstado(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|string|in:ENTREGADO,PENDIENTE,CANCELADO,EN_PREPARACION,VERIFICANDO,CONSIGNA',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update(['estado' => $request->estado]);

        return redirect()->route('sales.index')->with('success', 'Estado de la venta actualizado exitosamente.');
    }
}
