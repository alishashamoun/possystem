@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Form</h4>
                    </div>

                  
                </div>

                @if (Session::has('error'))
                <p class="alert alert-info">{{ Session::get('error') }}</p>
            @endif

            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">Edit Form</h5>
                            </div><!-- end card header -->

                            <div class="card-body">
                                @if($inventory)
                                <form method="post" action="{{ route('inventory.update', $inventory->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="product_id">Product Name</label>
                                            <select name="product_id" id="product_id" class="form-control">
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <label for="quantity">Quantity:</label>
                                            <div class="input-group">
                                                <select name="quantity_action" id="quantity_action" class="form-control">
                                                    <option value="-">Stock Out</option>
                                                    <option value="+">Stock In</option>
                                                </select>
                                                <input type="number" name="quantity" id="quantity" class="form-control" value="0">
                                            </div>
                                            @error('quantity')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6 my-4">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{ route('inventory.index') }}" class="btn btn-danger">Back</a>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
