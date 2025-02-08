<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Subcategory;
use App\Models\Categories;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categories::with(['subcategories' => function ($query) {
            $query->orderBy('orden');
        }, 'subcategories.products' => function ($query) use ($request) {
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            $query->orderBy('name');
        }])->orderBy('orden');

        $categories = $query->get();
        $filteredCategories = [];
        $filteredSubcategories = [];
        $filteredProducts = [];
        foreach ($categories as $category) {
            $filteredCategories[] = $category;
            foreach ($category->subcategories as $subcategory) {
                $filteredSubcategories[] = $subcategory;
                foreach ($subcategory->products as $product) {
                    $filteredProducts[] = [
                        'id' => $product->id,
                        'data' => $product,
                        'subcategory' => $subcategory->name,
                        'category' => $category->name,
                        'category_id' => $category->id,
                    ];
                }
            }
        }

        return Inertia('Products/Index', [
            'categories' => $filteredCategories,
            'subcategories' => $filteredSubcategories,
            'products' => $filteredProducts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subcategories = Subcategory::with('categories')->get();
        $categories = Categories::with('subcategories')->get();
        return inertia('Products/Create', ['subcategories' => $subcategories, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $subcategoryId = $request->input('subcategory_id');
        $subcategory = Subcategory::find($subcategoryId);
        $category_id = $subcategory->categories_id;

        $producto = Products::create($request->validated());
        $producto->category_id = $category_id;

        if ($request->hasFile('imagen_principal')) {
            $producto->imagen_principal = $request->file('imagen_principal')->store('photos', 'public');
        }

        if ($request->hasFile('video')) {
            $producto->video = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $photo) {
                $imagenes[] = $photo->store('photos', 'public');
            }
            $producto->imagenes = json_encode($imagenes);
        }

        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $producto->save();
        $this->createHistory($fullname, $user->cargo, 'producto', 'crear', $producto->toArray());

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $productoID)
    {
        $producto = Products::find($productoID);
        $subcategories = Subcategory::with('categories')->get();
        $categories = Categories::with('subcategories')->get();
        return inertia('Products/Edit', ['producto' => $producto, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $id)
    {
        $products = Products::find($id);
        $oldData = $products->toArray();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;

        // Obtener el category_id correspondiente al subcategory_id
        $subcategoryId = $products->subcategory_id;
        $subcategory = Subcategory::find($subcategoryId);
        $category_id = $subcategory->categories_id;

        // Actualizar el category_id en el modelo
        $request->merge(['category_id' => $category_id]);

        if ($request->hasFile('imagen_principal')) {
            if ($products->imagen_principal) {
                Storage::disk('public')->delete($products->imagen_principal);
            }
            $products->imagen_principal = $request->file('imagen_principal')->store('photos', 'public');
        }

        if ($request->hasFile('video')) {
            if ($products->video) {
                Storage::disk('public')->delete($products->video);
            }
            $products->video = $request->file('video')->store('videos', 'public');
        }

        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $photo) {
                $imagenes[] = $photo->store('photos', 'public');
            }
            $products->imagenes = json_encode($imagenes);
        }

        $products->fill($request->except(['imagen_principal', 'video', 'imagenes']));
        $products->save();

        $this->createHistory($fullname, $user->cargo, 'producto', 'actualizar', ['old' => $oldData, 'new' => $products->toArray()]);
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($productsID)
    {
        $products = Products::find($productsID);
        $productsDeleted = $products;
        if ($products->imagen_principal) {
            Storage::delete($products->imagen_principal);
        }
        if ($products->video) {
            Storage::delete($products->video);
        }
        if ($products->imagenes) {
            foreach (json_decode($products->imagenes) as $photo) {
                Storage::delete($photo);
            }
        }
        $products->delete();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'producto', 'eliminar', $productsDeleted);
        return redirect()->route('products.index');
    }

    private function createHistory($person, $cargo, $entityType, $action, $data)
    {
        History::create([
            'person' => $person,
            'cargo' => $cargo,
            'entity_type' => $entityType,
            'action' => $action,
            'data' => $data
        ]);

        $this->checkHistoryLimit();
    }

    private function checkHistoryLimit()
    {
        $historyCount = History::count();
        if ($historyCount > 50) {
            $oldestHistory = History::orderBy('created_at', 'asc')->first();
            $oldestHistory->delete();
        }
    }

    public function deleteImagenPrincipal($productoID)
    {
        $producto = Products::find($productoID);
        if ($producto->imagen_principal) {
            Storage::delete($producto->imagen_principal);
            $producto->imagen_principal = null;
            $producto->save();
        }
        return redirect()->route('products.edit', $producto->id);
    }

    public function deleteVideo($productoID)
    {
        $producto = Products::find($productoID);
        if ($producto->video) {
            Storage::delete($producto->video);
            $producto->video = null;
            $producto->save();
        }
        return redirect()->route('products.edit', $producto->id);
    }

    public function deleteImagenes($productoID, $index)
    {
        $producto = Products::find($productoID);
        $imagenes = $producto->imagenes;
        if (isset($imagenes[$index])) {
            Storage::delete($imagenes[$index]);
            unset($imagenes[$index]);
            $producto->imagenes = array_values($imagenes);
            $producto->save();
        }
        return redirect()->route('products.edit', $producto->id);
    }

    /**
     * Display a listing of the products on offer.
     */
    public function ofertas()
    {
        $products = Products::where('oferta', true)->get();
        return Inertia('Products/Ofertas', ['products' => $products]);
    }
}
