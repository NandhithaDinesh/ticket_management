<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('assets/backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('assets/backend/img/undraw_rocket.svg') }}" />
    <!-- Custom styles for this template-->
    <link href="{{ asset('assets/backend/css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/summernote.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">


</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        @include('backend.layouts.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                @include('backend.layouts.nav')

                @yield('content')
            </div>

            @include('backend.layouts.footer')

        </div>

    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toast = document.getElementById("toast");
            if (toast) {
                setTimeout(() => {
                    toast.classList.add("toast-show");
                }, 100); // slight delay for animation

                // Hide after 3 seconds
                setTimeout(() => {
                    toast.classList.remove("toast-show");
                }, 3000);
            }
        });
    </script>
    <!-- Core JS -->
    <script src="{{ asset('assets/backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/summernote.js') }}"></script>
    <script src="{{ asset('assets/backend/js/select2.min.js') }}"></script>
    <!-- Admin JS -->
    <script src="{{ asset('assets/backend/js/sb-admin-2.min.js') }}"></script>

    <!-- Plugins -->
    <script src="{{ asset('assets/backend/vendor/chart.js/Chart.min.js') }}"></script>

    <!-- Example Charts -->
    <script src="{{ asset('assets/backend/js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('assets/backend/js/demo/chart-pie-demo.js') }}"></script>

    <!-- Datatables -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @stack('scripts')

</body>

</html>
