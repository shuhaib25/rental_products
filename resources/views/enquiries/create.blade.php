@extends('layouts.app')

@section('content')
    <h2>Create Enquiry</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('enquiries.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="rental_start_date">Rental Start Date</label>
            <input type="date" name="rental_start_date" id="rental_start_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="products">Select Products</label>
            <select name="products[]" id="products" class="form-control" multiple required>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Enquiry</button>
    </form>
@endsection
