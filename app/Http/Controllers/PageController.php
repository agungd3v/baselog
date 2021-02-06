<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Todolist;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index() {
        return Inertia::render('Content/index', [
            'todolists' => Todolist::with(['group'])->where('group_id', Auth::user()->group_id)->get(),
            'usersofgroup' => Group::with(['user'])->where('id', Auth::user()->group_id)->first(),
            'user' => Auth::user()
        ]);
    }
}
