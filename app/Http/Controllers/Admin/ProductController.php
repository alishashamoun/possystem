<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Category;
use App\Models\Sale;
use App\Models\Tag;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Picqer\Barcode\BarcodeGenerator\EanBarcodeGenerator;
use Illuminate\Support\Facades\Storage;
use App\Services\BarcodeService;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DNS1D;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'tags', 'inventory', 'sales'])->get();
        return view('admin.products.index', compact('products'));

    }


    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.products.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
{
    $request->validate([
        'category_id' => 'exists:categories,id',
        'product_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $category_id = $request->input('category_id');
    $category_name = $request->input('category_name');

    $category = Category::firstOrCreate(['id' => $category_id], ['name' => $category_name]);

    // Handle product image upload
    $filename = null;

    if ($request->hasFile('product_image')) {
        $filename = time() . '.' . $request->file('product_image')->extension();
        $request->file('product_image')->move(public_path('Image'), $filename);
    }

    $product = new Product();
    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->quantity = $request->input('quantity');
    $product->category_id = $category->id;
    $product->inventory_level = $request->input('quantity');
    $product->product_image = $filename;
    $product->save();

    $product->tags()->attach($request->input('tag_ids'));

    return redirect()->route('products.index')->with('success', 'Product item created successfully.');
}


    public function edit($id)
    {
        $product = Product::with('category', 'tags')->find($id);
        $categories = Category::all();
        $tags = Tag::all();
        $selectedTagIds = $product->tags->pluck('id')->toArray();
        $selectedCatryId = $product->category_id;
        return view('admin.products.edit', compact('product', 'categories', 'tags', 'selectedTagIds', 'selectedCatryId'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'category_id' => 'exists:categories,id',
        'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $product = Product::find($id);

    if (!$product) {
        return redirect()->route('products.index')->with('error', 'Product not found.');
    }

    $category_id = $request->input('category_id');
    $category_name = $request->input('category_name');

    $category = Category::firstOrCreate(['id' => $category_id], ['name' => $category_name]);



    $filename = $product->product_image; // Keep existing filename

    if ($request->hasFile('product_image')) {
        // Generate new filename if a new image is uploaded
        $filename = time() . '.' . $request->file('product_image')->extension();
        $request->file('product_image')->move(public_path('Image'), $filename);
    }

    $product->name = $request->input('name');
    $product->description = $request->input('description');
    $product->price = $request->input('price');
    $product->quantity = $request->input('quantity');
    $product->category_id = $category->id;
    $product->inventory_level = $request->input('quantity');
    $product->product_image = $filename;
    $product->save();

    $product->tags()->sync($request->input('tag_ids'));

    return redirect()->route('products.index')->with('success', 'Product item updated successfully.');
}

    public function destroy($id)
{

    DB::table('product_tag')->where('product_id', $id)->delete();


    DB::table('category_product')->where('product_id', $id)->delete();


    $product = Product::find($id);

    $product->inventory()->delete();

    // Delete the product image
    File::delete(public_path('image/') .$product->product_image);
    // Delete the product
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Successfully Product Deleted');;
}

// ProductController.php

public function searchProducts(Request $request)
{
    $searchQuery = $request->input('search_query');

    $products = Product::where('product_name', 'LIKE', "%{$searchQuery}%")
        ->orWhere('description', 'LIKE', "%{$searchQuery}%")
        ->orWhere('category', 'LIKE', "%{$searchQuery}%")
        ->get();

    return view('products.search_results', compact('products'));
}

}
