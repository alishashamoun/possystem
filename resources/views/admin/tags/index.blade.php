@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <div class="card-header">

                            <a href="{{ route('tags.create') }}" class="btn btn-primary my-2">Create</a>
                        </div><!-- end card header -->
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">

                            <li class="breadcrumb-item active">Tag List</li>
                        </ol>
                    </div>
                </div>

                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">



                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $id = 1;
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <tr>
                                                <td>{{ $id++ }}</td>
                                                <td>{{ $tag->name }}</td>


                                                </td>


                                                <td>

                                                    <a
                                                        href="{{ route('tags.edit', $tag->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('tags.destroy', $tag->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <a
                                                        onclick="return confirm('Are You sure you want to delete this?')"><i class="fa-solid fa-trash"></i></a>
                                                    </form>
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
