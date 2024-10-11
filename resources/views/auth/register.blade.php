<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from zoyothemes.com/kadso/html/auth-register by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jul 2024 10:45:01 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8" />
    <title>Register | Kadso - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Icons -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="bg-color">
    <div class="content-form">

    <!-- Begin page -->
    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-xl-6 col-lg-6">
                            <div class="row">
                                <div class="col-md-6 mx-auto">
                                    <div class="mb-0 border-0">
                                        <div class="p-0">
                                            <div class="text-center">


                                                <div class="auth-title-section mb-3">
                                                    <h3 class="text-dark fs-20 fw-medium">Get's started</h3>
                                                    <p class="text-dark text-capitalize fs-14 mb-0">Please enter your
                                                        details.</p>
                                                </div>
                                            </div>
                                        </div>
                                        @if ($errors->any())
                                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                                        <div>{{ $errors->first() }}</div> <button
                                                            type="button" class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    {{-- <div class="alert alert-danger alert-block">
                                                        <button type="button" class="close"
                                                            data-dismiss="alert">×</button>
                                                        <strong></strong>
                                                    </div> --}}
                                                @endif
                                        <div class="pt-0">
                                            <form action="{{ route('register') }}" class="my-4" method="POST">
                                                @csrf
                                                <div class="form-group mb-3">

                                                    <input class="form-control" name="name" type="text"
                                                        id="username" required="" placeholder="Enter your Username">
                                                </div>

                                                <div class="form-group mb-3">

                                                    <input class="form-control" name="email" type="email"
                                                        id="emailaddress" required="" placeholder="Enter your email">
                                                </div>

                                                <div class="form-group mb-3">

                                                    <input class="form-control" name="password" type="password"
                                                        required="" id="password" placeholder="Enter your password">
                                                </div>

                                                <div class="form-group mb-3">

                                                    <input class="form-control" name="password_confirmation" type="password"
                                                           required id="password" placeholder="Enter your confirmed password">
                                                </div>



                                                <div class="form-group mb-0 row">
                                                    <div class="col-12">
                                                        <div class="d-grid">
                                                            <button class="btn btn-primary register" type="submit">
                                                                Register</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-center text-muted">
                                                <p class="mb-0">Already have an account ?<a
                                                        class='text-primary ms-2 fw-medium' href='/login'>Login
                                                        here</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="col-md-6 col-xl-6 col-lg-6 p-0 vh-100 d-flex justify-content-center">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
    <!-- END wrapper -->

    <!-- Vendor -->
    <script src="/assets/libs/jquery/jquery.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>

    <!-- App js-->
    <!-- App js-->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script><script  src="assets/js/script.js"></script>

</body>

<!-- Mirrored from zoyothemes.com/kadso/html/auth-register by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jul 2024 10:45:01 GMT -->

</html>
