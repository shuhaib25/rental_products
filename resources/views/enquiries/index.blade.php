@extends('layouts.app')

@section('content')
    <h2>Enquiries</h2>

    <!-- Add Enquiry Button -->
    <div class="mb-3">
        <a href="{{ route('enquiries.create') }}" class="btn btn-success">Add Enquiry</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($enquiries->isEmpty())
        <p>No enquiries available.</p>
    @else
        <div class="row">
            @foreach ($enquiries as $enquiry)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $enquiry->title }}</h5>
                            <p>Rental Start: {{ $enquiry->rental_start_date }}</p>
                            <p>End Date: {{ $enquiry->end_date }}</p>

                            <!-- Display Selected Products -->
                            <h6>Selected Products:</h6>
                            @if($enquiry->products->isEmpty())
                                <p>No products associated with this enquiry.</p>
                            @else
                                <div class="row">
                                    @foreach ($enquiry->products as $product)
                                        <div class="col-md-4">
                                            <div class="card mb-2">
                                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                                <div class="card-body">
                                                    <h6 class="card-title">{{ $product->name }}</h6>
                                                    <p>SKU: {{ $product->sku }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between mt-3">
                                <a href="{{ route('enquiries.edit', $enquiry) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('enquiries.destroy', $enquiry) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this enquiry?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
