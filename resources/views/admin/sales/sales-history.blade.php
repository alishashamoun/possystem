@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="pt-4 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h1>Sales Report</h1>
                    </div>
                    <button onclick="window.print()" class="btn btn-primary"><i class="fa-solid fa-print"></i></button>
                </div>

                <!-- Datatables  -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow p-3 mb-5 bg-body rounded">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Customer</th>
                                            <th>Warehouse</th>
                                            <th>Status</th>
                                            <th>Grand Total</th>
                                            <th>Paid</th>
                                            <th>Payment Status</th>
                                            <th>Payment Type</th>
                                            <th>Created At</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            @php
                                                $customer = \App\Models\Customer::find($sale->customer_id);
                                                $warehouse = \App\Models\Warehouse::find($sale->warehouse);
                                            @endphp
                                            @foreach ($sale->products as $product)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset('Image/' . $product->product_image) }}"
                                                            alt="Product Image" width="100">
                                                    </td>

                                                    <td>{{ $customer ? $customer->name : 'Customer not found' }}</td>
                                                    <td>{{ $sale->warehouse ? $sale->warehouse : 'Warehouse not found' }}
                                                    </td>

                                                    <td><span class="badge text-darksale">{{ $sale->status }}</span></td>
                                                    <td>{{ 'RS ' . number_format($sale->grand_total, 2) }}</td>
                                                    <td>{{ 'RS ' . number_format($sale->paid, 2) }}</td>
                                                    <td><span
                                                            class="badge text-darkstatus">{{ $sale->payment_status }}</span>
                                                    </td>
                                                    <td><span class="badge bg-darktype">{{ $sale->payment_type }}</span>
                                                    </td>
                                                    <td>
                                                        <div class="badge bg-light-info p-2">
                                                            <div class="time mb-1">
                                                                {{ \Carbon\Carbon::parse($sale->created_at)->format('H:i') }}
                                                            </div>
                                                            <div class="date">
                                                                {{ \Carbon\Carbon::parse($sale->created_at)->format('d M Y') }}
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
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
