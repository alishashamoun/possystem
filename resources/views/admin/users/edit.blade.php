@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">User Edit</h4>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">

                        </ol>
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
                                <form method="post" class="" action="{{ route('users.update', $user->id ) }}">

                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Name:</strong>
                                                <input class="form-control my-2" value="{{$user->name}}" type="text" id="name" name="name" class="form-control" placeholder="">
                                                @error('name') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Email:</strong>
                                                <input class="form-control my-2" value="{{$user->email}}"  id="email" name="email" class="form-control" placeholder="">
                                                @error('email') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Password:</strong>
                                                <input class="form-control my-2" type="password" id="password" name="password" class="form-control" placeholder="">
                                                @error('password') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                <strong>Confirm Password:</strong>
                                                <input class="form-control my-2" type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="">
                                                @error('password_confirmation') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6">
                                            <div class="form-group">
                                                {{-- @dd(config('permission.teams')); // This should output `false` --}}

                                                <strong>Role:</strong>
                                                <select class="js-example-basic-multiple form-control" name="roles[]" id="role"
                                                multiple="multiple">
                                                    <option>select role</option>
                                                    @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}" {{ in_array($role->name, $userRole) ? 'selected' : '' }}>{{ $role->name }}</option>

                                                    @endforeach
                                                </select>
                                                @error('roles') <span class="text-danger">{{$message}}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-6 col-md-6 mt-5 text-end">
                                            <button type="submit" class="btn btn-primary">Add</button>
                                            <a href="{{route('users.index')}}" class="btn btn-danger">Back</a>
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

