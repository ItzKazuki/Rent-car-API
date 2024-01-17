<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function __construct()
    {
        return $this->middleware('is_admin', ['except' => ['show']]);
    }

    public function create(Request $request)
    {
        try {
            // make new car
            $input = $request->validate([
                'name' => 'required|unique:cars,name',
                'type' => 'required',
                'manufacture' => 'required',
                'price' => 'required',
                'plat' => 'required',
                'description' => 'required|max:255',
            ]);

            $car = Car::create($input);
            
            return $this->res([
                'message' => 'success insert new car to database',
                'car' => $car
            ]);
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
    }

    public function update(Request $request, Car $car)
    {
        // update car
    }

    public function show($id)
    {
        try {
            $car = Car::findOrFail($id);
        
            return $this->res([
                'message' => 'success get info the car',
                'car' => $car
            ]);
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
    }

    public function delete($id)
    {
        try {
            // delete that car
            $car = Car::findOrFail($id);
            $car->destroy($car->id);

            return $this->res([
                'message' => 'success delete car with id: ' . $id
            ]);
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
    }
}
