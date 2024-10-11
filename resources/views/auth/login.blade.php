<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from zoyothemes.com/kadso/html/auth-login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jul 2024 10:45:01 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>

    <meta charset="utf-8" />
    <title>Log In | Kadso - Responsive Admin Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc." />
    <meta name="author" content="Zoyothemes" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="/assets/images/favicon.ico">

    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




    <!-- Icons -->
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>


<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                <div class="bg-color p-4">
                    <div class="content mx-auto">
                        <div class="text-center">
                            <h3 class="text-dark fs-20 fw-medium mb-2">Sign In</h3>
                        </div>

                        {{-- Display error message if exists --}}
                        @if ($errors->any())
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{ $errors->first() }}</strong>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="my-4">
                            @csrf
                            <div class="form-group mb-3">
                                <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="Enter your email">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <input class="form-control" type="password" id="password" name="password" required placeholder="Enter your password">
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn btn-primary log-in w-100" type="submit"> Log In </button>
                            </div>
                        </form>
                        <div class="text-center text-muted">
                            <p class="mb-0">Don't have an account? <a class="text-primary ms-2 fw-medium" href="">Sign Up</a></p>
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
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="assets/js/script.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/js-flash-message@1.0.8/index.min.js"></script>




</body>

<!-- Mirrored from zoyothemes.com/kadso/html/auth-login by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 01 Jul 2024 10:45:01 GMT -->

</html>
