<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Rental;

class CarController extends Controller
{

    public function getAllCars(Request $request)
    {
        #optional search
        if($request -> searchKey and $request-> searchValue){

            $query = $request-> searchValue;
            $key = $request-> searchKey;

            $cars = Car::get()->where($key, 'LIKE', '%'.$query.'%')->values()->all();
        
        } else {

            #sort parameters
            $pageNo = $request -> size * ($request -> pageNo -1);
            $size = $request -> size;
            $sort = $request -> sort;
            $order = $request -> order;
            
            #get | sort | page
            if($order == 1 or $order == null){
                
                $cars = Car::get()->sortBy($sort)->skip($pageNo)->take($size);
            
            } else {

                $cars = Car::get()->sortByDesc($sort)->skip($pageNo)->take($size);

            }
        #display collection
        $cars = $cars->values()->all();
        }

        return response($cars, 200);
    }

    public function createCar(Request $request)
    {
        $car = new Car;
        $car->maker = $request->maker;
        $car->model = $request->model;
        $car->creationDate = $request->creationDate;
        $car->price = $request->price;
        $car->save();

        return response()->json(["message" => "car record created"], 201);
    }

    public function getCar($id)
    {
        if (Car::where('id', $id)->exists()) {
            $car = Car::where('id', $id)->get();
            return response($car, 200);
        } else {
            return response()->json(["message" => "Car not found"], 404);
        }
    }

    public function updateCar(Request $request, $id)
    {
        if (Car::where('id', $id)->exists()) {
            $car = Car::find($id);
            $car->maker = is_null($request->maker) ? $car->maker : $request->maker;
            $car->model = is_null($request->model) ? $car->model : $request->model;
            $car->creationDate = is_null($request->creationDate) ? $car->creationDate : $request->creationDate;
            $car->price = is_null($request->price) ? $car->price : $request->price;
            $car->save();

            return response()->json(["message" => "records updated successfully"], 200);
        } else {
            return response()->json([
                "message" => "Car not found"
            ], 404);
        }
    }

    public function deleteCar($id)
    {
        if (Car::where('id', $id)->exists()) {
            $car = Car::find($id);
            $car->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                "message" => "Car not found"
            ], 404);
        }
    }
}
