<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>NLC | National Logic Competition 2018</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/fontastic.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('css/grasp_mobile_progress_circle-1.0.0.min.css')}}">
  <link rel="stylesheet" href="{{asset('vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.default.css')}}" id="theme-stylesheet">
  <link rel="icon" href="{{ asset('img/logo.png') }}">
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
  <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css"/>

     @yield('style')

     <style media="screen">
      body {
        font-family: 'Noto Sans', sans-serif !important;
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
      .side-navbar.shrink{
        width: 93px;
      }
      .exam-answers{
        margin-top: 20px;
      }
      .exam-answers .card-body{
        padding-left: 100px;
      }
      .form-check{
        margin-right: 5px;
      }
      .form-check:hover{
        transform: scale(1.3);
      }
      .question_no{
        margin-right: 5px;
        text-align: center;
        height: 25px;
        width: 25px;
        border-radius: 4px;
        display: inline-block;
      }
      .fa-refresh{
        margin-top: 4px;
        margin-left: 3px;
      }
      .fa-refresh:hover{
        cursor: pointer;
        transform: scale(1.1);
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
                <span>Waktu Server</span><br>
                <span id="server_time"></span>
                </div>
                <div class="sidenav-header-logo">
                  <img class="brand-small" src="{{ asset('img/schematics.png') }}" style="height:unset">
                </div>
            </div>
            <div class="main-menu">
                @include('peserta.menu')
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
                                <div class="brand-text d-none d-md-inline-block">Dashboard Tim</div>
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
            <div class="container-fluid">
                @yield('content')
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
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>

    @yield('script')

    <script type="text/javascript">

    $(document).ready(function(){
      var time;
        $.ajax({
          url: '{{url('/peserta/server-time')}}',
          data: "string",
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

        function countTime(now) {
          if (now < 10) {
            now = '0' + now;
          }
          return now;
        }
        time3 = time3.getTime() + 1000;
      }
        setInterval(clock, 1000);
    });


    </script>

</body>

</html>
