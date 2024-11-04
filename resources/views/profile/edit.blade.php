@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">
                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            </div>
                            <div class="card-body">

                                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="pickerheader mb-4">
                                                <strong>Change Image:</strong>
                                            </div>
                                            <div class="d-block">
                                                <div class="imagepicker">
                                                    <div class="previewImage">
                                                        @php
                                                            $user = Auth::user();
                                                        @endphp

                                                        <span class="custom-user-avatar w-100 h-100 {{ $user->profile_image ? 'd-none' : '' }}">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>

                                                        <span class="picker-edit rounded-circle text-gray-500 fs-small cursor-pointer">
                                                            <input class="upload-file" id="fileInput" name="profile_image" type="file" accept=".png, .jpg, .jpeg" style="display:none;">
                                                            <i class="fa-solid fa-pen" id="penIcon" style="cursor: pointer;"></i>
                                                        </span>
                                                        @if ($user->profile_image)
                                                            <img id="imagePreview" src="{{ asset('storage/' . $user->profile_image) }}" alt="Profile Image" style="max-width: 100px;">
                                                        @endif
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <strong>First Name:</strong>
                                            <input type="text" class="form-control" name="name"
                                                value="{{ $user->name }}" placeholder="First Name">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <strong>Email:</strong>
                                            <input type="text" class="form-control" name="email"
                                                value="{{ $user->email }}" placeholder="Email">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-danger">Back</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
