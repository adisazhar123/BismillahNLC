@extends('layouts.app-index')

@section('style')
  <style media="screen">


		.welcome-banner {
			height: 100%;
			justify-content: center;
			text-align: center;
			margin-left: auto;
			margin-right: auto;
			margin-top: 90px;
		}

		#mascot {
			width: 250px;
			opacity: 0.8;
		}

		.login {
			margin-top: 0px;
			text-align: center;
			justify-content: center;
			opacity: 0.8;
			pointer-events: auto;
		}

		.parent-login:hover img,
		.parent-login:hover .login {
			animation: shake 5.8s;
			animation-iteration-count: infinite;
			opacity: 1 !important;
			cursor: pointer;
		}



		@keyframes shake {
			0% {
				transform: translate(1px, 1px) rotate(0deg);
			}
			10% {
				transform: translate(-1px, -2px) rotate(-1deg);
			}
			20% {
				transform: translate(-3px, 0px) rotate(1deg);
			}
			30% {
				transform: translate(3px, 2px) rotate(0deg);
			}
			40% {
				transform: translate(1px, -1px) rotate(1deg);
			}
			50% {
				transform: translate(-1px, 2px) rotate(-1deg);
			}
			60% {
				transform: translate(-3px, 1px) rotate(0deg);
			}
			70% {
				transform: translate(3px, 1px) rotate(-1deg);
			}
			80% {
				transform: translate(-1px, -1px) rotate(1deg);
			}
			90% {
				transform: translate(1px, 2px) rotate(0deg);
			}
			100% {
				transform: translate(1px, -2px) rotate(-1deg);
			}
		}

		@keyframes shake2 {
			0% {
				transform: scale(1.2) rotate(0deg);
			}
			10% {
				transform: scale(1.0) rotate(-0.1deg);
			}
			20% {
				transform: scale(1.2) rotate(0.1deg);
			}
			30% {
				transform: scale(1.0) rotate(0deg);
			}
			40% {
				transform: scale(1.2) rotate(0.1deg);
			}
			50% {
				transform: scale(1.0) rotate(-0.1deg);
			}
			60% {
				transform: scale(1.2) rotate(0deg);
			}
			70% {
				transform: scale(1.0) rotate(-0.1deg);
			}
			80% {
				transform: scale(1.2) rotate(0.1deg);
			}
			90% {
				transform: scale(1.0) rotate(0deg);
			}
			100% {
				transform: scale(1.2) rotate(-0.1deg);
			}
		}

		.title {

			font-size: 50px;
			font-weight: bold;
			background: url(img/bg_nlc.jpg);
			-webkit-background-clip: text;
			-webkit-text-fill-color: transparent;
		}



		header {
			pointer-events: auto;
		}

    .ok{
      pointer-events: none;
    }

		@media only screen and (max-width: 500px) {
		    .title{
		        font-size: 36px;
		    }
        .welcome-banner {
          margin-top: 100px;
        }
		}

    @media only screen and (max-width: 768px) {
        .welcome-banner {
          margin-top: 10px;
        }
    }

    .login-modal{
      margin-top: 130px;
    }

    .modal-content{
      background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-header{
      border-bottom: none;
    }
    .modal-footer{
      border-top: none;
    }


  #container {
     min-height:100%;
     position:relative;
  }

  #body {
     padding-bottom:20rem;
  }
  #footer {
    position:absolute;
    width:100%;
    background:white;
    text-align: center;
    padding-top: 1rem;
    padding-bottom: 1rem;
    z-index: 10;
  }

  .sponsor1child{
    height: 5rem;
    margin-top: 0.35rem;
    margin-bottom: 0.35rem;
  }

  .sponsor2child{
    height: 3rem;
    margin-top: 0.25rem;
    margin-bottom: 0.25rem;
  }

  .sponsor3child{
    height: 2rem;
    margin-top: 0.15rem;
    margin-bottom: 0.15rem;
  }

  .go, .masuk{
    z-index: 9999999999;
  }

  body{
    pointer-events: auto;
  }

  *{
    -webkit-overflow-scrolling: touch;
  }


	</style>

  <style media="screen">
  .login-form button{
    width: 100%;
  }
  </style>
@endsection

