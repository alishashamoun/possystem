@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Sale Form</h5>
                    </div>

                </div>

                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                @error('error_key')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header">

                            </div><!-- end card header -->

                            <div class="card-body">


                                <form method="POST" action="{{ route('sales.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="product_id">Product:</label>
                                                <select class="form-control" id="product_id" name="product_id" required>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}
                                                            ({{ $product->price }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('product_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="customer_id">Customer:</label>
                                                <select class="form-control" id="customer_id" name="customer_id" required>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('customer_id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="warehouse">Warehouse:</label>
                                                <select class="form-control" id="warehouse" name="warehouse" required>
                                                    @foreach ($warehouses as $warehouse)
                                                        <option value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('warehouse')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xs-6 col-sm-6 col-md-6">

                                            <div class="form-group mt-3">
                                                <label for="status">Status:</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="" disabled selected>Select Status</option>
                                                    <option value="Pending">Pending</option>
                                                    <option value="Completed">Completed</option>
                                                    <option value="Failed">Failed</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>



                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="grand_total">Grand Total:</label>
                                                <input type="number" class="form-control" id="grand_total"
                                                    name="grand_total" step="0.01" required>
                                                @error('grand_total')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="paid">Paid:</label>
                                                <input type="number" class="form-control" id="paid" name="paid"
                                                    step="0.01" required>
                                                @error('paid')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="payment_status">Payment Status:</label>
                                                <select class="form-control" id="payment_status" name="payment_status"
                                                    required>
                                                    <option value="" disabled selected>Select Payment Status</option>
                                                    <option value="Paid">Paid</option>
                                                    <option value="Unpaid">Unpaid</option>
                                                </select>
                                                @error('payment_status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group my-3">
                                                <label for="payment_type">Payment Type:</label>
                                                <select class="form-control" id="payment_type" name="payment_type" required>
                                                    <option value="" disabled selected>Select Payment Type</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Credit Card">Credit Card</option>
                                                    <option value="Debit Card">Debit Card</option>
                                                    <option value="Online">Online</option>
                                                </select>
                                                @error('payment_type')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>


                                        <div class="col-xs-6 col-sm-6 col-md-12 text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{ route('sales.show') }}" class="btn btn-warning">View Sales
                                                History</a>
                                            <a href="{{ route('sales.index') }}" class="btn btn-danger">Back</a>
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
    <!-- Include Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection
