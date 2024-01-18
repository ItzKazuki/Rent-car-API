<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    //TODO: This controller must be implement CRUD, Create already use in Auth COntrollr

    // READ
    public function showAccount()
    {
        return $this->res([
            'message' => 'success get user info!',
            'user' => auth()->user(),
        ]);
    }

    // UPDATE
    public function updateAccount(Request $request, $id)
    {
        try {
                // update something in here, the methode must use update/post
                $oldUser = User::findOrFail(isset($id) && auth()->user()->is_admin ? $id : auth()->user()->id); // kalo ada id, cari id nya, kalo ga ada cari id user nya

                $validatedData = $request->validate([
                    'name' => 'required|max:50',
                    'nik' => 'required|max:16',
                    'username' => 'required|min:3|unique:users,username',
                    'telephone' => 'required|min:11|max:13',
                    'birthday' => 'required|date_format:Y-m-d',
                    'email' => 'required|email:unique',
                    'password' => 'required'
                ]);
                
                
                $validatedData['password'] = Hash::make($request->input('password'));
                if(isset($id) && auth()->user()->is_admin) {
                    $validatedData['is_admin'] = intval($request->input('is_admin')) ?? 0;
                }
                
                // dd($validatedData);
                User::where('id', $oldUser->id)->update($validatedData);
        
                return $this->res([
                    'message' => 'success update your account'
                ]);
                // pertama ambil id nya browh
                // update ke database
                // kelar
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
    }

    // DELETE
    public function deleteAccount($id)
    { 
        try {
            // set user
            $user = User::findOrFail(auth()->user()->id);
            
            // check if want to delete someone, but must have admin privilage
            if(isset($id) && $user->is_admin) {
                // delete someone lewat $id
                $user->destroy($id);
                
                return $this->res([
                    'message' => 'success delete account with id:' . $id
                ]);
            }

            $user->destroy($user->id);

            return $this->res([
                'message' => 'success delete your account'
            ]);
            
        } catch (Exception $e) {
            return $this->resException($e, 400);
        }
    }
}
