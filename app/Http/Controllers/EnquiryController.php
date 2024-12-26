<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Product;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index()
    {
        $enquiries = Enquiry::with('products')->get(); // Eager load products
        return view('enquiries.index', compact('enquiries'));
    }

    public function create()
    {
        $products = Product::all(); // Fetch all products for selection
        return view('enquiries.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'rental_start_date' => 'required|date',
            'end_date' => 'required|date|after:rental_start_date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        // Check product availability
        foreach ($validatedData['products'] as $productId) {
            $product = Product::find($productId);
            if (!$this->isProductAvailable($product, $validatedData['rental_start_date'], $validatedData['end_date'])) {
                return redirect()->back()->withErrors(['products' => "Product {$product->name} is not available during the selected dates."])->withInput();
            }
        }

        $enquiry = Enquiry::create($validatedData);
        $enquiry->products()->attach($validatedData['products']); // Attach selected products

        return redirect()->route('enquiries.index')->with('success', 'Enquiry added successfully!');
    }

    public function edit(Enquiry $enquiry)
    {
        $products = Product::all(); // Fetch all products for selection
        return view('enquiries.edit', compact('enquiry', 'products'));
    }

    public function update(Request $request, Enquiry $enquiry)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'rental_start_date' => 'required|date',
            'end_date' => 'required|date|after:rental_start_date',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        // Check product availability
        foreach ($validatedData['products'] as $productId) {
            $product = Product::find($productId);
            if (!$this->isProductAvailable($product, $validatedData['rental_start_date'], $validatedData['end_date'])) {
                return redirect()->back()->withErrors(['products' => "Product {$product->name} is not available during the selected dates."])->withInput();
            }
        }

        $enquiry->update($validatedData);
        $enquiry->products()->sync($validatedData['products']); // Sync selected products

        return redirect()->route('enquiries.index')->with('success', 'Enquiry updated successfully!');
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();
        return redirect()->route('enquiries.index')->with('success', 'Enquiry deleted successfully!');
    }

    private function isProductAvailable($product, $startDate, $endDate)
    {
        // Check if the product is locked during the specified dates
        return !$product->enquiries()->where(function ($query) use ($startDate, $endDate) {
            $query->whereBetween('rental_start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($query) use ($startDate, $endDate) {
                      $query->where('rental_start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                  });
        })->exists();
    }
}
