
  <div class="container">
      <div class="card packet-info">
        <div class="card-body">
          <div class="row">
            <div class="col-md-4">
              <h3>Jumlah pertanyaan yg terjawab: </h3>
            </div>
            <div class="col-md-3">
              <h3 id="clock">Sisa Waktu: </h3>
            </div>
            <div class="col-md-3">
              <a href="{{route('peserta.download.packet')}}" target="_blank" class="btn btn-primary" type="button" name="button">Unduh Paket Soal</a>
            </div>
          </div>
        </div>
      </div>

      <input type="hidden" name="id_team_packet" id="id_team_packet" value="{{$id_team_packet}}">
      <input type="hidden" name="deadline" id="deadline" value="{{$packet_info->active_date." ".$packet_info->end_time}}">
      <input type="hidden" name="time_now" id="time_now" value="{{$packet_info->active_date." ".$time_now}}">


      @if (isset($answers))
        <div class="card exam-answers">
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                @for ($i=1; $i <= 30; $i++)
                  <div class="row q_no_{{$i}}">
                    @if ($answers_stats[$i-1] == 'green')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #98fb98"><strong>{{$i}} </strong></h6>
                    @elseif($answers_stats[$i-1] == 'orange')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #ffc966"><strong>{{$i}} </strong></h6>
                    @else
                      <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @endif
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                        @if ($answers[$i-1] == $j)
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}" checked>
                          @else
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        @endif
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor

                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
              <div class="col-md-4">
                @for ($i=31; $i <= 60; $i++)
                  <div class="row q_no_{{$i}}">
                    @if ($answers_stats[$i-1] == 'green')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #98fb98"><strong>{{$i}} </strong></h6>
                    @elseif($answers_stats[$i-1] == 'orange')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #ffc966"><strong>{{$i}} </strong></h6>
                    @else
                      <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @endif
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                        @if ($answers[$i-1] == $j)
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}" checked>
                          @else
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        @endif
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor

                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
              <div class="col-md-4">
                @for ($i=61; $i <= 90; $i++)
                  <div class="row q_no_{{$i}}">
                    @if ($answers_stats[$i-1] == 'green')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #98fb98"><strong>{{$i}} </strong></h6>
                    @elseif($answers_stats[$i-1] == 'orange')
                      <h6 class="question_no" id="q_no_{{$i}}" style="background-color: #ffc966"><strong>{{$i}} </strong></h6>
                    @else
                      <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @endif
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                        @if ($answers[$i-1] == $j)
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}" checked>
                          @else
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        @endif
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor

                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
            </div>
          </div>
        </div>
      @else
        <div class="card exam-answers">
          <div class="card-body">
            <div class="row">

              <div class="col-md-4">
                @for ($i=1; $i <= 30; $i++)
                  <div class="row q_no_{{$i}}">
                    <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor
                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
              <div class="col-md-4">
                @for ($i=31; $i <= 60; $i++)
                  <div class="row q_no_{{$i}}">
                    <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor
                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
              <div class="col-md-4">
                @for ($i=61; $i <= 90; $i++)
                  <div class="row q_no_{{$i}}">
                    <h6 class="question_no" id="q_no_{{$i}}"><strong>{{$i}} </strong></h6>
                    @for ($j=1; $j<=5; $j++)
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.$j}}" value="{{$j}}">
                        <label class="form-check-label" for="exampleRadios{{$i.$j}}">
                          {{$ans_index[$j-1]}}
                        </label>
                      </div>
                    @endfor
                    <i name="no_{{$i}}" class="fa fa-refresh" aria-hidden="true" class="reset" data-toggle="tooltip" data-placement="top" title="Reset jawaban"></i>
                  </div>
                @endfor
              </div>
            </div>
          </div>
        </div>
      @endif


  </div>
  <br>
