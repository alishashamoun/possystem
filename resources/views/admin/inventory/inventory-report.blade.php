@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="pt-4 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h1>Inventory Report</h1>
                    </div>
                </div>

                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Total Stock</th>
                                            <th>Sold Quantity</th>
                                            <th>Remaining Stock</th>
                                            <th>Price</th>
                                            <th>Alert Stock Level</th>
                                            <th>Category</th>
                                            <th>Product Image</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->sold_quantity ?? 0 }}</td>
                                                <td>{{ $product->quantity - ($product->sold_quantity ?? 0) }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->alert_stock }}</td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if($product->product_image)
                                                        <img src="{{ asset('Image/' . $product->product_image) }}" alt="Product Image" width="100">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
