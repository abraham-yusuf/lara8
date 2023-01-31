<?php

namespace App\Http\Controllers;

// add Model Costumer
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        $create = Customer::create($data);
        if ($create) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if ($customer) {
            $customer->delete();
            return response()->json(true);
        } else {
            return response()->json(true);
        }
    }
    public function show($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }
    public function update($id, Request $request)
    {
        $customer = Customer::find($id);
        $data = $request->except('_token');
        $customer->fill($data);
        if ($customer->save()) {
            return response()->json(true);
        } else {
            return response()->json(false);
        }
    }
}
