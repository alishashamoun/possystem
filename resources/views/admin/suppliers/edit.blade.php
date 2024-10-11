@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-0">Edit Supplier</h5>
                    </div>

                    <div class="text-end">

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

                            </div><!-- end card header -->

                            <div class="card-body">
                                <form method="post" class="" action="{{ route('suppliers.update', $supplier->id ) }}">


                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input class="form-control my-2" value="{{$supplier->name}}"  type="text" id="name" name="name" class="form-control" placeholder="">
                                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input class="form-control my-2" value="{{$supplier->email}}" id="email" name="email" class="form-control" placeholder="">
                                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Phone:</strong>
                                                <input class="form-control my-2" value="{{$supplier->phone}}" type="number" name="phone"
                                                     required>
                                                @error('phone')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Address:</strong>
                                                <input class="form-control my-2" type="text" value="{{$supplier->address}}"
                                                    name="address"
                                                    required>
                                                @error('address')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-xs-6 col-sm-6 col-md-6 my-4">
                                            <button type="submit" class="btn btn-primary">Update Supplier</button>
                                            <a href="{{route('suppliers.index')}}" class="btn btn-danger">Back</a>
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

