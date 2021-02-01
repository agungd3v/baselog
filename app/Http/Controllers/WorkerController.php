<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class WorkerController extends Controller
{
    public function index() {
        return response()->json([
            'status' => true,
            'message' => User::with(['group'])->where('iam_is', 'Worker')->get()
        ]);
    }
    public function create(Request $request) {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            return response()->json([
                'status' => false,
                'message' => 'Oops, email already taken'
            ]);
        }
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'iam_is' => $request['iam'],
            'group_id' => $request['group']
        ]);
        return response()->json([
            'status' => true,
            'message' => $user
        ]);
    }
}
