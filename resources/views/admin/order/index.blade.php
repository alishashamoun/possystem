<!-- resources/views/orders/index.blade.php -->

@extends('layout.app')

@section('content')
<div class="container">
    <h2>Orders</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Payment Method</th>
                <th>Status</th>
                <th>Products</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->status }}</td>
                    <td>
                        @foreach ($order->products as $product)
                            <div>{{ $product->name }} ({{ $product->pivot->quantity }} @ currency($product->pivot->price))</div>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
