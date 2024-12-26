@extends('layouts.app')

@section('content')
    <h2>Edit Product</h2>

    <!-- Form Container -->
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
                </div>

                <!-- SKU -->
                <div class="mb-3">
                    <label for="sku" class="form-label">SKU</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" required>
                </div>

                <!-- Available Stock -->
                <div class="mb-3">
                    <label for="available_stock" class="form-label">Available Stock</label>
                    <input type="number" name="available_stock" id="available_stock" class="form-control" value="{{ $product->available_stock }}" required>
                </div>

                <!-- Product Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
@endsection
