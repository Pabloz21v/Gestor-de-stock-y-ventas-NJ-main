<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Inertia\Response;
use App\Models\History;
use App\Http\Requests\CategoriesRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    const NUMBER_OF_ITEMS_PER_PAGE = 25;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categories::orderBy('orden')->paginate(self::NUMBER_OF_ITEMS_PER_PAGE);
        return Inertia('Categories/index', ['categorias' => $categorias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        
        $category = Categories::create($request->validated());
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'categoria', 'crear', $category->toArray());
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($categoriesID)
    {
        $categories = Categories::find($categoriesID);
        return inertia('Categories/Edit', ['categories' => $categories]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, $categoriesID)
    {

        $category = Categories::find($categoriesID);
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $oldData = $category->toArray();
        $category->update($request->validated());

        $this->createHistory($fullname, $user->cargo, 'categoria', 'actualizar', ['old' => $oldData, 'new' => $category->toArray()]);
        
        return redirect()->route('categories.index');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($categoriesID)
    {
        $categories = Categories::find($categoriesID);
        $categoryDeleted = $categories;
        $categories->delete();
        $user = Auth::user();
        $fullname = $user->apellido . " " . $user->name;
        $this->createHistory($fullname, $user->cargo, 'categoria', 'eliminar', $categoryDeleted);
        return redirect()->route('categories.index');
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
