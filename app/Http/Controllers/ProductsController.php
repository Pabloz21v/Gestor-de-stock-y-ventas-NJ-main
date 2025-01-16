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

        if ($request->filled('category_id')) {
            $query->where('id', $request->category_id);
        }

        if ($request->filled('subcategory_id')) {
            $query->whereHas('subcategories', function ($q) use ($request) {
                $q->where('id', $request->subcategory_id);
            });
        }

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
            'filters' => $request->only(['categories_id', 'subcategory_id', 'search'])
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
        // Obtener el subcategory_id de la solicitud
        $subcategoryId = $request->input('subcategory_id');
        // Encontrar la subcategoría correspondiente
        $subcategory = Subcategory::find($subcategoryId);
        // Obtener el category_id de la subcategoría
        $category_id = $subcategory->categories_id;

        // dd($request);
        $producto = Products::create($request->validated());
        $producto->category_id = $category_id;
        // dd("store", $producto->category_id);
        if ($request->hasFile('imagen_principal')) {
            $producto->imagen_principal = Storage::putFile('photos', $request->file('imagen_principal'));
        }

        if ($request->hasFile('video')) {
            $producto->video = Storage::putFile('videos', $request->file('video'));
        }

        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $photo) {
                $imagenes[] = Storage::putFile('photos', $photo);
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
    public function edit(Request $request,  $productoID)
    {
        $producto = Products::find($productoID);
        $subcategories = Subcategory::with('categories')->get();
        $categories = Categories::with('subcategories')->get();
        return inertia('Products/Edit', ['producto' => $producto, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request,  $productoID)
    {
        // dd("update");
        // dd($request);
        $products = Products::find($productoID);
        // dd($products);
        $oldData = $products->toArray();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;


        if ($request->hasFile('imagen_principal')) {
            if ($products->imagen_principal) {
                Storage::delete($products->imagen_principal);
            }
            $products->imagen_principal = Storage::putFile('photos', $request->file('imagen_principal'));
        }

        if ($request->hasFile('video')) {
            if ($products->video) {
                Storage::delete($products->video);
            }
            $products->video = Storage::putFile('videos', $request->file('video'));
        }

        if ($request->hasFile('imagenes')) {
            $imagenes = [];
            foreach ($request->file('imagenes') as $photo) {
                $imagenes[] = Storage::putFile('photos', $photo);
            }
            $products->imagenes = json_encode($imagenes);
        }


        $products->update($request->validated());
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

    // public function incrementarVentas($id)
    // {
    //     $producto = Products::findOrFail($id);
    //     $producto->increment('contador_ventas'); // Incrementar el contador de ventas
    //     $producto->save();

    //     return redirect()->back()->with('success', 'Venta registrada exitosamente.');
    // }

    private function checkHistoryLimit()
    {
        $historyCount = History::count();
        if ($historyCount > 50) {
            $oldestHistory = History::orderBy('created_at', 'asc')->first();
            $oldestHistory->delete();
        }
    }

    public function deleteImagenPrincipal(Products $producto)
    {
        $producto->deleteImagenPrincipal();
        return redirect()->route('products.edit', $producto->id);
    }

    public function deleteVideo(Products $producto)
    {
        $producto->deleteVideo();
        return redirect()->route('products.edit', $producto->id);
    }

    public function deleteImagenes(Products $producto, $index)
    {
        $producto->deleteImagenes($index);
        return redirect()->route('products.edit', $producto->id);
    }
}
