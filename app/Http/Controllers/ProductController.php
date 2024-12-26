<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products',
            'available_stock' => 'required|integer',
            'image' => 'image|nullable|max:2048', // Ensure a maximum size for the image
        ]);

        if ($request->hasFile('image')) {
            // Store the image in the public storage
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validatedData);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'available_stock' => 'required|integer',
            'image' => 'image|nullable|max:2048', // Ensure a maximum size for the image
        ]);

        if ($request->hasFile('image')) {
            // Store the new image in public storage
            $validatedData['image'] = $request->file('image')->store('products', 'public');
        } else {
            // If no new image is uploaded, keep the existing image
            $validatedData['image'] = $product->image;
        }

        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Optionally delete the image file from storage
        if ($product->image) {
            \Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
