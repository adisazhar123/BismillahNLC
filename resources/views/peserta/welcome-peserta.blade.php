        <?php
        $warmup     =   Carbon\Carbon::createFromFormat('Y-m-d H-i-s', '2018-09-22 23-59-59')->toDateTimeString();
        $penyisihan =   Carbon\Carbon::createFromFormat('Y-m-d H-i-s', '2018-09-29 23-59-59')->toDateTimeString();
        ?>
        
        <div class="card">
          <div class="card-body">
            <h3>Selamat datang {{$team_name}} pada NLC Online 2018</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            @if ($exam == 1)
              <p>Tidak ada ujian untuk anda.</p>
              {{-- <button type="button" class="btn btn-nlc show-petunjuk" name="button">Selanjutnya</button> --}}

            @elseif ($exam == 2)
              {{-- melanjutkan ujian yang udh di-assign, mungkin pernah logout/ close browser --}}
              <p><strong>Mulai mengerjakan ujian.</strong></p>
              <button type="button" class="btn btn-nlc show-tes" name="button">Lanjutkan ujian</button>

            @elseif ($exam == 3)
              <p>Mohon untuk menunggu sebentar. Ujian belum mulai.<br>Ujian dimulai pukul {{$start_time}}</p>
            @else
              {{-- gak ada ujian --}}
              <p>Tidak ada ujian untuk hari ini.</p>
            @endif
          </div>
        </div>
        
      @if($server_time<$warmup)
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
                  <option value="3">4 (Empat)</option>
                </select>
                <br><br>
                <button type="submit" class="float-right btn btn-primary">Submit</button>
              </form>
          <p class="text-warning">*Batas pemilihan/penggantian kloter sampai 22 September 2018 23:59</p>
          </div>
        </div>
      @endif

        <div class="card text-white bg-warning">
          <div class="card-body">
            <h3 class="text-dark">Agenda selanjutnya</h3>
            <i class="fa fa-calendar"></i>&emsp;
              @if($server_time<$warmup)
                Warmup online 23 September 2018
              @elseif($server_time >= $warmup and $server_time < $penyisihan)
                Babak penyisihan 30 September 2018
              @else
                -
              @endif
          </div>
        </div>

@section('script')
  <script type="text/javascript">
    $(document).ready( function () {

      @if (session()->has('message'))
        alertify.success('{{session()->get('message')}}')
      @endif
      $("#menu-settings").addClass('active');

  });

  </script>
@endsection
