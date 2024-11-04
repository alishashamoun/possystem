@extends('layout.app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <a href="{{route('purchases.create')}}" class="btn btn-primary my-2" >Create</a>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">

                        <li class="breadcrumb-item active">Purchase List</li>
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
                                        <th>Supplier</th>
                                        <th>Purchase Date</th>
                                        <th>Total Amount</th>
                                        <th>Payment Status</th>
                                        <th>Actions</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->supplier->name }}</td>
                                            <td>{{ $purchase->purchase_date }}</td>
                                            <td>{{ $purchase->total_amount }}</td>
                                            <td><span class="badge text-darksale">{{ $purchase->payment_status }}</span></td>

                                            <td>
                                                <a href="{{ route('purchases.edit', $purchase->id) }}"><i class="fa-regular fa-pen-to-square"></i></a>

                                            </td>
                                            <td>
                                                <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" style="display:inline;">
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
