<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    // only admin privilage!
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

    public function update(Request $request, $id)
    {
        try {

            $oldCar = Car::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required',
                'type' => 'required|min:3',
                'manufacture' => 'required',
                'price' => 'required|numeric',
                'plat' => 'required',
                'description' => 'required|max:255',
            ]);
            
            // update car
            Car::where('id', $oldCar->id)->update($validatedData);
            
            return $this->res([
                'message' => 'success update car info with id: ' . $oldCar->id
            ]);
            
        } catch(Exception $e) {
            return $this->resException($e, 400);
        }
        
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
