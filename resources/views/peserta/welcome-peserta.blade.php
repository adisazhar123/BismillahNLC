<div class="area-welcome">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <h3>Selamat datang {{$team_name}} pada NLC Online 2018</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            @if ($exam == 1)
              <p>Tidak ada ujian untuk anda.</p>
              {{-- <button type="button" class="btn btn-nlc show-petunjuk" name="button">Selanjutnya</button> --}}

            @elseif ($exam == 2)
              {{-- melanjutkan ujian yang udh di-assign, mungkin pernaj logout/ close browser --}}
              <p><strong>Mulai mengerjakan ujian.<strong></p>
              <button type="button" class="btn btn-nlc show-tes" name="button">Lanjutkan ujian</button>

            @elseif ($exam == 3)
              <p>Mohon untuk menunggu sebentar. Ujian belum mulai.<br>Ujian dimulai pukul {{$start_time}}</p>
            @else
              {{-- gak ada ujian --}}
              <p>Tidak ada ujian untuk hari ini.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
