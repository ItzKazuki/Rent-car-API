<?php

namespace App\Http\Controllers\Api;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

            if(! $token = Auth::attempt($inputUser)) {
                return $this->res(['error' => 'not allowed'], 403);
            }

            return $this->res([
                'token' => $token
            ]);

        } catch (Exception $e) {
            return $this->resException($e, 400);
        }
    }

    public function register(Request $request)
    {
        try {
            // do validation and add to database.
            $validatedData = $request->validate([
                'name' => 'required',
                'nik' => 'required|max:16',
                'username' => 'required|min:3|unique:users,username',
                'telephone' => 'required|max:13',
                'birthday' => 'required|date_format:Y-m-d',
                'email' => 'required|email:unique',
                'password' => 'required',
            ]);

            $validatedData['password'] = Hash::make($request->input('password'));

            // add record to database
            $user = User::create($validatedData);

            // response success when new account created.
            return $this->res([
                'message' => 'Success Create new account!',
                'user' => $user
            ]);

        } catch(Exception $e) {
            // response failed when validation break or something
            return $this->resException($e, 400);
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