@section('content')


  <div class="row">
		<div class="container">
			<div class="welcome-banner">
				<h1 class="text-uppercase text-white title">National Logic Competition <br> Online 2018</h1>
				<div class="parent-login">
					<img src="img/mascot_nlc.png" alt="asd" id="mascot">
					<div class="login">
            @if (Auth::user())
              @if (Auth::user()->role == 3)
                <a href="{{url('/peserta/home')}}" class="genric-btn primary circle arrow masuk" style="text-decoration: none">Masuk<span class="lnr lnr-arrow-right"></span></a>
              @elseif (Auth::user()->role < 3)
                <a href="{{url('/admin')}}" class="genric-btn primary circle arrow masuk" style="text-decoration: none">Masuk<span class="lnr lnr-arrow-right"></span></a>
              @endif
            @else
              <a href="#" class="genric-btn primary circle arrow go" style="text-decoration: none">Masuk<span class="lnr lnr-arrow-right"></span></a>
            @endif
					</div>
				</div>
			</div>
		</div>
	</div>

  <div class="container">

  </div>

  <div id="container">
     <div id="header"></div>
     <div id="body"></div>
     <div id="footer">
       <div class="container">
         <div class="sponsor1">
           <img src="https://schematics.its.ac.id/img/sponsor/bukalapak.png" class="sponsor1child">
           <img src="https://schematics.its.ac.id/img/sponsor/packetsystem.jpg" class="sponsor1child">
           <img src="https://schematics.its.ac.id/img/sponsor/global.png" class="sponsor1child">
           <img src="https://schematics.its.ac.id/img/sponsor/telkomsigma.png" class="sponsor1child">
         </div>
         <div class="sponsor2">
           <img src="https://schematics.its.ac.id/img/sponsor/dwimitra logo.png" class="sponsor2child">
           <img src="https://schematics.its.ac.id/img/sponsor/laplasindo.gif" class="sponsor2child">
           <img src="https://schematics.its.ac.id/img/sponsor/fujitsu.png" class="sponsor2child">
           <img src="https://schematics.its.ac.id/img/sponsor/xva.png" class="sponsor2child">
         </div>
         <div class="sponsor3">
           <a href="https://idcloudhost.com/" target="_blank">
               <img src="https://schematics.its.ac.id/img/sponsor/logo_idcloudhost.png" class="sponsor3child">
           </a>
           <img src="https://schematics.its.ac.id/img/sponsor/duprint.jpg" class="sponsor3child">
           <img src="https://schematics.its.ac.id/img/sponsor/nurul.png" class="sponsor3child">
       </div>
       </div>
     </div>
  </div>



  <div class="login-modal modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color: white">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:white">
         <span aria-hidden="true">&times;</span>
       </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="login-form" style="">
                <form class="form-horizontal" action="#">
                    {{ csrf_field() }}

                    <div class="form-group row">

                        <div class="col-lg-12 offset-lg-0">
                            <input
                                    id="email"
                                    type="email"
                                    class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus
                                    placeholder="email address"
                            >


                        </div>
                    </div>

                    <div class="form-group row">

                        <div class="col-lg-12 offset-lg-0">
                            <input
                                    id="password"
                                    type="password"
                                    class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                    name="password"
                                    required
                                    placeholder="password"
                            >

                            @if ($errors->has('password'))

                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12 offset-lg-0">
                            <button type="submit" class="genric-btn primary circle" id="login_btn">
                              Go
                            </button>
                          </div>
                    </div>
                  </form>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $(".go").click(function(){
      $(".modal").modal('show');
    });
    $("#mascot").click(function(){
      $(".modal").modal('show');
    });
  });

  $("form").submit(function(e){
    e.preventDefault();
    data = $(this).serialize();
    $("#login_btn").html('<i class="fa fa-spinner fa-spin"></i>');
    $("#login_btn").prop('disabled', true);
    $.ajax({
      method: "POST",
      url: '{{ route('login') }}',
      data: data,
      success: function(data){
        $(".modal").modal('hide');
        alertify.success("Login berhasil :)");
        window.setTimeout(function(){
          window.location = "{{url('/')}}"+data.intended_url;
        }, 1500);
        $("#login_btn").html("Go");
        $("#login_btn").prop('disabled', false);
      },
      error: function(data){
        alertify.error("Akun tidak dikenal :(");
        $("#login_btn").html("Go");
        $("#login_btn").prop('disabled', false);
      }
    });

  });


</script>
@endsection
