<!DOCTYPE html>
<html lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
    <meta charset="utf-8" />
    <title>Shopping Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Flatpickr Timepicker css -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />


    <!-- Include Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet" />
    <!-- Include jQuery (required for Select2) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <!-- Select 2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

</head>
<!-- body start -->

<body data-sidebar="default">
    <!-- Begin page -->
    <div id="app-layout">
        <!-- Topbar Start -->
        <div class="topbar-custom">
            <div class="container-fluid">
                <div class="d-flex justify-content-between">
                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">
                        <li>
                            <button class="button-toggle-menu nav-link">
                                <i data-feather="menu" class="noti-icon"></i>
                            </button>
                        </li>
                        <li class="d-none d-lg-block">
                            <div class="position-relative topbar-search">
                                <input type="text" id="sidebar-search"
                                    class="form-control bg-light bg-opacity-75 border-light ps-4"
                                    placeholder="Search...">
                                <i
                                    class="mdi mdi-magnify fs-16 position-absolute text-muted top-50 translate-middle-y ms-2"></i>
                            </div>
                        </li>
                    </ul>

                    <ul class="list-unstyled topnav-menu mb-0 d-flex align-items-center">

                        <li class="dropdown notification-list topbar-dropdown">
                            <a class="nav-link dropdown-toggle nav-user me-0" data-bs-toggle="dropdown" href="#"
                                role="button" aria-haspopup="false" aria-expanded="false">
                                @php
                                    $user = Auth::user();
                                @endphp
                                <span class="custom-user-avatar">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                <span class="pro-user-name ms-1">
                                    {{ $user->name }} <i class="mdi mdi-chevron-down"></i>
                                </span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuClickableOutside">
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>

                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- end Topbar -->

        <!-- Left Sidebar Start -->
        <div class="app-sidebar-menu">
            <div class="h-100" data-simplebar>

                <!--- Sidemenu -->
                <div id="sidebar-menu">

                    <div class="logo-box">
                        <a class='logo logo-light' href='index.html'>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="24">
                            </span>
                        </a>
                        <a class='logo logo-dark' href='index.html'>
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                            </span>
                            <span class="">

                                <a class="pos-button" href="{{ route('cashier.index') }}">POS</a>
                            </span>
                        </a>
                    </div>

                    <ul id="side-menu">
                        <li class="sidebar-item ">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fa-solid fa-house-chimney-window"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        <x-layout :menuItems="[
                            ['route' => 'customers.index', 'name' => 'Customer', 'icon' => 'fa-user-large'],
                            ['route' => 'users.index', 'name' => 'User', 'icon' => 'fa-user-large'],
                            ['route' => 'suppliers.index', 'name' => 'Supplier', 'icon' => 'fa-user-large'],
                        ]" />


                        <li class="sidebar-item">
                            <a href="#sidebarAuth" data-bs-toggle="collapse">
                                <i class="fa-solid fa-boxes-stacked"></i>
                                <span>Product</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarAuth">
                                <ul class="nav-second-level">

                                    <li class="sidebar-item">
                                        <a href="{{ route('products.index') }}">
                                            <i class="fa-solid fa-box-open"></i>
                                            Product</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('categories.index') }}">
                                            <i class="fa-solid fa-layer-group"></i>
                                            Categories</a>
                                    </li>
                                    <li class="sidebar-item">
                                        <a href="{{ route('tags.index') }}">
                                            <i class="fas fa-tags"></i>
                                            Tags</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        {{-- purchase sidebar --}}
                        <li class="sidebar-item">
                            <a href="#sidebarPurchase" data-bs-toggle="collapse">
                                <i class="fa-sharp fa-solid fa-cart-shopping"></i>
                                <span>Purchase</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarPurchase">
                                <ul class="nav-second-level">
                                    <li>
                                        <a href="{{ route('purchases.index') }}">
                                            <i class="fa-sharp fa-solid fa-cart-shopping"></i><span>Purchase</span></a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-item">
                            <a href="#sidebarInventory" data-bs-toggle="collapse">
                                <i data-feather="box"></i>
                                <span>Inventory</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebarInventory">
                                <ul class="nav-second-level">
                                    <li><a href="{{ route('inventory.index') }}">
                                            <i class="fa-solid fa-box"></i> View Inventory</a></li>


                                    {{-- <a href="{{ route('inventory.checkStockLevels') }}">
                                        <i class="fas fa-chart-bar"></i> Check Stock Levels
                                    </a>

                                    <a href="{{ route('inventory.report') }}">
                                        <i class="fas fa-file-pdf"></i> Generate Report
                                    </a> --}}

                                </ul>
                            </div>
                        </li>

                        <li class="sidebar-item ">
                            <a href="{{ route('sales.history') }}">
                                <i data-feather="shopping-cart"></i>
                                <span> Sales Report </span>
                            </a>
                        </li>

                        <li class="sidebar-item ">
                            <a href="{{ route('inventory.report') }}">
                                <i data-feather="shopping-cart"></i>
                                <span> Inventory Report </span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href='{{ route('logout') }}'>
                                <i data-feather="log-out"></i>
                                <span> Logout </span>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- End Sidebar -->
                <div class="clearfix"></div>

            </div>
        </div>



    </div>
    <!-- Left Sidebar End -->

    @yield('content')
    @yield('scripts')

    <script>
        const searchInput = document.getElementById('sidebar-search');
        const sidebarItems = document.querySelectorAll('.sidebar-item');

        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            sidebarItems.forEach((item) => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });


        $(document).ready(function() {
            var successMessage = '{{ session('success') }}';
            if (successMessage) {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success(successMessage);

            }
        });
    </script>

    <!-- Vendor -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Flatpickr Timepicker Plugin js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/form-picker.js') }}"></script>

    <!-- App js-->
    <!-- Include jQuery (required for Select2) -->
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <!-- Include Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: "Select options"
            });
        });

        const months = @json($months);
        const totals = @json($totals);


    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script src="{{ asset('assets/js/jquery.min.js') }}"></script> --}}
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
