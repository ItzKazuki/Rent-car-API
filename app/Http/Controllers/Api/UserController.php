<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function updateAccount(Request $request)
    {
        // update something in here, the methode must use update/post
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
