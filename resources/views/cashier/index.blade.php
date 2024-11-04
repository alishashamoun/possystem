<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <style>
        .register-details table tr td {
            font-size: 14px;
        }

        .receipt-item-separator {
            border-bottom: 2px dotted #000;
        }

        span.receipt-subtotal {
            display: flex;
            justify-content: end;
        }

        h5.receipt-thank {
            font-size: 13px;
            font-weight: bold;
            text-align: -webkit-center;
        }

        thead.grey {
            --bs-table-accent-bg: var(--bs-table-striped-bg);
            color: var(--bs-table-striped-color);
            font-size: 10px;
        }

        tbody.numeric {
            font-size: 12px;
        }
    </style>

</head>

<body id="body">
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="left-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-3">
                                    <select class="form-select" id="customer_id" name="customer_id"
                                        onchange="updateCustomerDetails()">
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}" data-name="{{ $customer->name }}"
                                                data-email="{{ $customer->email }}" data-phone="{{ $customer->phone }}"
                                                data-address="{{ $customer->address }}">
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                        <option value="walk_in" data-name="Walk-In Customer" data-email=""
                                            data-phone="" data-address="">
                                            Walk-In Customer
                                        </option>
                                    </select>
                                    @error('customer_id')
                                        <span class="error text-danger">{{ $message }}</span>
                                    @enderror


                                    <button class="btn-with-input" type="button" id="button-addon2"
                                        data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i
                                            class="fa-regular fa-user user-icon"></i></button>
                                </div>

                                <!-- Modal Structure -->
                                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" tabindex="-1"
                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Create Customer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        @if ($customers->isNotEmpty())
                                                            <form method="post" class=""
                                                                action="{{ route('customers.store') }}">

                                                                @csrf
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <strong>Name:</strong>
                                                                            <input class="form-control my-2"
                                                                                type="name"
                                                                                value="{{ $customers->first()->name }}"
                                                                                name="name" required
                                                                                autocomplete="given-name" required>
                                                                            @error('name')
                                                                                <div class="error text-danger">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <strong>Email:</strong>
                                                                            <input class="form-control my-2"
                                                                                type="email"
                                                                                value="{{ $customers->first()->email }}"
                                                                                name="email" required
                                                                                autocomplete="email" required>
                                                                            @error('email')
                                                                                <div class="error text-danger">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <strong>Address:</strong>
                                                                            <textarea type="text" name="address" id="" cols="30" rows="4" class="form-control  my-2">{{ $customers->first()->address }}</textarea>
                                                                            @error('address')
                                                                                <div class="error text-danger">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <strong>phone:</strong>
                                                                            <input class="form-control my-2"
                                                                                type="phone"
                                                                                value="{{ $customers->first()->phone }}"
                                                                                name="phone" required
                                                                                autocomplete="phone" required>
                                                                            @error('phone')
                                                                                <div class="error text-danger">
                                                                                    {{ $message }}</div>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit"
                                                                        class="btn btn-primary">Create
                                                                        Customer</button>
                                                                </div>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="search-wrapper">
                                    <div>
                                        @foreach ($warehouses as $warehouse)
                                            <select class="form-select" id="header-warehouse" required>
                                                <option selected value="{{ $warehouse->id }}">{{ $warehouse->name }}
                                                </option>
                                            </select>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-lg-6">
                    <div class="right-header">
                        <div class="row">
                            <div class="col-6">
                                <div class="search-bar">
                                    <i class="fas fa-search"></i>
                                    <input type="text" id="search-input" placeholder="Search Product by Name">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="header-icons">
                                    <i class="fas fa-list"></i>

                                    <!-- Bag Icon with onclick -->
                                    <i id="bag-shopping" class="fa-sharp fa-solid fa-bag-shopping"
                                        style="cursor: pointer;" onclick="openModal()"></i>

                                    <!-- Modal Structure -->
                                    <div class="modal fade" id="shoppingModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">
                                                        <h5 id="register-details">Register Details (currenttime)</h5>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body" id="data">
                                                    <!-- Modal content here -->
                                                    <div class="row">
                                                        <!-- Payment Details -->
                                                        <div class="col-lg-12 col-12">
                                                            <div class="register-details">
                                                                <div class="card-body p-6">
                                                                    <!-- Register Details Table -->
                                                                    <table
                                                                        class="mb-0 text-nowrap table table-bordered table-hover">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Payment Type</td>
                                                                                <td class="px-3">Amount</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">Cash
                                                                                </td>
                                                                                <td class="px-3"><span
                                                                                        id="cash-amount">RS 0.00</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Credit Card</td>
                                                                                <td class="px-3"><span
                                                                                        id="credit-amount">RS
                                                                                        0.00</span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Debit Card</td>
                                                                                <td class="px-3"><span
                                                                                        id="debit-amount">RS
                                                                                        0.00</span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Online</td>
                                                                                <td class="px-3"><span
                                                                                        id="online-amount">RS
                                                                                        0.00</span></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Total Sales and Payment -->
                                                        <div class="col-lg-12 col-12">
                                                            <div class="register-details">
                                                                <div class="card-body p-6">
                                                                    <table
                                                                        class="mb-0 text-nowrap table table-bordered table-hover">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Total Sales:</td>
                                                                                <td class="px-3"><span
                                                                                        id="total-sales">RS 0.00</span>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td scope="row" class="ps-3">
                                                                                    Total Payment:</td>
                                                                                <td class="px-3"><span
                                                                                        id="total-payment">RS
                                                                                        0.00</span></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="printPage()" data-bs-dismiss="modal">Print</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="fullscreen-btn">
                                        <i class="fas fa-expand"></i>
                                    </div>
                                    <!-- Calculator Icon -->
                                    <button id="openCalculator" data-bs-toggle="modal"
                                        style="border: none; background: none;" data-bs-dismiss="modal"
                                        data-bs-target="#calculatorModal">
                                        <i id="calculator-icon" class="fas fa-calculator"></i>
                                    </button>


                                    <div class="btn-group">
                                        <button class="dropdown-toggle" id="dropdownMenuClickableOutside"
                                            data-bs-toggle="dropdown" data-bs-auto-close="inside">
                                            @php
                                                $user = Auth::user();
                                            @endphp
                                            <span
                                                class="custom-user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                            <span class="pro-user-name ms-1">
                                                {{ $user->name }}
                                            </span>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableOutside">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('profile.edit') }}">Profile</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">Logout</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>


                                <!-- Calculator Modal -->
                                <div class="modal fade" id="calculatorModal" tabindex="-1"
                                    aria-labelledby="calculatorLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-right">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Calculator Design -->
                                                <div class="calculator">
                                                    <input type="text" id="calculator-screen" readonly />
                                                    <div class="calculator-buttons">
                                                        <button class="btn large-btn c-btn" value="C">C</button>
                                                        <button class="btn" value="AC">AC</button>
                                                        <button class="btn-coloring" value="+">+</button>
                                                        <button class="btn" value="1">1</button>
                                                        <button class="btn" value="2">2</button>
                                                        <button class="btn" value="3">3</button>
                                                        <button class="btn-coloring" value="-">-</button>
                                                        <button class="btn" value="4">4</button>
                                                        <button class="btn" value="5">5</button>
                                                        <button class="btn" value="6">6</button>
                                                        <button class="btn-coloring" value="*">*</button>
                                                        <button class="btn" value="7">7</button>
                                                        <button class="btn" value="8">8</button>
                                                        <button class="btn" value="9">9</button>
                                                        <button class="btn-coloring" value="/">/</button>
                                                        <button class="btn large-btn zero-btn"
                                                            value="0">0</button>
                                                        <button class="btn-coloring" value=".">.</button>
                                                        <button class="btn-coloring" value="=">=</button>
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
            </div>
        </div>
    </div>


    <div class="container-fluid">

        <div class="row">
            <div class="col-6 ">
                <div class="product-list" id="product-list">
                    <table>
                        <thead>
                            <tr>
                                <th>PRODUCT</th>
                                <th>QTY</th>
                                <th>PRICE</th>
                                <th>SUB TOTAL</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="product-list-body" data-bs-target="#product-list-body" class="scrollspy-example"
                            tabindex="0">
                            <!-- Rows will be dynamically inserted here -->
                        </tbody>
                    </table>


                    <div class="checkout-section">

                        <div class="input-group mb-3">
                            <input type="number" aria-label="Tax" name="tax" id="tax-input" class="rounded-1"
                                placeholder="Tax">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" aria-label="Discount" name="discount" id="discount-input"
                                class="rounded-1" placeholder="Discount">
                            <span class="input-group-text">Rs</span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="number" aria-label="Shipping" name="shipping" id="shipping-input"
                                class="rounded-1" placeholder="Shipping">
                            <span class="input-group-text">Rs</span>
                        </div>

                        <div class="totals">
                            <p>Total QTY: <span id="total-qty">0</span></p>
                            <p>Sub Total: <span id="sub-total">0.00</span></p>
                            <p>Total: <span id="total-price">0.00</span></p>
                        </div>
                        <!-- Checkout Buttons -->
                        <div class="checkout-buttons">
                            <button class="checkout-button" id="reset-btn">
                                <i class="fas fa-sync"></i> Reset
                            </button>

                            <button id="pay-now-btn" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <i class="fas fa-money-bill-wave"></i> Pay Now
                            </button>
                        </div>

                        <div class="modal fade" id="exampleModal" data-bs-backdrop="static" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title" id="exampleModalLabel">Payment Form</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-8 col-12">
                                                <div class="payment-form">
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>{{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif


                                                    <form action="{{ route('cashier.processPayment') }}"
                                                        method="POST" id="paymentForm">
                                                        @csrf
                                                        <!-- Warehouse -->
                                                        <input type="hidden" name="warehouse"
                                                            value="{{ $warehouse->name }}" />

                                                        <!-- Customer ID -->
                                                        <input type="hidden" name="customer_id"
                                                            value="{{ $customer->id }}" />

                                                        <input type="hidden" id="grand_total" name="grand_total"
                                                            value="" />
                                                        <input type="hidden" name="paid" id="paid"
                                                            value="" />
                                                        <input type="hidden" name="products[0][id]" value="1">
                                                        <input type="hidden" name="products[0][quantity]"
                                                            value="2">
                                                        <input type="hidden" name="products[0][price]"
                                                            value="100">

                                                        <div class="row">
                                                            <!-- Received Amount -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="received_amount">Received Amount:</label>
                                                                <input type="number" class="form-control"
                                                                    id="received_amount" name="received_amount"
                                                                    oninput="calculateChangeReturn()" required>
                                                                @error('received_amount')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Paying Amount -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="paying-amount">Paying Amount:</label>
                                                                <input type="number" id="paying-amount"
                                                                    name="paying_amount" class="form-control"
                                                                    oninput="calculateChangeReturn()" required>
                                                                @error('paying_amount')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Change Return -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="change-return">Change Return:</label>
                                                                <input type="number" id="change-return"
                                                                    name="change_return" class="form-control"
                                                                    readonly>
                                                                @error('change_return')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Payment Type -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="payment-type">Payment Type:</label>
                                                                <select id="payment-type" class="form-select"
                                                                    name="payment_type" required>
                                                                    <option value="Cash">Cash</option>
                                                                    <option value="Credit Card">Credit Card</option>
                                                                    <option value="Debit Card">Debit Card</option>
                                                                    <option value="Online">Online</option>
                                                                </select>
                                                                @error('payment_type')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Payment Status -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="payment-status">Payment Status:</label>
                                                                <select class="form-select" id="payment-status"
                                                                    name="payment_status" required>
                                                                    <option value="paid">Paid</option>
                                                                    <option value="unpaid">UnPaid</option>
                                                                </select>
                                                                @error('payment_status')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Status -->
                                                            <div class="col-6 form-group mb-4">
                                                                <label for="status">Status:</label>
                                                                <select class="form-select" id="status"
                                                                    name="status" required>
                                                                    <option value="pending">Pending</option>
                                                                    <option value="completed">Completed</option>
                                                                    <option value="failed">Failed</option>
                                                                </select>
                                                                @error('status')
                                                                    <span
                                                                        class="error text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>

                                                            <!-- Form Buttons -->
                                                            <div class="modal-footer">
                                                                <button class="btn btn-success" type="submit"
                                                                    id="paymentsubmit">Submit Payment</button>
                                                                <button type="button" class="btn btn-danger"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </form>


                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12">
                                                <div class="card shadow-sm">
                                                    <div class="card-body p-6">
                                                        <table
                                                            class="mb-0 text-nowrap table table-striped table-bordered table-hover">
                                                            <tbody>
                                                                <tr>
                                                                    <td scope="row" class="ps-3">Total
                                                                        Products
                                                                    </td>
                                                                    <td class="px-3"><span class="badge bg-info"
                                                                            id="total-products"></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="ps-3">Total Amount
                                                                    </td>
                                                                    <td class="px-3"><span id="total-amount">RS
                                                                            0.00</span></td>
                                                                </tr>

                                                                <tr>
                                                                    <td scope="row" class="ps-3">Order Tax
                                                                    </td>

                                                                    <td class="px-3"><span id="order-tax">RS
                                                                            0.00
                                                                            (0.00%)</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="ps-3">Discount
                                                                    </td>
                                                                    <td class="px-3"><span id="discount-display">RS
                                                                            0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="ps-3">Shipping
                                                                    </td>
                                                                    <td class="px-3"><span id="shipping-display">RS
                                                                            0.00</span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td scope="row" class="ps-3">Grand Total
                                                                    </td>
                                                                    <td class="px-3"><span id="grand-total">RS
                                                                            0.00</span></td>
                                                                </tr>
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

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#receiptModal">
                            Launch static backdrop modal
                        </button>
                        <!-- Receipt Modal -->
                        <div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <div class="modal-title">
                                            <span class="fs-5">Invoice POS</span>
                                        </div>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body" id="invoice">
                                        <div class="modal-logo mt-4 mb-4 text-white text-center">
                                            <a>POS</a>
                                        </div>

                                        <table class="table mt-5">
                                            <tbody>
                                                <tr>
                                                    <td scope="row" class="p-0">
                                                        <span>Date:</span>
                                                        <span id="current-date"></span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="p-0">
                                                        <span>Customer:</span>
                                                        <span id="customer-name"></span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="p-0">
                                                        <span>Email:</span>
                                                        <span id="customer-email"></span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="p-0">
                                                        <span>Phone:</span>
                                                        <span id="customer-phone"></span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td scope="row" class="p-0">
                                                        <span>Address:</span>
                                                        <span id="customer-address"></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!-- Invoice Section -->
                                        <div id="receipt">
                                            <!-- Receipt items will be appended here -->
                                            <div id="receipt-products">
                                                <!-- Receipt items will be dynamically added here -->
                                            </div>

                                            <!-- Receipt totals -->
                                            <div id="receipt-totals">
                                                <div class="receipt-total d-flex justify-content-between">
                                                    <span>Total Amount:</span>
                                                    <span id="receipt-td-total-amount">RS 0.00</span>
                                                </div>
                                                <div class="receipt-item-separator"></div>
                                                <div class="receipt-tax d-flex justify-content-between">
                                                    <span>Order Tax:</span>
                                                    <span id="receipt-order-tax">RS 0.00 (0.00 %)</span>
                                                </div>
                                                <div class="receipt-item-separator"></div>
                                                <div class="receipt-discount d-flex justify-content-between">
                                                    <span>Discount:</span>
                                                    <span id="receipt-discount">RS 0.00</span>
                                                </div>
                                                <div class="receipt-item-separator"></div>
                                                <div class="receipt-grand-total d-flex justify-content-between">
                                                    <span>Grand Total:</span>
                                                    <span id="receipt-grand-total">RS 0.00</span>
                                                </div>
                                                <div class="receipt-item-separator"></div>
                                            </div>
                                        </div>

                                        <table class="mb-5 table">
                                            <thead class="grey">
                                                <tr>
                                                    <th class="py-2 px-0">Paid by</th>
                                                    <th class="py-2 px-0">Amount</th>
                                                    <th class="py-2 px-0">Change Return</th>
                                                </tr>
                                            </thead>
                                            <tbody class="numeric">
                                                <tr>
                                                    <td class="py-2 px-0" id="amount-paid">RS 00.00</td>
                                                    <td class="py-2 px-0" id="table-td-total-amount">00.00</td>
                                                    <td class="py-2 px-0" id="change-return-display">
                                                        {{ $changeReturn ?? '0.00' }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- End of Invoice Section -->
                                        <h5 class="receipt-thank">Thank You For Shopping With Us.
                                            Please visit again.
                                        </h5>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="printModal()"
                                            data-bs-dismiss="modal">Print</button>
                                        <button type="button" class="btn btn-danger clear-receipt"
                                            data-bs-dismiss="modal">Close</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="product-showcase">
                    <div class="categories">
                        <button class="category-btn active" data-filter="all">All Categories</button>
                        <button class="category-btn" data-filter="snacks">Snacks</button>
                        <button class="category-btn" data-filter="beverage">Beverage</button>
                    </div>
                    <div class="brands">
                        <button class="brand-btn active" data-filter="all">All Brands</button>
                        <button class="brand-btn" data-filter="lu">LU</button>
                        <button class="brand-btn" data-filter="pepsi">Pepsi Co</button>
                        <button class="brand-btn" data-filter="pakola">Pakola</button>
                    </div>
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <div class="product-card" data-category="{{ $product->category }}"
                                data-brand="{{ $product->brand }}">
                                <div class="product-image">
                                    <img src="{{ asset('image/' . $product->product_image) }}" alt="Product Image"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}"
                                        data-product-quantity="{{ $product->inventory_level }}">
                                </div>
                                <div class="product-details">
                                    <div class="prodname">
                                        <span id="price" class="badge rounded-pill">Rs
                                            {{ $product->price }}</span>
                                    </div>

                                    <span class="product-name">{{ $product->name }}</span>

                                    <div class="prodqty">
                                        <span id="qty"
                                            class="badge rounded-pill">{{ $product->inventory_level }} Piece</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
