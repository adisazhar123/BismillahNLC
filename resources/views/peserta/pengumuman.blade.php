@extends('layouts.app-peserta')

@section('style')
  <style media="screen">
    .border{
      border-color: rgba(0,0,0,0.1) !important;
      border-radius: 5px;
      padding: 10px;
    }

    .bg-announcement{
      background-color: #fff89b;
    }

    .card-body{
      color: black;
    }
  </style>
@endsection

@section('content')
  <br>
  <div class="row">
    <div class="col-lg-12">
      <div class="card bg-info">
        <div class="card-body bg-announcement">
            <h3 class="">                <i class="fa fa-calendar mb-1"></i> Pengumuman</h3>
            @if ($announcements->isEmpty())
              Tidak ada pengumuman.
            @else
              @foreach ($announcements as $a)
                <div class="border mb-1">
                {!! $a->content !!}
                <small><i>{{ date_format($a->created_at, 'd/m/Y')}}</i></small>
              </div>
              @endforeach
            @endif

          </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h3 class="text-dark">Pemilihan Kloter Pengerjaan Warmup/ Latihan</h3>
            <form action="{{url('/peserta/pilih-kloter')}}" method="POST">
              <input type="hidden" name="_method" value="PUT">
              {{ csrf_field() }}
              <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
              <select class="custom-select custom-select-sm" name="kloter" required>
                <option value="{{ $pilihan_kloter['id_packet'] or '' }}">

                  @if ($pilihan_kloter)
                    Kloter: {{$pilihan_kloter->packets['name']}} - Jam {{$pilihan_kloter->packets['start_time']}},
                    {{$pilihan_kloter->packets['active_date']}}
                  @else
                    Pilih Kloter
                  @endif

                </option>
                @if (empty($pilihan_kloter))
                  @php
                    $i=1;
                  @endphp
                  @foreach ($packets as $p)
                    @if ($p->capacity <= $p->current_capacity)
                      <option disabled value="{{$p->id_packet}}">Kloter: {{$i}} - Jam {{$p->start_time.", ".date_format(new DateTime($p->active_date), 'd-m-Y')}}</option>
                    @else
                      <option value="{{$p->id_packet}}">Kloter: {{$i}} - Jam {{$p->start_time.", ".date_format(new DateTime($p->active_date), 'd-m-Y')}}</option>
                    @endif
                    @php
                      $i++;
                    @endphp
                  @endforeach
                @endif

              </select>
              <br><br>
              @if (empty($pilihan_kloter))
                <button type="submit" class="float-right btn btn-primary">Submit</button>
                @else
                  <button type="submit" class="float-right btn btn-primary" disabled>Submit</button>

              @endif
            </form>
        <p class="">*Penutupan pemilihan kloter akan melalui pengumuman.</p>
        </div>
      </div>


    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript">
$("#menu-announcement").addClass('active')

</script>
@endsection
