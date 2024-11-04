@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Edit Form</h4>
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
                    <div class="col-lg-12">
                        <div class="card">

                            <div class="card-header">

                            </div><!-- end card header -->

                            <div class="card-body">
                                <form method="post" class="" action="{{ route('customers.update', $customer->id) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input class="form-control my-2" name="name"
                                                    value="{{ $customer->name }}" required autocomplete="given-name"
                                                    required>
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input class="form-control my-2" type="email" name="email"
                                                    value="{{ $customer->email }}" required autocomplete="email" required>
                                                @error('email')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <strong>Address:</strong>
                                                <textarea type="text" name="address" id="" cols="30" rows="4" class="form-control"
                                                    placeholder="Enter address">{{ $customer->address }}</textarea>
                                                @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <strong>phone:</strong>
                                                <input class="form-control my-2" type="phone" name="phone"
                                                    value="{{ $customer->phone }}" required autocomplete="phone" required>
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group mt-3">
                                                <strong>Image:</strong>
                                                <input type="file" class="form-control" name="image"
                                                    value="{{ $customer->image }}">
                                                @error('image')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="image">Customer Image</label>
                                            @if (!empty($customer->image) && file_exists(public_path('customerImage/' . $customer->image)))
                                                <img src="{{ asset('customerImage/' . $customer->image) }}"
                                                    alt="{{ $customer->name }}" style="width: 100px; height: auto;" />
                                            @else
                                                <span>No Image</span>
                                            @endif
                                           
                                        </div>

                                        <div class="col-xs-12 mt-5 text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                            <a href="{{ route('customers.index') }}" class="btn btn-danger">Back</a>
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
