@extends('layout.app')

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Create Inventory</h4>
                    </div>


                </div>

                @if (Session('success'))
                    <div class="alert alert-success">
                        <p>{{ $message }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header">
                                <h5 class="card-title mb-0">Create Inventory</h5>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <form method="post" action="{{ route('inventory.store') }}">
                                    @csrf
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




                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    let quantityInput = document.getElementById('quantity');
    let quantityActionSelect = document.getElementById('quantity_action');

    quantityActionSelect.addEventListener('change', function() {
        let action = quantityActionSelect.value;
        let currentQuantity = parseInt(quantityInput.value);

        if (action === '+') {
            quantityInput.value = currentQuantity + 1;
        } else if (action === '-') {
            if (currentQuantity > 0) {
                quantityInput.value = currentQuantity - 1;
            }
        }
    });
</script>
@endsection
