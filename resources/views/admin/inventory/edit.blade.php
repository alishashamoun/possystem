@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold mt-4">Inventory Edit</h4>
                    </div>


                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header">

                            </div><!-- end card header -->

                            <div class="card-body">

                                <form method="post" action="{{ route('inventory.update', $inventoryItem->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong for="product_id" class="form-label">Product Name</strong>
                                                <select id="product_id" name="product_id" class="form-select my-2">
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}"
                                                            @if ($product->id == $selectedProductId) selected @endif>
                                                            {{ $product->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong for="sku" class="form-label">SKU</strong>
                                                <input type="text" class="form-control my-2" id="sku"
                                                    name="sku" value="{{ $inventoryItem->sku }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong for="quantity" class="form-label">Quantity</strong>
                                                <input type="number" class="form-control my-2" id="quantity"
                                                    name="quantity" value="{{ $inventoryItem->quantity }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong for="cost_price" class="form-label">Cost Price</strong>
                                                <input type="number" class="form-control my-2" id="cost_price"
                                                    name="cost_price" value="{{ $inventoryItem->cost_price }}" required>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong for="selling_price" class="form-label">Selling Price</strong>
                                                <input type="number" class="form-control my-2" id="selling_price"
                                                    value="{{ $inventoryItem->selling_price }}" name="selling_price"
                                                    required>
                                            </div>
                                        </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6 mt-5 text-end">
                                        <button type="submit" class="btn btn-primary">Edit Inventory</button>
                                        <a href="{{ route('inventory.index') }}" class="btn btn-danger">Back</a>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
