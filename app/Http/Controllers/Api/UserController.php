<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    public function showAccount()
    {
        return $this->res([
            'message' => 'success get user info!',
            'user' => auth()->user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        // update something in here, the methode must use update/post
    }

    public function deleteAccount(Request $request)
    {
        // check if want to delete someone, but must have admin privilage
    }
}
