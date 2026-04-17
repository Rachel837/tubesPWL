<!DOCTYPE html>
<html class="no-js" lang="id">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>EventCon - Pengguna</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png') }}">

        <!-- CSS di sini -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/themify-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/gijgo.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/flaticon.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/slicknav.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <style>
            /* Premium Dark Theme Implementation */
            body {
                background: radial-gradient(circle at top, #1e293b 0%, #0f172a 50%, #020617 100%);
                color: #ffffff;
                min-height: 100vh;
                font-family: 'Figtree', sans-serif;
                font-weight: normal;
            }

            .user-content {
                padding: 80px 0;
            }

            /* Header Adjustments */
            .main-header-area {
                background: rgba(15, 23, 42, 0.8) !important;
                backdrop-filter: blur(10px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .main-menu ul li a {
                color: #f8fafc !important;
            }

            .main-menu ul li .submenu {
                background: #1e293b !important;
                box-shadow: 0 10px 30px rgba(0,0,0,0.5) !important;
            }

            .main-menu ul li .submenu li a {
                color: #94a3b8 !important;
            }

            .main-menu ul li .submenu li a:hover {
                color: #ff3c00 !important;
                background: rgba(255, 60, 0, 0.1);
            }

            /* Card Aesthetics */
            .card {
                background: rgba(30, 41, 59, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 16px;
                transition: all 0.3s ease;
            }

            .event-card {
                margin-bottom: 30px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            }

            .event-card:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.4);
                border-color: rgba(255, 60, 0, 0.5);
            }

            .event-card img {
                width: 100%;
                height: 220px;
                object-fit: cover;
                border-top-left-radius: 16px;
                border-top-right-radius: 16px;
            }

            .event-card h5 {
                color: #ffffff;
                font-weight: normal;
                margin-bottom: 15px;
            }

            .text-muted {
                color: rgba(255, 255, 255, 0.6) !important;
            }

            /* Form Elements */
            .form-control, .nice-select {
                background-color: rgba(15, 23, 42, 0.6) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                color: #f8fafc !important;
                border-radius: 10px;
            }

            .form-control:focus {
                background-color: rgba(15, 23, 42, 0.8) !important;
                border-color: #ff3c00 !important;
                box-shadow: 0 0 0 0.25 cold-rgba(255, 60, 0, 0.25) !important;
            }

            /* Footer Adjustments */
            .footer {
                background: #020617;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
            }

            .footer_top h4, .footer_top p {
                color: #f8fafc;
            }

            .copy-right_text {
                background: #010409;
                border-top: 1px solid rgba(255, 255, 255, 0.05);
            }

            /* Ticket specific */
            .ticket-card {
                background: rgba(15, 23, 42, 0.4);
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
                transition: all 0.2s ease;
            }

            .ticket-card:hover {
                background: rgba(255, 60, 0, 0.05);
                border-color: rgba(255, 60, 0, 0.3) !important;
            }

            .form-check-input:checked {
                background-color: #ff3c00;
                border-color: #ff3c00;
            }

            /* Alerts */
            .alert {
                background: rgba(30, 41, 59, 0.8);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.1);
                color: #f8fafc;
                border-radius: 12px;
            }

            .alert-success { border-left: 4px solid #10b981; }
            .alert-warning { border-left: 4px solid #f59e0b; }
            .alert-danger { border-left: 4px solid #ef4444; }
            .alert-info { border-left: 4px solid #3b82f6; }

            hr {
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            /* Buttons */
            .btn-primary {
                background-color: #ff3c00 !important;
                border: none !important;
                transition: all 0.3s ease !important;
            }

            .btn-primary:hover {
                background-color: #e63600 !important;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(255, 60, 0, 0.4) !important;
            }

            /* Global content override for normal weight and white color */
            .bradcam_area, .bradcam_area *,
            .user-content, .user-content *,
            .footer, .footer * {
                color: white !important;
                font-weight: normal !important;
            }

            /* Exceptions for white backgrounds */
            .bg-white, .bg-white * {
                color: #000000 !important;
            }

            /* Ensure header remains unaffected */
            .main-header-area * {
                font-weight: inherit;
                color: inherit;
            }

            /* Modal and Backdrop Z-Index Fix */
            .modal {
                z-index: 10050 !important;
            }
            .modal-backdrop {
                z-index: 10040 !important;
            }
        </style>
    </head>

    <body>
        @include('user.layouts.header')
        @include('user.layouts.bar')
        
        <div class="user-content container">
            @yield('content')
        </div>

        @include('user.layouts.footer')

        <!-- JS di sini -->
        <script src="{{ asset('assets/js/vendor/modernizr-3.5.0.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
        <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/ajax-form.js') }}"></script>
        <script src="{{ asset('assets/js/waypoints.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
        <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
        <script src="{{ asset('assets/js/scrollIt.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollUp.min.js') }}"></script>
        <script src="{{ asset('assets/js/wow.min.js') }}"></script>
        <script src="{{ asset('assets/js/gijgo.min.js') }}"></script>
        <script src="{{ asset('assets/js/nice-select.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slicknav.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('assets/js/tilt.jquery.js') }}"></script>
        <script src="{{ asset('assets/js/plugins.js') }}"></script>
        <script src="{{ asset('assets/js/main.js') }}"></script>
    </body>
</html>
