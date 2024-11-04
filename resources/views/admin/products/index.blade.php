@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <div class="card-header">
                            <a href="{{ route('products.create') }}" class="btn btn-primary my-2">Product Create</a>
                        </div>
                    </div>

                    <div class="text-end">
                        <ol class="breadcrumb m-0 py-0">

                            <li class="breadcrumb-item active">Product List</li>
                        </ol>
                    </div>
                </div>

                <!-- Datatables  -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Product</th>
                                            <th>Description</th>
                                            <th>Price</th>
                                            <th>Quantity </th>
                                            <th>Category Id</th>
                                            <th>Tag Id</th>
                                            <th>Alert Stock</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>

                                                <td>{{ $product->name }}</td>
                                                <td>
                                                    <img src="{{ asset('Image/' . $product->product_image) }}"
                                                        alt="Product Image" width="100">
                                                </td>

                                                <td>{{ $product->description }}</td>
                                                <td>{{ $product->price }}</td>
                                                <td>{{ $product->quantity }}</td>
                                                <td>{{ $product->category ? $product->category->name : 'No category' }}</td>
                                                <td>
                                                    @foreach ($product->tags as $tag)
                                                        <span class="badge badge-pilltag">{{ $tag->name }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if ($product->alert_stock >= $product->quantity)
                                                        <span class="badge bg-dangerlow">Low Stock >
                                                            {{ $product->alert_stock }}</span>
                                                    @else
                                                        <span
                                                            class="badge bg-successalert">{{ $product->alert_stock }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="badge bg-light-info p-2">
                                                        <div class="time mb-1">
                                                            {{ \Carbon\Carbon::parse($product->created_at)->format('H:i') }}
                                                        </div>
                                                        <div class="date">
                                                            {{ \Carbon\Carbon::parse($product->created_at)->format('d M Y') }}
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                </td>
                                                <td>
                                                    <form method="POST"
                                                        action="{{ route('products.destroy', $product->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0"
                                                            onclick="return confirm('Are you sure you want to delete this?')">
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
