<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Car;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth:api');
    }

    public function create(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'user_id' => 'required|numeric',
                'car_id' => 'required|numeric',
                'date_borrow' => 'required|date_format:Y-m-d H:i:s',
                'date_return' => 'required|date_format:Y-m-d',
                'down_payment' => 'required|numeric',
                'discount' => 'required|numeric',
            ]);

            $user = User::findOrFail($request->input('user_id'));
            $car = Car::findOrFail($request->input('car_id'));
            $validatedData['user_id'] = $user->id;
            $validatedData['car_id'] = $car->id;
            $validatedData['rent_name'] = $user->name;
            $validatedData['total_price'] = $car->price - $validatedData['discount'];
    
            $rent = Rent::create($validatedData);
    
            return $this->res([
                'message' => 'success create new rent',
                'rent' => $rent,
                'user' => $rent->user()->get(),
                'car' => $rent->car()->get(),
            ]);
            
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
    }

    public function show(Rent $rent)
    {
        return $this->res([
            'message' => $rent,
            'user' => $rent->user()->get(),
            'car' => $rent->car()->get()
        ]);
    }
}
