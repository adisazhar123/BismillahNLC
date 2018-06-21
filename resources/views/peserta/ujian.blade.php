
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
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'1'}}" value="A">
                    <label class="form-check-label" for="exampleRadios{{$i.'1'}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'2'}}" value="B">
                    <label class="form-check-label" for="exampleRadios{{$i.'2'}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'3'}}" value="C">
                    <label class="form-check-label" for="exampleRadios{{$i.'3'}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'4'}}" value="D">
                    <label class="form-check-label" for="exampleRadios{{$i.'4'}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadios{{$i.'5'}}" value="E">
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
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosa{{$i}}" value="A">
                    <label class="form-check-label" for="exampleRadiosa{{$i}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosb{{$i}}" value="B">
                    <label class="form-check-label" for="exampleRadiosb{{$i}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosc{{$i}}" value="C">
                    <label class="form-check-label" for="exampleRadiosc{{$i}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosd{{$i}}" value="D">
                    <label class="form-check-label" for="exampleRadiosd{{$i}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiose{{$i}}" value="E">
                    <label class="form-check-label" for="exampleRadiose{{$i}}">
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
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosa{{$i}}" value="A">
                    <label class="form-check-label" for="exampleRadiosa{{$i}}">
                      A
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosb{{$i}}" value="B">
                    <label class="form-check-label" for="exampleRadiosb{{$i}}">
                      B
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosc{{$i}}" value="C">
                    <label class="form-check-label" for="exampleRadiosc{{$i}}">
                      C
                    </label>
                  </div>

                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiosd{{$i}}" value="D">
                    <label class="form-check-label" for="exampleRadiosd{{$i}}">
                      D
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="no_{{$i}}" id="exampleRadiose{{$i}}" value="E">
                    <label class="form-check-label" for="exampleRadiose{{$i}}">
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
