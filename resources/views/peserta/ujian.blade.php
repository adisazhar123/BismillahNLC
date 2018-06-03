@extends('layouts.app-peserta')

@section('style')
  <style media="screen">
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
@endsection

@section('content')

  @section('navbar')
    @include('inc.navbar-peserta')
  @endsection
  <div class="container">
      <div class="card packet-info">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <h3>Jumlah pertanyaan yg terjawab: </h3>
            </div>
            <div class="col-md-3">
              <h3>Sisa Waktu: </h3>
            </div>
            <div class="col-md-3">
              <button class="btn btn-primary" type="button" name="button">Unduh Paket Soal</button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <h3>Contoh</h3>

            </div>
          </div>
        </div>
      </div>

      <div class="card exam-answers">
        <div class="card-body">
          <div class="row">

            <div class="col-md-4">
              @for ($i=1; $i <= 30; $i++)
                <div class="row q_no_{{$i}}">
                  <h5 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h5>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'1'}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i.'1'}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'2'}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i.'2'}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'3'}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i.'3'}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'4'}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i.'4'}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'5'}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i.'5'}}">
                      E
                    </label>
                  </div>
                  <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                </div>
              @endfor
            </div>
            <div class="col-md-4">
              @for ($i=31; $i <= 60; $i++)
                <div class="row q_no_{{$i}}">
                  <h5 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h5>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      E
                    </label>
                  </div>
                  <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                </div>
              @endfor
            </div>
            <div class="col-md-4">
              @for ($i=61; $i <= 90; $i++)
                <div class="row q_no_{{$i}}">
                  <h5 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h5>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i}}" value="option1">
                    <label class="form-check-label" for="exampleRadios{{$i}}">
                      E
                    </label>
                  </div>
                  <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                </div>
              @endfor
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection

@section('script')
  <script type="text/javascript">
    $(".form-check-input").click(function(){
      var name = $(this).attr('name');
      alert(name)
      $("#q_"+name).css('background-color', "#98fb98")
    })

    $(".question_no").click(function(){
      $(this).css('background-color', "#ffc966");
    })

    $(".fa-refresh").click(function(){
      var name = $(this).attr('name');
      $(".row.q_"+name+" input[type='radio']").prop('checked', false)
      $("#q_"+name).css('background-color', 'white')
    })

  </script>
@endsection
