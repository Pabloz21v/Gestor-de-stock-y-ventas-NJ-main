<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Response;
use App\Http\Requests\RoleRequest;

class RoleController extends Controller
{
    const NUMBER_OF_ITEMS_PER_PAGE = 25;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(self::NUMBER_OF_ITEMS_PER_PAGE);
        return  inertia('Admin/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Admin/Create');
    }

    /**
     * Store a newly created resource in storage.
     * @param App\Http\Requests\RoleRequest
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        User::create($request->validated());
        return redirect()->route('role.index');
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
     * @param User $role
     */
    public function edit(User $role)
    {
        return inertia('Admin/Edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     * @param App\Http\Requests\RoleRequest
     * @param User $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, User $role)
    {
        $role->update($request->validated());
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param User $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $role)
    {
        $role->delete();
        return redirect()->route('role.index');
    }
}
