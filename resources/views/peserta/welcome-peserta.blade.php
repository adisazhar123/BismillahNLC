@section('style')

@endsection
  <div class="card">
    <div class="card-body">
      <h3>Selamat datang <strong>{{$team_name}}</strong> di NLC Online 2018</h3>
      @if (isset($packet_info) && $exam == 3 || $exam == 2)
        <div class="packet-info">
          <h5>
            Nama paket: {{$packet_info->name}}<br>
            Waktu mulai: {{$packet_info->start_time}} WIB<br>
            Waktu selesai: {{$packet_info->end_time}} WIB
          </h5>
        </div>
      @endif
      <p class="h4">
        Berikut adalah informasi penting yang harus anda ketahui sebagai peserta NLC Online 2018:
        <ol>
          <li>Setiap tim hanya bisa login di satu device.</li>
          <li>Diharuskan untuk mengikuti ujian menggunakan laptop atau komputer.</li>
          <li>Ujian masih bisa dilanjutkan bila keluar dari browser.</li>
          <li>Akun yang tidak aktif selama lebih dari 15 menit akan ter-logout secara otomatis.
            Anda bisa login kembali untuk melanjutkan ujian.</li>
          <li>Jika anda sudah selesai mengerjakan sebelum waktu berakhir, harap pencet <strong>submit</strong>
          agar jawaban tersimpan!</li>
          <li>Jika waktu sudah habis ketika anda sedang mengerjakan, maka sistem akan nge-submit jawaban
          anda secara otomatis. Peserta yang keluar dari halaman ujian dan tidak <strong>submit</strong>, maka
          jawaban tidak tersimpan alias nilai NOL.</li>
          <li>Zona waktu yang digunakan pada sistem NLC Online 2018 adalah Waktu Indonesia Barat.</li>
          <li>Informasi dan peraturan yang tidak tercantum disini berpatokan pada Rule Book NLC 2018.</li>
          <li>Dengan mengikuti ujian NLC Online 2018 anda wajib mematuhi seluruh peraturan yang ada.
          Tim yang melanggar akan mendapatkan sanksi.</li>
        </ol>


      </p>



      @if ($exam == 1)
        <p><strong>Tidak ada ujian untuk anda.</strong></p>
        {{-- <button type="button" class="btn btn-nlc show-petunjuk" name="button">Selanjutnya</button> --}}

      @elseif ($exam == 2)
        {{-- melanjutkan ujian yang udh di-assign, mungkin pernah logout/ close browser --}}
        <p><strong>Mulai mengerjakan ujian.</strong></p>
        <button type="button" class="btn btn-success show-tes" name="button">Lanjutkan ujian</button>

      @elseif ($exam == 3)
        <p><strong>Mohon untuk menunggu sebentar. Ujian belum mulai.<br>Ujian dimulai pukul {{$start_time}} WIB.</strong></p>
      @else
        {{-- gak ada ujian --}}
        <p><strong>Tidak ada ujian untuk hari ini.</strong></p>
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
