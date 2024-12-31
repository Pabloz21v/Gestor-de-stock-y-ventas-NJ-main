<?php

namespace App\Http\Controllers;

use App\Models\Dishes;
use App\Models\Subcategory;
use App\Models\Categories;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Http\Requests\DisheRequest;
class DishesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        

        $query = Categories::with(['subcategories' => function ($query) {
            $query->orderBy('orden');
        }, 'subcategories.dishes' => function ($query) use ($request) {
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
        $filteredCategories =[];
        $filteredSubcategories = [];
        $filteredDishes = [];
        foreach ($categories as $category) {
            $filteredCategories[] = $category;
            foreach ($category->subcategories as $subcategory) {
                $filteredSubcategories[] = $subcategory;
                foreach ($subcategory->dishes as $dish) {
                    $filteredDishes[] = [
                        'id' => $dish->id,
                        'data' => $dish,
                        'subcategory' => $subcategory->name,
                        'category' => $category->name,
                        'category_id' => $category->id,
                    ];
                }
            }
        }

        return Inertia('Dishes/Index', [
            'categories' => $filteredCategories,
            'subcategories' => $filteredSubcategories,
            'dishes' => $filteredDishes,
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
        return inertia('Dishes/Create', ['subcategories' => $subcategories, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DisheRequest $request)
    {
        

        $dishe = Dishes::create($request->validated());
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'plato', 'crear', $dishe->toArray());
        return redirect()->route('dishes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dishes $dishes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,  $disheID)
    {

        $dishe = Dishes::find($disheID);
        $subcategories = Subcategory::with('categories')->get();
        $categories = Categories::with('subcategories')->get();
        return inertia('Dishes/Edit', ['dishe' => $dishe, 'categories' => $categories, 'subcategories' => $subcategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DisheRequest $request,  $disheID)
    {
        
        $dishes = Dishes::find($disheID);
        $oldData = $dishes->toArray();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $dishes->update($request->validated());
        $this->createHistory($fullname, $user->cargo, 'plato', 'actualizar', ['old' => $oldData, 'new' => $dishes->toArray()]);
        return redirect()->route('dishes.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($dishesID)
    {
        $dishes = Dishes::find($dishesID);
        $dishesDeleted = $dishes;
        $dishes->delete();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'plato', 'eliminar', $dishesDeleted);
        return redirect()->route('dishes.index');
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
}
