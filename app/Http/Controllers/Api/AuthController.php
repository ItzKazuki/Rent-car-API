<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    
    public function login(Request $request)
    {
        try {
            $inputUser = $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);
    
            if(! $token = auth()->attempt($inputUser)) {
                return $this->res(['error' => 'not allowed'], 403);
            }
            
            return $this->res([
                'token' => $token
            ]);
        } catch (Exception $e) {
            return $this->res([
                'error' => 'something wrong',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function register(Request $request)
    {
        try {
            // do validation and add to database.
            $request->validate([
                'name' => 'required',
                'nik' => 'required|max:16',
                'username' => 'required|unique:users,username',
                'telephone' => 'required|max:13',
                'birthday' => 'required|date_format:Y-m-d',
                'email' => 'required|email:unique',
                'password' => 'required',
            ]);
            
            // add record to database
            $user = User::create([
                'name' => $request->input('name'),
                'nik' => $request->input('nik'),
                'username' => $request->input('username'),
                'telephone' => $request->input('telephone'),
                'birthday' => $request->input('birthday'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
    
            
            // response success when new account created.
            return $this->res([
                'message' => 'Success Create new account!',
                'user' => $user
            ]);
            
        } catch(Exception $e) {
            // response failed when validation break or something
            return $this->res([
                'error' => 'something wrong',
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function logout()
    {
        auth()->logout();
        // remove the token

        return $this->res([
            'message' => 'success loged out'
        ]);
    }
}
