@extends('layout.app')

@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-xxl">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <div class="card-header">

                            <a href="{{ route('inventory.create') }}" class="btn btn-primary my-2">Create</a>
                        </div><!-- end card header -->
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">

                            <li class="breadcrumb-item active">Inventory List</li>
                        </ol>
                    </div>
                </div>


                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">


                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Quantity</th>
                                            <th>Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->name }}</td>
                                                <td id="quantity-{{ $product->id }}">{{ $product->quantity }}</td>

                                                <td>

                                                        @foreach ($product->inventory as $inventory)
                                                            <a href="{{ route('inventory.edit', $inventory->id) }}">
                                                                <i class="fa-regular fa-pen-to-square"></i>
                                                            </a>

                                                            <form method="POST" action="{{ route('inventory.destroy', $inventory->id) }}" style="display:inline;">
                                                                @csrf
                                                                @method('delete')
                                                                <a
                                                                onclick="return confirm('Are You sure you want to delete this?')"><i class="fa-solid fa-trash"></i></a>
                                                            </form>
                                                        @endforeach

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
    </div>
    </div>
    </div>
@endsection
