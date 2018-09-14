@extends('layouts.app-peserta')

@section('style')

@endsection

@section('content')
  <br>
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3>Nilai Ujian Peserta</h3>
          <small>Berikut adalah nilai ujian warm-up</small>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="table_id" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Paket</th>
                        <th>Tanggal Ujian</th>
                        <th>Nilai Ujian</th>
                    </tr>
                </thead>
                <tbody>
                  @if (!$team_packets->count())
                    <tr>
                      <td>
                        Nilai belum keluar

                      </td>
                      <td></td><td></td>
                    </tr>
                  @else
                    @foreach ($team_packets as $tp)
                      <tr>
                        <td>{{$tp->packets['name']}}</td>
                        <td>{{$tp->packets['active_date']}}</td>
                        <td>{{$tp->final_score}}</td>
                      </tr>
                    @endforeach
                  @endif
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
<script type="text/javascript">
  $("#menu-score").addClass('active');
</script>
@endsection
