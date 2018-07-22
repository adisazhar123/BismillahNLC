@extends('layouts.app-peserta')

@section('content')
  <br>
  <div class="row">
    <div class="col-lg-12">
      <div class="card text-white bg-info">
        <div class="card-body">
          <h3 class="text-dark">Pemilihan Kloter pengerjaan warmup</h3>
          <p>Pemilihan kloter akan berpengaruh pada .....</p>
            <form action="{{url('/peserta/pilih-kloter')}}" method="POST">
              <input type="hidden" name="_method" value="PUT">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
              <select class="custom-select custom-select-sm" name="kloter" required>
                <option value="{{ $pilihan_kloter['id_packet'] or '' }}">{{ $pilihan_kloter['id_packet'] or 'Pilih kloter' }}</option>
                <option value="1">1 (Satu)</option>
                <option value="2">2 (Dua)</option>
                <option value="3">3 (Tiga)</option>
                <option value="4">4 (Empat)</option>
              </select>
              <br><br>
              <button type="submit" class="float-right btn btn-primary">Submit</button>
            </form>
        <p class="text-warning">*Batas pemilihan/penggantian kloter sampai 22 September 2018 23:59</p>
        </div>
      </div>

      <div class="card text-white bg-warning">
        <div class="card-body">
          <h3 class="text-dark">Agenda selanjutnya</h3>
          <i class="fa fa-calendar"></i>&emsp;
              Warmup online 23 September 2018
              <i class="fa fa-calendar"></i>&emsp;
                  Babak penyisihan 30 September 2018
        </div>
      </div>
    </div>
  </div>

@endsection
