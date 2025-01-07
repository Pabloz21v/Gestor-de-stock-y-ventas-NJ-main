<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Products;
use App\Models\Subcategory;
use App\Models\Categories;

class DashboardController extends Controller
{

    public function index(Request $request)
    {

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            // 'categories' => Categories::with('subcategories.products')->get(),

            // Ordena categories por orden, subcategories por orden y products por nombre
            'categories' => Categories::with(['subcategories' => function ($query) {
                $query->orderBy('orden');
            }, 'subcategories.products' => function ($query) {
                $query->orderBy('name');
            }])->orderBy('orden')->get(),

            // $sortOrder = $request->query('sortOrder', 'name'); // Default sort order is 'name'
            // 'categories' => Categories::with(['subcategories' => function ($query) use ($sortOrder) {
            //     $query->orderBy($sortOrder);
            // }, 'subcategories.products' => function ($query) use ($sortOrder) {
            //     $query->orderBy($sortOrder);
            // }])->orderBy($sortOrder)->get(),



            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            // 'products' => Products::with(['subcategories.categories'])->get(),
            // 'subcategory' => Subcategory::with('categories')->get(),
            // 'canRegister' => Route::has('register'),
        ]);
    }

    public function dashboard(Request $request)
    {
        // Ordena categories por orden, subcategories por orden y products por nombre
        $categories = Categories::with(['subcategories' => function ($query) {
            $query->orderBy('orden');
        }, 'subcategories.products' => function ($query) {
            $query->orderBy('name');
        }])->orderBy('orden')->get();


        // $sortOrder = $request->query('sortOrder', 'name'); // Default sort order is 'name'
        // $categories = Categories::with(['subcategories' => function ($query) use ($sortOrder) {
        //     $query->orderBy($sortOrder);
        // }, 'subcategories.products' => function ($query) use ($sortOrder) {
        //     $query->orderBy($sortOrder);
        // }])->orderBy($sortOrder)->get();

        return Inertia::render('Dashboard', ['categories' => $categories]);
        // return Inertia::render('Dashboard', ['categories' => $categories, 'sortOrder' => $sortOrder]);
    }
}

// metodos de la vista dashboard para querys
// const sortOrder = ref(props.sortOrder || 'name');

// const fetchSortedData = () => {
// 	Inertia.get('/dashboard', { sortOrder: sortOrder.value }, { preserveState: true });
// };

// watchEffect(() => {
// 	sortOrder.value = props.sortOrder;
// });