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
        return $this->middleware('is_admin', ['only' => ['update', 'delete', 'showAll']]);
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

    public function showAll()
    {
        return $this->res([
            'message' => 'success get all record rent',
            'rents' => Rent::all()
        ]);
    }

    public function show()
    {
        try {
            // $rent = Rent::findOrFail($request->input('rent_id'));
            $user = User::findOrFail(auth()->user()->id);

            $rent = $user->rent()->first(); // this referenc to Rent::class
            // dd($rent->car()->get());

            return $this->res([
                'message' => $rent,
                'user' => $user,
                'car' => $rent->car()->get()
            ]);
        } catch (Exception $e) {
            return $this->resException($e, 400);
        }
    }

    public function update()
    {
        //do something
    }

    public function delete(Request $request)
    {
        try {
            $rent = Rent::findOrFail($request->input('rent_id'));

            if(!auth()->user()->is_admin) {
                throw new Exception("Not_allowed");
            }

            $rent->destroy($rent->id);

            return $this->res([
                'message' => 'success delete rent with id: ' . $rent->id
            ]);
        } catch (Exception $e) {
            return $this->resException($e, 400);
        }
    }
}
