<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Shopkeeper;
use App\Models\Product;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    use HttpResponses;

    public function search(Request $request)
    {
        $shopkeeper = auth()->user();
        $shopId = $shopkeeper->shop_id;

        $name = $request->input('name');

        $categories = Category::where('shop_id', $shopId);

        if (!is_null($name)) {
            $categories->where('name', 'LIKE', "%{$name}%");
        }

        $result = $categories->get();

        return response()->json(['categories' => $result]);
    }

    public function index()
    {
        $categories = [];
        $categoriesWithProductCount = [];
        $shopkeepers = [];

        if (Auth::user()->role == 1) {
            $categories = Category::where('is_active', 0)
                ->orderBy('created_at', 'desc')
                ->get();
            $shopkeepers = Shopkeeper::where('is_active', 0)
                ->orderBy('created_at', 'desc')
                ->get();

            $categoriesWithProductCount = $categories->map(function ($category) {
                $productCount = Product::where('category_id', $category->id)->count();
                $category->productCount = $productCount;
                return $category;
            });
        } else {
            if (Auth::user()->role == 2) {
                $shop_id = auth()->user()->shop_id;
                $categories = Category::where('shop_id', $shop_id)
                    ->where('is_active', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();
                $shopkeepers = Shopkeeper::where('id', $shop_id)
                    ->where('is_active', 0)
                    ->orderBy('created_at', 'desc')
                    ->get();

                $categoriesWithProductCount = $categories->map(function ($category) {
                    $productCount = Product::where('category_id', $category->id)->count();
                    $category->productCount = $productCount;
                    return $category;
                });

            }
        }

        return view('categories.index', compact('categories', 'categoriesWithProductCount', 'shopkeepers'));
    }








    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }
    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::findOrFail($id);

        // Get the current value of is_active
        $isActive = $category->is_active;

        // Set is_active to 0 (false)
        $category->is_active = true;
        $category->save();

        if ($isActive == false) {
            // Get the product IDs associated with the category
            $productIds = Product::where('category_id', $id)->pluck('id');

            // Disable the products associated with the category
            Product::whereIn('id', $productIds)->update(['is_active' => true]);
        }

        return redirect()->route('categories.index')->with('success', 'Category Disabled successfully!');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $category = new Category;
        $category->name = $validatedData['name'];
        $category->description = $validatedData['description'];
        $category->unit = $request->input('unit');

        if (Auth::user()->role == 1) {
            // Store in the selected shopkeeper's ID
            $selectedShopkeeperId = $request->input('shopkeeper_id');
            $category->shop_id = $selectedShopkeeperId;
        } else {
            // Store in the shopkeeper's own ID
            $category->shop_id = auth()->user()->shop_id;
        }

        $similarCategory = Category::where('shop_id', $category->shop_id)
            ->where('name', $category->name)
            ->exists();

        if ($similarCategory) {
            return redirect()->route('categories.index')->with('error', 'You have already added a category with the same name.');
        }

        $catImage = $request->file('image');
        $catImageName = time() . '.' . $catImage->getClientOriginalExtension();
        $catImage->move(public_path('images/category_images'), $catImageName);
        $category->image = $catImageName;

        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully');
    }


    public function update(Request $request, Category $category)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'unit' => 'required',
            'image' => 'sometimes|image|max:2048',
        ]);
        $shop_id = auth()->user()->shop_id;
        $category = Category::findOrFail($category->id);

        if ($request->hasFile('image')) {
            // dd($request->image);
            $catImage = $request->file('image');
            $catImageName = time().'.'.$catImage->getClientOriginalExtension();
            $catImage->move(public_path('images/category_images'), $catImageName);
            $category->image = $catImageName;
        }


        $category->name = $request->input('name');
        $category->unit = $request->input('unit');
        $category->description = $request->input('description');
        $category->save();

        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function show(Request $request)
    {
        $shopkeeper = auth()->user();
        $shopId = $shopkeeper->shop_id;
        $id = $request->input('cat_id');

        if (!is_null($id)) {
            $categories = Category::where('id', $id)->where('shop_id', $shopId)->get();
            if ($categories->isNotEmpty()) {
                return response()->json( ['categories' => $categories]);
            } else {
                return response()->json( ['categories' => $categories]);
            }
        }

        $categories = Category::where('shop_id', $shopId)->get();;
        if ($categories->isNotEmpty()) {
            return response()->json( ['categories' => $categories]);
        }

        return response()->json( ['categories' => $categories]);
    }
}
