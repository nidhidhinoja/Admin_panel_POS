<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Shopkeeper;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Redirect;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
    {
        if (Auth::user()->role == 1) {
            $customers = Customer::orderBy('created_at', 'desc')->get();
            $shopkeepers = Shopkeeper::all();
            return view('customer.index', compact('customers', 'shopkeepers'));
        }

        $shop_id = auth()->user()->shop_id;
        $customers = Customer::where('shop_id', $shop_id)->orderBy('created_at', 'desc')->get();

        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'name' => 'required',
        'phone' => 'required|min:10|max:10',
        'address' => 'sometimes',
        'city' => 'sometimes',
        // Add validation rules for other fields as needed
    ]);

    // Get the shop_id of the currently logged-in user
    $shopId = Auth::user()->shop_id;

    // Create a new customer instance
    $customer = new Customer();

    // Set the customer attributes based on the form data
    $customer->name = $request->input('name');
    $customer->phone_no = $request->input('phone');
    $customer->address = $request->input('address');
    $customer->city = $request->input('city');
    // Set other attributes as needed

    // Set the shop_id
    $customer->shop_id = $shopId;

    // Save the customer data to the database
    $customer->save();

    // Check if the customer's shop_id matches the shop_id of the logged-in shopkeeper
    if ($customer->shop_id != $shopId) {
        // Delete the customer record and return an error response
        $customer->delete();
        return redirect()->back()->withErrors(['message' => 'Customer shop_id does not match the shop_id of the logged-in shopkeeper']);
    }

    // Redirect the user to the customer index page with a success message
    return redirect()->route('customer.index')->with('success', 'Customer stored successfully');
}


    /**
     * Store a newly created resource in storage.
     */
     public function apiStore(Request $request): JsonResponse
     {
         // Validate the form data
         $validatedData = $request->validate([
             'name' => 'required',
             'phone_no' => 'sometimes|min:10|max:10',
             'address' => 'sometimes',
             'city' => 'sometimes',
             // Add validation rules for other fields as needed
         ]);

         // Get the shop_id of the currently logged-in user
         $shopId = Auth::user()->shop_id;

         // Create a new customer instance
         $customer = new Customer();

         // Set the customer attributes based on the form data
         $customer->name = $request->input('name');
         $customer->phone_no = $request->input('phone_no');
         $customer->address = $request->input('address');
         $customer->city = $request->input('city');
         // Set other attributes as needed

         // Set the shop_id
         $customer->shop_id = $shopId;

         // Save the customer data to the database
         $customer->save();

         // Check if the customer's shop_id matches the shop_id of the logged-in shopkeeper
         if ($customer->shop_id != $shopId) {
             // Delete the customer record and return an error response
             $customer->delete();
             return response()->json([
                 'message' => 'Customer shop_id does not match the shop_id of the logged-in shopkeeper'
             ], 400);
         }

         // Return a JSON response
         return response()->json([
             'message' => 'Customer stored successfully',
             'data' => $customer
         ]);
     }





    /**
     * Display the specified resource.
     */
    public function show()
    {
        if (Auth::user()->role == 1) {
            $customers = Customer::orderBy('created_at', 'desc')->pluck('name');
            return response()->json(['customers' => $customers]);
        }

        $shop_id = auth()->user()->shop_id;
        $customers = Customer::where('shop_id', $shop_id)->pluck('name');
        return response()->json(['customers' => $customers]);
    }


    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'phone_no' => 'required|min:10|max:10',
            'address' => 'sometimes',
            'city' => 'sometimes',
            // Add validation rules for other fields as needed
        ]);

        $customer = Customer::findOrFail($customer->id);

        $customer->name = $request->input('name');
        $customer->phone_no = $request->input('phone_no');
        $customer->address = $request->input('address');
        $customer->city = $request->input('city');
        // Set other attributes as needed

        if (!$customer->save()) {
            return redirect()->back()->with('error', 'Failed to update customer.');
        }

        return redirect()->route('customer.index')->with('success', 'Customer updated successfully.');
    }




    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        // Get the current value of is_active
        $isDisabled = $product->is_active;

        // Disable the product
        $customer->is_active = true;
        $customer->save();

        if ($isDisabled == false) {
        }

        return redirect()->route('customer.index')->with('success', 'Customer disabled successfully.');
    }
}
