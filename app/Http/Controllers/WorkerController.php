<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function index() {
        $worker = User::with(['group'])->where('iam_is', 'Worker')->get();
        return response()->json([
            'status' => true,
            'message' => $worker
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
            'username' => $request['username'],
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
