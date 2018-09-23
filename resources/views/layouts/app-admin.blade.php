<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	@if (Auth::user()->role == 2)
		<title>NLC Komite</title>
	@else
		<title>NLC Admin</title>
	@endif
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
	<link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
	<link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
	<link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
	<link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
	<link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
	<link rel="icon" href="{{ asset('img/logo.png') }}">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/jquery.dataTables.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.2/css/responsive.dataTables.min.css">
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
	<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css"/>
	<link href="{{asset('js/jquery-easy-loading/dist/jquery.loading.css')}}" rel="stylesheet">

     @yield('style')

		 <style media="screen">
	 		.card-header .btn{
	 			 vertical-align: middle;
	 		}
		 	body {
			  font-family: 'Noto Sans', sans-serif !important;
			}
			.side-navbar.shrink{
				width: 93px;
			}
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
			nav.navbar a.menu-btn{
				margin-left: 20px;
			}
			@media only screen and (min-width: 1200px) {
					footer.main-footer p {
						margin-left: 15px;
				}
			}
				@media only screen and (max-width: 1200px) {
					nav.navbar a.menu-btn{
						margin-left: 0px;
					}
					footer.main-footer p {
						margin-left: 0;
				}
			}

			div.page.active .container-fluid.content{
				padding-left: 30px;
			}

			@keyframes fadein {
			    from {
			        opacity:0;
			    }
			    to {
			        opacity:1;
			    }
			}
			@-moz-keyframes fadein { /* Firefox */
			    from {
			        opacity:0;
			    }
			    to {
			        opacity:1;
			    }
			}
			@-webkit-keyframes fadein { /* Safari and Chrome */
			    from {
			        opacity:0;
			    }
			    to {
			        opacity:1;
			    }
			}
			@-o-keyframes fadein { /* Opera */
			    from {
			        opacity:0;
			    }
			    to {
			        opacity: 1;
			    }
			}

			.container-fluid.content{
				animation: fadein 1.5s;
				-moz-animation: fadein 1.5s; /* Firefox */
				-webkit-animation: fadein 1.5s; /* Safari and Chrome */
				-o-animation: fadein 1.5s; /* Opera */
			}

		 </style>

</head>

<body>
    <nav class="side-navbar">
        <div class="side-navbar-wrapper">
            <div class="sidenav-header d-flex align-items-center justify-content-center">
                <div class="sidenav-header-inner text-center">
								<img src="{{ asset('img/schematics.png') }}" class="img-fluid" style="height:unset">
                <h2 class="h5">{{Auth::user()->name}}</h2>
								@if (Auth::user()->role==1)
									<span>Web Master</span>
								@else
									<span>Komite</span>
								@endif
								<br>
								<span id="server_time"></span>
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
        <header class="header">
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="navbar-holder d-flex align-items-center justify-content-between">
                        <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="icon-bars"> </i></a>
                            <a href="#" class="navbar-brand">
                                <div class="brand-text d-none d-md-inline-block">NLC Administration</div>
                            </a>
                        </div>
                        <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                            <!-- Log out-->
                            <li class="nav-item">
                                <a href="{{ route('logout') }}"
																	 onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link logout"> <span class="d-none d-sm-inline-block">Logout</span><i class="fa fa-sign-out"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <section>
            <div class="container-fluid content">
                @yield('main')
            </div>
        </section>
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <p>&copy; Schematics 2018</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

		<form id="logout-form" action="{{ route('logout') }}" method="POST"
					style="display: none;">
				{{ csrf_field() }}
		</form>

    <!-- JavaScript files-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/popper.js/umd/popper.min.js')}}">
    </script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('js/front.js')}}"></script>


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.2/js/dataTables.responsive.js"></script>

		<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

		<script src="{{asset('js/jquery-easy-loading/dist/jquery.loading.min.js')}}"></script>

		@yield('script')

		<script type="text/javascript">
		$(document).ready(function(){
			var time, time3;

			var isMobile = false; //initiate as false
		// device detection
			if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
			    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
			    isMobile = true;
			}

			if (isMobile) {
				alert("Anda terdeteksi menggunakan HP. Diharapkan untuk mengerjakan ujian menggunakan laptop atau komputer agar User Experience tidak terganggu!")
			}

        $.ajax({
          url: '{{url('/admin/server-time')}}',
          data: "string",
					async: true,
					start_time: new Date().getTime(),
          success: function(data){
						ajax_duration = new Date().getTime() - this.start_time;
            time = new Date(data);
            time3 = time.getTime() + ajax_duration;
          }
        });

				function clock() {
					time3 = new Date(time3);

					var hours = time3.getHours(),
					minutes = time3.getMinutes(),
					seconds = time3.getSeconds();

					$("#server_time").text(countTime(hours) + ":" + countTime(minutes) + ":" + countTime(seconds));
					time3 = time3.getTime() + 1000;

					function countTime(now) {
						if (now < 10) {
							now = '0' + now;
						}
						return now;
					}
				}
				setInterval(clock, 1000);
		});


		</script>

</body>

</html>
