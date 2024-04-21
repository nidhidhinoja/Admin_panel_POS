<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Shopkeeper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function show_product(Request $request)
    {
        $shopkeeper = auth()->user();
        $shopId = $shopkeeper->shop_id;
        $cat_id = $request->input('cat_id');
        $pro_id = $request->input('pro_id');

        if (is_null($cat_id) && is_null($pro_id)) {
            $products = Product::where('shop_id', $shopId)->get();
            return response()->json(['products' => $products]);
        } elseif (is_null($cat_id) && !is_null($pro_id)) {
            $products = Product::where('shop_id', $shopId)->where('id', $pro_id)->get();
            return response()->json(['product' => $products]);
        } elseif (!is_null($cat_id) && is_null($pro_id)) {
            $products = Product::where('shop_id', $shopId)->where('category_id', $cat_id)->get();
            return response()->json(['products' => $products]);
        } else {
            $products = Product::where('shop_id', $shopId)->where('category_id', $cat_id)->where('id', $pro_id)->get();
            return response()->json(['product' => $products]);
        }
    }

    public function search_product(Request $request)
    {
        $shopkeeper = auth()->user();
        $shopId = $shopkeeper->shop_id;

        $name = $request->input('name');

        if (is_null($name)) {
            $products = Product::where('shop_id', $shopId)->get();
            return response()->json(['products' => $products]);
        } else {
            $products = Product::where('shop_id', $shopId)->where('name', 'LIKE', "%{$name}%")->get();
            return response()->json(['products' => $products]);
        }
    }
    
    public function index()
    {
        if (Auth::user()->role == 1) {
            $products = Product::where('is_active', 0)
                ->orderBy('created_at', 'desc')
                ->get();
            $categories = Category::where('is_active', 0)->get();
            $shopkeepers = Shopkeeper::where('is_active', 0)->get();
            return view('product.index', compact('categories', 'products', 'shopkeepers'));
        }

        $shop_id = auth()->user()->shop_id;
        $products = Product::with('shopkeeper')
            ->where('shop_id', $shop_id)
            ->where('is_active', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        $categories = Category::where('shop_id', $shop_id)
            ->where('is_active', 0)
            ->get();
        return view('product.index', compact('categories', 'products'));
    }




    public function create()
    {
        $shop_id = auth()->user()->shop_id;
        $products = Product::where('shop_id', $shop_id)->get();
        $categories = Category::where('shop_id', $shop_id)->get();
        return view('product.index', compact('categories'),compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'category_id' => 'required',
        ]);

        $product = new Product();

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');

        // Get the selected category
        $category = Category::find($product->category_id);

        if (!$category) {
            return redirect()->route('product.index')->with('error', 'Invalid category selected.');
        }

        // Assign the shop_id based on the selected category's shopkeeper
        $shop_id = $category->shop_id;
        $product->shop_id = $shop_id;

        // Check if there are any similar products in the category
        $similarProduct = Product::where('category_id', $product->category_id)->where('name', $product->name)->exists();

        if ($similarProduct) {
            return redirect()->route('product.index')->with('error', 'Product already exists in this category.');
        }

        $proImage = $request->file('image');
        $proImageName = time().'.'.$proImage->getClientOriginalExtension();
        $proImage->move(public_path('images/product_images'), $proImageName);

        $product->image = $proImageName;

        $product->save();

        Session::flash('success', 'Product added successfully');
        return redirect()->route('product.index')->with('success', 'Product added successfully.');
    }



    public function show($id)
    {
        $product = Product::find($id);
        return view('product.index', compact('product'));
    }


    public function edit($id)
    {
        $shop_id = auth()->user()->shop_id;
        $product = Product::findOrFail($id);
        $categories = Category::where('shop_id', $shop_id)->get();
        return view('product.edit', compact('product'), compact('categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image' => ['sometimes', 'image', 'max:2048'], // Max file size of 2MB
            'description' => ['nullable', 'string'],
            // 'category_id' => ['required', 'exists:categories,id'], // Validate that the selected category exists in the categories table
            'price' => ['required', 'numeric'],
            // Add any other validation rules for your Product fields
        ]);

        $product = Product::find($id);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->category_id = $request->input('category_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName(); // Get the original image name
            $imagePath = $image->store('product_images', 'public');
            $product->image = $imageName; // Store only the image name in the database
        }
        $product->save();

        return redirect()->route('product.index')->with('success', 'Products Updated successfully.');

    }

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Get the current value of is_active
        $isDisabled = $product->is_active;

        // Disable the product
        $product->is_active = true;
        $product->save();

        if ($isDisabled == false) {
        }

        return redirect()->route('product.index')->with('success', 'Product Disabled successfully!');
    }



}
