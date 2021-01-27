<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Todolist;

class PageController extends Controller
{
    public function index() {
        return Inertia::render('Content/index', [
            'todolists' => Todolist::all()
        ]);
    }
}
