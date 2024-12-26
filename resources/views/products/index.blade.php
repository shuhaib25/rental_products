@extends('layouts.app')

@section('content')
    <h2>Products</h2>

    <!-- Add Product Button -->
    <div class="mb-3">
        <a href="{{ route('products.create') }}" class="btn btn-success">Add Product</a>
    </div>

    @if ($products->isEmpty())
        <p>No products available.</p>
    @else
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">SKU: {{ $product->sku }}</p>
                            <p class="card-text">Available Stock: {{ $product->available_stock }}</p>
                            
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Edit</a>

                            <!-- Delete Button -->
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
