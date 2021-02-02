<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Car;
use App\Models\Customer;

class RentalController extends Controller
{
    public function getAllRentals(Request $request)
    {
        $pageNo = $request -> size * ($request -> pageNo -1);
        $size = $request -> size;
        $sort = $request -> sort;
        $order = $request -> order;

        if($order == 1){
            $rentals = Rental::get()->skip($pageNo)->take($size)->sortBy($sort)->values()->all();

        } else {
            $rentals = Rental::get()->skip($pageNo)->take($size)->sortByDesc($sort)->values()->all();

        }

        foreach ($rentals as $item) {
            $item->car_id = Car::find($item->car_id, ['maker', 'model']);
            $item->customer_id = Customer::find($item->customer_id, ['name', 'surname']);
        }
        return response($rentals, 200);
    }

    public function createRental(Request $request)
    {
        $rental = new Rental;
        $rental->car_id = $request->car_id;
        $rental->customer_id = $request->customer_id;
        $rental->startDate = $request->startDate;
        $rental->endDate = $request->endDate;
        $rental->price = $request->price;
        $rental->save();

        return response()->json(["message" => "rental record created"], 201);
    }

    public function getRental($id)
    {
        if (Rental::where('id', $id)->exists()) {

            $rental =  Rental::where('id', $id)->first();
            $rental->car_id = Car::find($rental->car_id);
            $rental->customer_id = Customer::find($rental->customer_id);

            return response($rental, 200);
        } else {
            return response()->json(["message" => "Rental not found"], 404);
        }
    }


    public function updateRental(Request $request, $id)
    {
        if (Rental::where('id', $id)->exists()) {
            $rental = Rental::find($id);
            $rental->car_id = is_null($request->car_id) ? $rental->car_id : $request->car_id;
            $rental->customer_id = is_null($request->customer_id) ? $rental->customer_id : $request->customer_id;
            $rental->price = is_null($request->price) ? $rental->price : $request->price;
            $rental->startDate = is_null($request->startDate) ? $rental->startDate : $request->price;
            $rental->endDate = is_null($request->endDate) ? $rental->endDate : $request->endDate;
            $rental->save();

            return response()->json(['message' => 'records updated'], 200);
        } else {
            return response()->json(['message' => 'Rental not found'], 404);
        }
    }

    public function deleteRental($id)
    {
        if (Rental::where('id', $id)->exists()) {
            $rental = Rental::find($id);
            $rental->delete();

            return response()->json([
                "message" => "records deleted"
            ], 202);
        } else {
            return response()->json([
                'message' => 'Rental not found'
            ], 404);
        }
    }
}
