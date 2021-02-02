<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function getAllCustomers(Request $request) 
    {
        #sort parameters
        $pageNo = $request -> size * ($request -> pageNo -1);
        $size = $request -> size;
        $sort = $request -> toSort;
        $order = $request -> order;
        
        #get | sort | page
        if($order == 1){
            $customers = Customer::get()->skip($pageNo)->take($size)->sortBy($sort);

        } else {
            $customers = Customer::get()->skip($pageNo)->take($size)->sortByDesc($sort);

        }
        #optional search
        if($request-> searchKey){
            $query = $request -> searchValue;
            $key = $request -> searchKey;

            $customers = $customers->where($key, $query)->values()->all();
        }else {
            $customers = $customers->values()->all();
        }
      
        return response($customers, 200);
    
    }

    public function createCustomer(Request $request) {
        $customer = new Customer;
        $customer -> name = $request -> name;
        $customer -> surname = $request -> surname;
        $customer -> email = $request -> email;
        $customer -> birthDate = $request -> birthDate;
        $customer -> drivingLicense = $request -> drivingLicense;
        $customer ->save();

        return response()->json(['message' => 'customer record created'], 201);

    }

    public function getCustomer($id) {
        if(Customer::where('id', $id)->exists()) {
            $customer = Customer::where('id', $id)->get();
            return response($customer, 200);
        }else{
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }

    public function updateCustomer(Request $request, $id) {
        if(Customer::where('id', $id)->exists()) {
            $customer = Customer::find($id);
            $customer->name = is_null($request->name) ? $customer->name : $request->name;
            $customer->surname = is_null($request->surname ) ? $customer->surname : $request->surname;
            $customer->birthDate = is_null($request->birthDate ) ? $customer->birthDate : $request->birthDate;
            $customer->drivingLicense = is_null($request->drivingLicense ) ? $customer->drivingLicense : $request->drivingLicense;
            $customer->email = is_null($request->email ) ? $customer->email : $request->email ;
            $customer->save();

            return response()->json(['message' => 'records updated successfully'], 200);
        } else {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }

    public function deleteCustomer ($id) {
        if(Customer::where('id', $id)->exists()) {
            $customer = Customer::find($id);
            $customer->delete();

            return response()->json(['message' => 'records deleted'], 202);
        } else {
            return response()->json(['message' => 'Customer not found'], 404);
        }
    }
}
