@extends('layout.app')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 fw-semibold m-0">Dashboard</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-3">
                                <div class="card box1">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">

                                        <div class="cart">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>

                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder">RS {{ number_format($totalSales) }}</h2>
                                            {{-- {{ number_format($totalSales  / 1000, 0) }}k --}}
                                            <h3 class="mb-0 fs-4 fw-light">Sales</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box2">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">

                                        <div class="cart-total">
                                            <i class="fa-sharp fa-solid fa-cart-plus"></i>

                                        </div>

                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder">RS {{ number_format($totalAmount) }}</h2>
                                            <h3 class="mb-0 fs-4 fw-light">Purchase</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box3">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">

                                        <div class="cart-right-arrow">
                                            <i class="fa-sharp fa-solid fa-arrow-right"></i>
                                        </div>

                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder"></h2>
                                            <h3 class="mb-0 fs-4 fw-light">Sales Return</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box4">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                        <div class="cart-left-arrow">
                                            <i class="fa-solid fa-arrow-left"></i>
                                        </div>
                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder"></h2>
                                            <h3 class="mb-0 fs-4 fw-light">Purchase Returns</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="card box5">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">

                                        <div class="cart-dollar">
                                            <i class="fa-solid fa-dollar-sign"></i>
                                        </div>

                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder">{{ number_format($todayTotalSales) }}</h2>
                                            <h3 class="mb-0 fs-4 fw-light">Today Total Sales</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box6">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                        <div class="cart-money">
                                            <i class="fa-solid fa-money-bill"></i>
                                        </div>
                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder">{{ number_format($todayTotalReceived) }}</h2>
                                            <h3 class="mb-0 fs-4 fw-light">Today Total Received</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box7">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                        <div class="cart-pur-total">
                                            <i class="fa-sharp fa-solid fa-cart-plus"></i>

                                        </div>
                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder">{{ number_format($todayTotalPurchase) }}</h2>
                                            <h3 class="mb-0 fs-4 fw-light">Today Total Purchases</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="card box8">
                                    <div
                                        class="card-body cursor-pointer shadow-md rounded-10 p-xxl-10 px-7 py-10 d-flex align-items-center justify-content-between my-3">
                                        <div class="cart-dash">
                                            <i class="fa-solid fa-minus"></i>
                                        </div>
                                        <div class="text-end text-white">
                                            <h2 class="fs-1-xxl fw-bolder"></h2>
                                            <h3 class="mb-0 fs-4 fw-light">Today Total Expense</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="custom-product-content">
                    <div class="custom-card">
                        <canvas id="doughnutChart" width="400" height="400"></canvas>
                    </div>
                    <div class="custom-card">
                        <canvas id="myChart" width="400" height="200"></canvas>

                    </div>
                </div>


                <div class="row">
                    <div class="col-7">
                        <h2 style="color:#03c1fd;font-weight: bold;">Recent Order</h2>
                        <div class="card">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Payment</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($recentOrders as $order)
                                            @foreach ($order->products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>${{ number_format($product->pivot->price, 2) }}</td>
                                                    <td>
                                                        <label class="badge bg-primary">{{ $order->payment_status }}</label>
                                                    </td>
                                                    <td>
                                                        <label class="badge bg-success">{{ $order->status }}</label>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-5">
                        <h2 style="color:#03c1fd;font-weight: bold;">Recent Customers</h2>
                        <div class="card p-4">
                            @foreach ($recentCustomers as $customer)
                                <div class="d-flex align-items-center mb-4">
                                    <img src="{{ asset('customerImage/' . $customer->image) }}" alt="{{ $customer->name }}"
                                        style="width: 10%; height: auto; border-radius: 50%; margin-right: 15px;" />
                                    <div>
                                        <h5 class="card-title mb-0">{{ $customer->name }}</h5>
                                        <p class="card-text mb-0">{{ $customer->address }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
