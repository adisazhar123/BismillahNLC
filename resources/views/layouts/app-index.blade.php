<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selamat Datang | NLC Online 2018</title>
    <link rel="stylesheet" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/font-awesome/css/font-awesome.min.css')}}">
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/linearicons.css')}}">
    <link rel="stylesheet" href="{{asset('css/peserta.css')}}">
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/css/themes/default.min.css"/>
    <link rel="icon" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{asset('css/animate.css')}}">

    @yield('style')

    <style media="screen">
      html,
      body {
        height: 100%;
        width: 100%;
        overflow-x: hidden;
        background-image: linear-gradient(#282828, #000);
        font-family: 'Noto Sans', sans-serif !important;
      }
      .mesh {
        background-image: url('img/mesh_schem.png');
        opacity: 0.3;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: 240px -480px;
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        right: 0;
        width: 900px;
        height: 480px;
        animation: shake2 13s;
        animation-iteration-count: infinite;
      }

      .ok{
        position: relative;
      }
      .mesh2 {
        background-image: url('img/mesh_schem.png');
        opacity: 0.3;
        background-size: cover;
        background-repeat: no-repeat;
        width: 100%;
        height: 100%;
        position: absolute;
        bottom: 0;
        left: -220px;
        width: 900px;
        height: 400px;
        animation: shake2 20s;
        animation-iteration-count: infinite;
        z-index: 1;
      }
        .btn-nlc{
          background: linear-gradient(to right, #efc94c, #f5a503);
        }
        .btn-nlc:hover{
          box-shadow: inset 0 70px 0 0 #00000052;
        }
        .logo img {
          height: 50px;
          opacity: 0.8;
        }
        .logo:hover img {
          opacity: 1;
        }
        .content{
          margin-top: 80px;
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
<div id="app">
  <div class="mesh">
  </div>
  <div class="content">
    <div class="oz-body-wrap">
      <header class="default-header">
        <div class="container-fluid">
          <div class="header-wrap">
            <div class="header-top d-flex justify-content-between align-items-center">
              <div class="logo">
                <a href="{{url('/')}}"><img src="{{asset('img/logo_schem.png')}}" alt=""></a>
              </div>
              <div class="main-menubar d-flex align-items-center">
                <nav class="hide">
                  <a href="{{url('/')}}">Home</a>
                  @if (!Auth::guest())
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    Keluar</a>

                  @endif
                </nav>

                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    {{ csrf_field() }}
                </form>

                <div class="menu-bar"><span class="lnr lnr-menu"></span></div>
              </div>
            </div>
          </div>
        </div>
      </header>


    </div>
    @yield('content')
  </div>
  <div class="ok">
    <div class="mesh2">
    </div>
  </div>

</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="{{asset('js/main.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.1/build/alertify.min.js"></script>
@yield('script')

</body>
</html>
