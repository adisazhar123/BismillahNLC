<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NLC Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
    <!-- Google fonts - Roboto -->
    <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Roboto:300,400,500,700')}}">
    <!-- jQuery Circle-->
    <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
    <!-- Custom Scrollbar-->
    <link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <!-- Favicon-->
	   <link rel="icon" href="{{ asset('img/logo.png') }}">

     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.css">
		 <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css">

		 <!-- CSS -->
		 <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
		 <!-- Default theme -->
		 <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css"/>

     @yield('style')

		 <style media="screen">
		 	.ans-list{
  			list-style-type: none;
			}
			.card:hover{
 				box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
 		    -webkit-transition:  box-shadow .2s ease-in;
		  }
			.disabled {
		    pointer-events: none;
		    opacity: 0.3;
			}
		 </style>

</head>

<body>
    <nav class="side-navbar">
        <div class="side-navbar-wrapper">
            <div class="sidenav-header d-flex align-items-center justify-content-center">
                <div class="sidenav-header-inner text-center">
					<img src="{{ asset('img/schematics.png') }}" class="img-fluid" style="height:unset">
                    <h2 class="h5">Adis Azhar</h2>
					<span>Web Master</span>
                </div>
                <div class="sidenav-header-logo">
                    <img class="brand-small" src="{{ asset('img/schematics.png') }}" style="height:unset">
                </div>
            </div>
            <div class="main-menu">
                @include('admin.menu')
            </div>
        </div>
    </nav>
    <div class="page">
        <!-- navbar-->
        <header class="header">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a>
                            <a href="index.html" class="navbar-brand">
                                <div class="brand-text d-none d-md-inline-block">NLC Administration</div>
                            </a>
                        </div>
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                            <!-- Log out-->
                            <li class="nav-item">
                                <a href="#" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section>
            <div class="container-fluid">
                @yield('main')
            </div>
        </section>
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>Schematics ITS 2018</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/popper.js/umd/popper.min.js')}}">
    </script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/grasp_mobile_progress_circle-1.0.0.min.js')}}"></script>
    <script src="{{asset('vendor/jquery.cookie/jquery.cookie.js')}}">
    </script>
    <script src="{{asset('vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <!-- Main File-->
    <script src="{{asset('js/front.js')}}"></script>


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.js"></script>

		<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

		@yield('script')

</body>

</html>
