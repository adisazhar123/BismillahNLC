<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/peserta.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @yield('style')
</head>
<style media="screen">
  body{
    background: url("{{asset('img/bg_nlc.jpg')}}") no-repeat center center fixed;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;
    background-size: cover;
    background-size: 100% 100%;
  }
  .collapse.navbar-collapse.navbar-alt .navbar-nav a:hover{
    background-color: #ffac35;
    color: white;
  }
  .navbar.navbar-expand-lg.navbar-dark.bg-dark a{
    color:white;
  }
  .navbar{
    border-bottom: solid;
    border-bottom-color: white;
  }

  .content{
    margin-top: 50px;
  }

  .packet-info{
    margin-top: 30px;
  }

  .exam-answers{
    margin-top: 20px;
  }
  .exam-answers .card-body{
    padding: 30px;
  }
  .form-check{
    margin-right: 5px;

  }

  .form-check:hover{
    transform: scale(1.3);
  }

  .form-check-label{
    margin-left: -6px;
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

<body>
<div id="app">
  @yield('navbar')
  <div class="content">
    @yield('content')
  </div>
</div>

<!-- Scripts -->
<script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
@yield('script')

<script type="text/javascript">


</script>
</body>
</html>
