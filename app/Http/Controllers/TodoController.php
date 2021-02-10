<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todolist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function store(Request $request) {
        $user = User::with(['group'])->where('id', Auth::user()->id)->first();
        $todo = new Todolist();
        $todo->group_id = $user->group->id;
        $todo->title = $request['title'];
        $todo->description = $request['description'];
        $todo->created_by = $user->id;
        $todo->assign_to = $request['assign'] === null ? null : $request['assign']['id'];
        $todo->due_date = $request['duedate'];
        $todo->progress = $request['progress'];
        $todo->save();
        
        return response()->json([
            'status' => true,
            'message' => $todo
        ]);
    }
    public function update(Request $request) {
        $todo = Todolist::where('id', $request['id'])->first();
        if (!$todo) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, card not valid!'
            ]);
        }
        $todo->title = $request['title'];
        $todo->description = $request['description'];
        $todo->assign_to = $request['assign_to'] === null ? null : $request['assign_to'];
        $todo->due_date = $request['due_date'] === null ? null : $request['due_date'];
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
