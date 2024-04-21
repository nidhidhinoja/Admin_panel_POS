<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Shopkeeper;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ShopkeeperController extends Controller
{
    public function index()
    {
        $shopkeepers = Shopkeeper::where('is_active', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shopkeepers.index', compact('shopkeepers'));
    }



    public function create()
    {
        return view('shopkeepers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'inputName' => 'required',
            'inputShopName' => 'required',
            'inputEmail' => 'required|email',
            'inputPhoneNumber' => 'required|min:10|max:10',
            'inputAddress' => 'required',
            'inputPassword' => [
                'required',
                'min:8',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&]).+$/', $value)) {
                        $fail('The '.$attribute.' must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.');
                    }
                },
            ],
            'confirm_password' => 'same:inputPassword',
            'inputGST' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Upload the image
        if ($request->hasFile('image')) {
            $shopImage = $request->file('image');
            $shopImageName = time().'.'.$shopImage->getClientOriginalExtension();
            $shopImage->move(public_path('images/shopkeeper_images'), $shopImageName);
        } else {
            $shopImageName = null; // or any default value you prefer when there is no image
        }

        // Create a new shopkeeper
        $shopkeeper = new Shopkeeper();
        $shopkeeper->name = $request->input('inputName');
        $shopkeeper->shop_name = $request->input('inputShopName');
        $shopkeeper->email = $request->input('inputEmail');
        $shopkeeper->phone_number = $request->input('inputPhoneNumber');
        $shopkeeper->address = $request->input('inputAddress');
        $shopkeeper->password = Hash::make($request->input('inputPassword'));
        $shopkeeper->gst = $request->input('inputGST');
        $shopkeeper->image = $shopImageName;
        // dd($shopkeeper->password);
        $shopkeeper->save();

        $user = User::create([
            'name' => $request->input('inputName'),
            'email' => $request->input('inputEmail'),
            'shop_id' => $shopkeeper->id,
            'password' => Hash::make($request->input('inputPassword')),
            'role' => '2',
        ]);
        return redirect()->route('shopkeepers.index')->with('success', 'Shopkeeper added successfully.');
    }

    public function show($id)
    {
        $shopkeeper = Shopkeeper::find($id);
        return view('shopkeepers.show', compact('shopkeeper'));
    }
    public function edit($id)
    {
        $shopkeeper = Shopkeeper::find($id);
        $shopkeepers = Shopkeeper::all();
        return view('shopkeepers.edit', compact('shopkeeper'),compact('shopkeepers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'inputName' => 'required',
            'inputShopName' => 'required',
            'inputEmail' => 'required|email',
            'inputPhoneNumber' => 'required',
            'inputAddress' => 'required',
            'inputGST' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $shopkeeper = Shopkeeper::find($id);
        $shopkeeper->name = $request->inputName;
        $shopkeeper->shop_name = $request->inputShopName;
        $shopkeeper->email = $request->inputEmail;
        $shopkeeper->phone_number = $request->inputPhoneNumber;
        $shopkeeper->address = $request->inputAddress;
        $shopkeeper->gst = $request->inputGST;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Get the original image name
            $imagePath = $image->store('shopkeeper_images', 'public');
            $shopkeeper->image = $imageName; // Store only the image name in the database
        }

        $shopkeeper->save();

        return redirect()->route('shopkeepers.index')
            ->with('success', 'Shopkeeper updated successfully.');
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'shop_name' => 'required',
            'email' => 'required|email|unique:shopkeepers',
            'phone_number' => 'required',
            'address' => 'required',
            'password' => 'required',
            'gst' => 'required',
            'image' => 'sometimes',
            'is_active' => 'boolean',
        ]);

        // Create a new shopkeeper instance
        $shopkeeper = new Shopkeeper();

        // Set the shopkeeper attributes based on the form data
        $shopkeeper->name = $validatedData['name'];
        $shopkeeper->shop_name = $validatedData['shop_name'];
        $shopkeeper->email = $validatedData['email'];
        $shopkeeper->phone_number = $validatedData['phone_number'];
        $shopkeeper->address = $validatedData['address'];
        $shopkeeper->password = $validatedData['password'];
        $shopkeeper->gst = $validatedData['gst'];
        $shopkeeper->image = $validatedData['image'];
        $shopkeeper->is_active = $request->input('is_active', false); // Set default value if not provided

        // Save the shopkeeper data to the database
        $shopkeeper->save();

        // Return a JSON response
        return response()->json([
            'message' => 'Shopkeeper stored successfully',
            'data' => $shopkeeper
        ]);
    }
    public function destroy($id)
    {
    // Find the shopkeeper by ID
        $shopkeeper = Shopkeeper::findOrFail($id);

        // Get the current value of is_disabled
        $isDisabled = $shopkeeper->is_active;

        // Disable the shopkeeper
        $shopkeeper->is_active = true;
        $shopkeeper->save();

        if ($isDisabled == false) {
            // Get the category IDs associated with the shopkeeper
            $categoryIds = $shopkeeper->categories()->pluck('id');

            // Disable the categories associated with the shopkeeper
            Category::whereIn('id', $categoryIds)->update(['is_active' => true]);

            // Get the product IDs associated with the categories
            $productIds = Product::whereIn('category_id', $categoryIds)->pluck('id');

            // Disable the products associated with the categories
            Product::whereIn('id', $productIds)->update(['is_active' => true]);
        }

        return redirect()->route('shopkeepers.index')->with('success', 'Shopkeeper, categories, and products disabled successfully.');
    }

}
