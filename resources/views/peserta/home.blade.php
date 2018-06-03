@extends('layouts.app-peserta')

@section('style')

@endsection

@section('content')
  @section('navbar')
    @include('inc.navbar-peserta')
  @endsection
  <div class="main-content">

  </div>
@endsection

@section('script')
<script type="text/javascript">
  $(".main-content").load('{{route('show.petunjuk')}}', function(){})
</script>
@endsection
