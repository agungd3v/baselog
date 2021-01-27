<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;

class TodoController extends Controller
{
    public function store(Request $request) {
        $todo = new Todolist();
        $todo->title = $request['title'];
        $todo->description = $request['description'];
        $todo->assign = 1;
        $todo->progress = $request['progress'];
        $todo->save();
        return response()->json([
            'status' => true,
            'message' => $todo
        ]);
    }
    public function changetodos(Request $request) {
        $todo = Todolist::where('id', $request['id'])->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, card not valid!'
            ]);
        }
        $todo->progress = $request['progress'];
        $todo->save();
        return response()->json([
            'status' => true,
            'message' => $todo
        ]);
    }
}
