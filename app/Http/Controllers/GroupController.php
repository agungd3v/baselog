<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    public function index() {
        $group = Group::where('created_by', Auth::user()->id)->get();
        return response()->json([
            'status' => true,
            'message' => $group
        ]);
    }
    public function create(Request $request) {
        $group = Group::where('name', $request['title'])->where('created_by', $request['userId'])->first();
        if ($group) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, group already created'
            ]);
        }
        $group = new Group();
        $group->name = $request['title'];
        $group->created_by = $request['userId'];
        $group->save();
        return response()->json([
            'status' => true,
            'message' => $group
        ]);
    }
    public function update(Request $request) {
        $group = Group::where('id', $request['id'])->first();
        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, failed identify group'
            ]);
        }
        $group->name = $request['name'];
        $group->save();
        return response()->json([
            'status' => true,
            'message' => 'successfully changes',
            'item' => $group
        ]);
    }
    public function clear(Request $request) {
        $group = Group::where('id', $request['id'])->first();
        if (!$group) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, failed identify group'
            ]);
        }
        $group->delete();
        return response()->json([
            'status' => true,
            'message' => 'successfully deleted',
        ]);
    }
}
