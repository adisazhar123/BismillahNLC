@extends('layouts.app-peserta')

@section('style')
 <style>
   .field-icon {
      float: right;
      margin-right: 10px;
      margin-top: -27px;
      position: relative;
      z-index: 2;
    }
 </style>
@endsection

@section('content')

<br>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Penggantian Password User</h4>
        <small>Gantilah password untuk keamanan akun anda!</small>
      </div>
      <div class="card-body">
        <form action="{{url('/peserta/change-password-user')}}" method="POST">
          <input type="hidden" name="_method" value="PUT">

          {{ csrf_field() }}
          <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
          <div class="form-group">
           <label for="name">Nama tim</label>
           <input type="text" class="form-control" placeholder="Enter nama" name="user_name" value="{{Auth::user()->name}}" disabled readonly>
         </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email tim</label>
            <input type="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter email" name="user_email" value="{{Auth::user()->email}}" disabled readonly>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password baru</label>
            <input type="password" class="form-control" id="password-field" placeholder="Password baru" name="new_password" required><span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Tulis ulang password baru</label>
            <input type="password" class="form-control" id="password-field-retype" placeholder="Tulis ulang password baru" name="new_password_retype" required><span toggle="#password-field-retype" class="fa fa-fw fa-eye field-icon toggle-password"></span>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
  <script type="text/javascript">
    $(document).ready( function () {

      @if (session()->has('message'))
        alertify.success('{{session()->get('message')}}')
      @endif
      @if (session()->has('error'))
        alertify.error('{{session()->get('error')}}')
      @endif

      $("#menu-settings").addClass('active');
  });

    $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
@endsection
