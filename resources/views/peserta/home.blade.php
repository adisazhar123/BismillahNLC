@extends('layouts.app-peserta')

@section('style')
<style media="screen">




</style>
@endsection

@section('content')

<br>

<div class="row my_page animated fadeIn">
  <div class="col-lg-12">
    <div class="main-content">
    </div>
  </div>
</div>


@endsection

@section('script')

<!--Load partial views-->
<script type="text/javascript">
$(document).ready(function(){
  $(".main-content").load('{{route('peserta.welcome')}}', function(response, status, xhr){
    if (typeof response.intended_url !== 'undefined') {
      window.location= '{{route('index')}}';
    }
  });

  $("#menu-home").addClass('active')

  $(document).on('click', '.show-tes', function(){

    $.ajax({
      url: '{{route('team.exam')}}',
      start_ajax_time: new Date().getTime(),
      success: function(response, status, xhr){
        $(".main-content").hide().html(response).fadeIn();
        if (typeof response.intended_url !== 'undefined') {
          window.location= '{{route('index')}}';
        }
        if (status != "error") {
          if ($("#deadline").val() != null && $("#time_now")) {
            startTimer((new Date().getTime() - this.start_ajax_time));
          }
        }
      }
    });
  });

  $(document).on('click', '.show-petunjuk', function(){
    $(".main-content").hide().load('{{route('peserta.petunjuk')}}', function(response, status, xhr){
      if (typeof response.intended_url !== 'undefined') {
        window.location= '{{route('index')}}';
      }
    }).fadeIn(1000);
  });

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

});

  function rgb2hex(orig){
   var rgb = orig.replace(/\s/g,'').match(/^rgba?\((\d+),(\d+),(\d+)/i);
   return (rgb && rgb.length === 4) ? "#" +
    ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
    ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : orig;
  }

// <!-- Ajax function to submit ans -->
$(document).on('click',".form-check-input", function(){
  var name = $(this).attr('name');
  var q_index = name.slice(3);
  var value = $(this).val();
  var status = "green";
  id_team_packet = $("#id_team_packet").val();
  id_packet = $("#id_packet").val();

  $("#q_"+name).css('background-color', "#98fb98");

  $.ajax({
    url: '{{route('peserta.submit.ans')}}',
    method: 'put',
    data: {value, q_index, id_team_packet, id_packet},
    success: function(data){
      if (typeof data.intended_url !== 'undefined') {
        window.location= '{{route('index')}}';
      }
    }
  })


})

$(document).on("click", ".question_no", function(){
  current_color = rgb2hex($(this).css('background-color'));
  q_index = $(this).attr('id').slice(5);
  id_team_packet = $("#id_team_packet").val();

  if (current_color != '#ffc966') {
    $(this).css('background-color', "#ffc966");

    var status = "orange";

    $.ajax({
      url: '{{route('peserta.submit.ans.stat')}}',
      method: 'put',
      data: {q_index, id_team_packet, id_packet},
      success: function(data){
        if (typeof data.intended_url !== 'undefined') {
          window.location= '{{route('index')}}';
        }
      }
    })
  }
})

$(document).on("click", ".fa-refresh", function(){
  var name = $(this).attr('name');
  q_index = name.slice(3);
  id_team_packet = $("#id_team_packet").val();

  $(".row.q_"+name+" input[type='radio']").prop('checked', false)
  $("#q_"+name).css('background-color', 'white')

  $.ajax({
    url: '{{route('peserta.reset.ans')}}',
    method: "PUT",
    data: {q_index, id_team_packet, id_packet},
    success: function(data){
      if (typeof data.intended_url !== 'undefined') {
        window.location= '{{route('index')}}';
       }
    }
  });
});

$(document).on('click', '#submit_exam', function(){
  $(".finish_exam").modal('show');
});

$(document).on('click', '#confirm_finish', function(){
  var id_team_packet = $("#id_team_packet").val();
  id_packet = $("#id_packet").val();
  $(".my_page").addClass('disabled');

  $.ajax({
    method: "PUT",
    data: {id_team_packet, id_packet},
    url: '{{route('peserta.submit.exam')}}',
    success: function(data){
      if (data == "ok") {
        $(".finish_exam").modal('hide');
        alertify.success("Ujian berhasil diselesaikan! Terima kasih sudah berpartisipasi di NLC Online 2018 :)");
        window.setTimeout(function(){
          window.location = "{{url('/')}}";
        }, 2800);

      }else {
        alertify.error("Gagal menyelesaikan ujian!");
      }
    },
    error: function(){
      alertify.error("Server error!");
    }
  })
});

function startTimer(added_time){
  // Set the date we're counting down to
  //deadline dari server-side yakni end time ujian
  var deadline = $("#deadline").val();
  var countDownDate = new Date(deadline).getTime();
  var now = new Date($("#time_now").val()).getTime() + added_time - 1000;

  // Update the count down every 1 second
  var x = setInterval(function() {

      // Get todays date and time
      // Find the distance between now an the count down date
      // console.log(now)
      var distance = parseInt(countDownDate - now);

      // Time calculations for days, hours, minutes and seconds
      var days = parseInt(Math.floor(distance / (1000 * 60 * 60 * 24)));
      var hours = parseInt(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
      var minutes = parseInt(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
      var seconds = parseInt(Math.floor((distance % (1000 * 60)) / 1000));

      if (hours < 10) {
        hours = "0"+hours;
      }
      if (minutes < 10) {
        minutes = "0"+minutes;
      }
      if (seconds < 10) {
        seconds = "0"+seconds;
      }


      document.getElementById("clock").innerHTML = "<strong>Sisa Waktu:</strong> "+hours + ":"
      + minutes + ":" + seconds + "";

      if (distance < 0) {
        document.getElementById("clock").innerHTML = "Waktu Habis!";
          clearInterval(x);
          $(".my_page .main-content").addClass("disabled");
          $(".my_page .main-content").addClass("disabled");
          $("#confirm_finish").trigger('click');
      }
      now+= 1000;

  }, 1000);

}
</script>
@endsection
