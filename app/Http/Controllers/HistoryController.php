<?php

namespace App\Http\Controllers;
use Inertia\Response;
use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    public function index()
    {
        $histories = History::latest()->get();
        return Inertia('History/index', ['histories' => $histories]);
    }
}
