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

<!--Load partial views-->
<script type="text/javascript">
$(document).ready(function(){
  $(".main-content").load('{{route('peserta.welcome')}}', function(){});

  $(document).on('click', '.show-tes', function(){
    $(".main-content").hide().load('{{route('team.exam')}}').fadeIn(1000);
  });

  $(document).on('click', '.show-petunjuk', function(){
    $(".main-content").hide().load('{{route('peserta.petunjuk')}}').fadeIn(1000);

  })
})
</script>

<!-- Ajax function to submit ans -->
<script type="text/javascript">
$(document).on('click',".form-check-input", function(){
  var name = $(this).attr('name');
  var value = $(this).val();
  var status = "green";
  $("#q_"+name).css('background-color', "#98fb98");

  console.log(name);
  console.log(value);


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });


  $.ajax({
    url: '{{route('peserta.submit.ans')}}',
    method: 'post',
    data: {value: value, status: status},
    success: function(data){
      console.log(data)
    }
  })


})

$(document).on("click", ".question_no", function(){
  $(this).css('background-color', "#ffc966");

  var status = "orange";

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '{{route('peserta.submit.ans.stat')}}',
    method: 'post',
    data: {status: status},
    success: function(data){
      console.log(data)
    }
  })
})

$(document).on("click", ".fa-refresh", function(){
  var name = $(this).attr('name');
  $(".row.q_"+name+" input[type='radio']").prop('checked', false)
  $("#q_"+name).css('background-color', 'white')
})
</script>
@endsection
