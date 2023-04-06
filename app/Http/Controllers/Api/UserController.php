<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function updateProfile(Request $request) {
        try {
            $user = Auth::user();

            $user->update([
                'name' => $request['name'],
                'dob' => $request['dob'],
                'gender' => $request['gender'],
                'description' => $request['description'],
                'avatar' => $request['avatar'],
                'background' => $request['background']
            ]);

            return response()->json([
               'user' => $user,
               'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e,
                'success' => false
            ], 404);
        }

    }

    public function search(Request $request) {
        $searchField = $request->input('field');
        $searchTerm = $request->input('searchTerm');

        if ($searchTerm) {
            $users = User::where($searchField, 'like', '%'.$searchTerm.'%')->get();
        } else {
            $users = [];
        }

        return response([
            'users' => $users,
            'success'=> true
        ]);
    }
}
