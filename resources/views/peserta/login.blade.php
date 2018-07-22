@extends('layouts.app-peserta')

@section('style')
<style media="screen">
  #login_btn{
    width: 100%;
  }
</style>
@endsection

@section('content')
  <div class="container">
  <div class="row">
      <div class="col-md-8 mx-auto">
        <div class="login" style="">
          <div class="title mb-2">
            <h3><strong>Selamat Datang</strong></h3>
            <img src="{{asset('img/logo_b.png')}}" alt="" style="width: 160px">
          </div>
          <form class="form-horizontal" method="POST" action="{{ route('login') }}">
              {{ csrf_field() }}

              <div class="form-group row">

                  <div class="col-lg-6 offset-lg-3">
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

                      @if ($errors->has('email'))
                          <div class="invalid-feedback">
                              <strong>{{ $errors->first('email') }}</strong>
                          </div>
                      @endif
                  </div>
              </div>

              <div class="form-group row">

                  <div class="col-lg-6 offset-lg-3">
                      <input
                              id="password"
                              type="password"
                              class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                              name="password"
                              required
                              placeholder="password"
                      >

                      @if ($errors->has('password'))
                          <div class="invalid-feedback">
                              <strong>{{ $errors->first('password') }}</strong>
                          </div>
                      @endif
                  </div>
              </div>
              <div class="form-group row">
                  <div class="col-lg-6 offset-lg-3">
                      <button type="submit" class="btn btn-primary" id="login_btn">
                          Masuk
                      </button>


                  </div>

              </div>

          </form>
    </div>
  </div>
</div>
@endsection
