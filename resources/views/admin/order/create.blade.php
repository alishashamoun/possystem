<!-- resources/views/orders/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Order</h2>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="payment_method">Payment Method</label>
            <input type="text" name="payment_method" class="form-control" required>
        </div>

        <h4>Products</h4>
        @foreach ($products as $product)
            <div class="form-group">
                <label>{{ $product->name }}</label>
                <input type="number" name="products[{{ $loop->index }}][quantity]" min="1" placeholder="Quantity" required>
                <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>
</div>
@endsection
