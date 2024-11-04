@extends('layout.app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <div class="card-header">

                        <a href="{{ route('customers.create') }}" class="btn btn-primary my-2">Create</a>
                    </div><!-- end card header -->
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <li class="breadcrumb-item active">Customer List</li>
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
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Image</th>
                                        <th>Created At</th>
                                        <th>Actions</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($customers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
                                        <td>{{ $customer->address }}</td>
                                        <td>
                                            @if (!empty($customer->image))
                                                <img src="{{ asset('customerImage/' . $customer->image) }}" alt="{{ $customer->name }}" style="width: 100px; height: auto;">
                                            @else
                                                <span>No Image</span>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="badge bg-light-info p-2">
                                                <div class="time mb-1">{{ \Carbon\Carbon::parse($customer->created_at)->format('H:i') }}</div>
                                                <div class="date">{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</div>
                                            </div>
                                        </td>

                                        <td><a href="{{ route('customers.edit', $customer->id) }}" ><i class="fa-regular fa-pen-to-square"></i></a></td>
                                        <td>
                                             <form method="POST" action="{{ route('customers.destroy', $customer->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0" onclick="return confirm('Are you sure you want to delete this?')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                    </tr>
                                    @empty
                                    <P>customer not found</P>
                                    @endforelse
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
