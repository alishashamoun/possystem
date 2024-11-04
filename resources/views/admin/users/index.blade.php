@extends('layout.app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <a href="{{route('users.create')}}" class="btn btn-primary my-2" >Create</a>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">

                        <li class="breadcrumb-item active">User List</li>
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

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($users as $user)
                                        <tr>

                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->getRoleNames()->isNotEmpty())

                                                    @foreach ($user->getRoleNames() as $v)
                                                        <label class="badge bg-success"> {{ $v }}</label>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td>

                                                <a
                                                    href="{{ route('users.edit', $user->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('users.destroy', $user->id) }}">
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
