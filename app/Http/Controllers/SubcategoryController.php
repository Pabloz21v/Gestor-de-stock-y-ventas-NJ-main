<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use App\Models\Categories;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\History;
use App\Http\Requests\SubcategoryRequest;
class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories_id = $request->input('categories_id');

        $categories = Categories::with(['subcategories' => function ($query) {
            $query->orderBy('orden');
        }])->orderBy('orden')->get();

        $subcategoriesQuery  = Subcategory::query()->with('categories')->orderBy('orden');
        if ($categories_id) {
            $subcategoriesQuery->where('categories_id', $categories_id);
        }
        $subcategories = $subcategoriesQuery->get();

        return  Inertia('Subcategories/Index', [
            'subcategories' => $subcategories,
            'categories' => $categories,
            'filters' => [
            'category_id' => $categories_id,
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all();
        return inertia('Subcategories/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubcategoryRequest $request)
    {
        

        $subcategory = Subcategory::create($request->validated());

        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'subcategoria', 'crear', $subcategory->toArray());

        return redirect()->route('subcategories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Categories::all();
        return inertia('Subcategories/Edit', ['subcategory' => $subcategory, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubcategoryRequest $request, Subcategory $subcategory)
    {
        // dd($request->categories_id,  $subcategory->categories_id);
        
        
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $oldData = $subcategory->toArray();
        $subcategory->update($request->validated());
        $this->createHistory($fullname, $user->cargo, 'subcategoria', 'actualizar', ['old' => $oldData, 'new' => $subcategory->toArray()]);
        
        return redirect()->route('subcategories.index', [
            'filters' => [
            'category_id' => 1,
            ],
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategoryDeleted = $subcategory;
        $subcategory->delete();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'subcategoria', 'eliminar', $subcategoryDeleted);
        return redirect()->route('subcategories.index');
        
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
