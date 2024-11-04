@extends('layout.app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <a href="{{route('suppliers.create')}}" class="btn btn-primary my-2" >Create</a>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">

                        <li class="breadcrumb-item active">Supplier List</li>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <table class="table table-stripped">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($suppliers as $supplier)
                                        <tr>

                                            <td>{{ $supplier->name }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->phone }}</td>
                                            <td>{{ $supplier->address }}</td>
                                            <td>
                                                <div class="badge bg-light-info p-2">
                                                    <div class="time mb-1">{{ \Carbon\Carbon::parse($supplier->created_at)->format('H:i') }}</div>
                                                    <div class="date">{{ \Carbon\Carbon::parse($supplier->created_at)->format('d M Y') }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('suppliers.edit', $supplier->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                            </td>

                                            <td>
                                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" >
                                                    @csrf
                                                    @method('DELETE')
                                                    <button style="border: none; background: none; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this?')">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
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
