@extends('layouts.app-peserta')

@section('style')
<style media="screen">

</style>
@endsection

@section('content')

<br>

<div class="row my_page animated fadeIn">
  <div class="col-lg-12">
    <div class="alert alert-warning">
      Jika halaman kosong mohon untuk update browser atau gunakan browser yang lain.
    </div>
    <div class="main-content">
    </div>
  </div>
</div>


@endsection

@section('script')

<!--Load partial views-->
<script type="text/javascript">
$(document).ready(function(){

  var isMobile = false; //initiate as false
// device detection
  if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent)
      || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
      isMobile = true;
  }

  if (isMobile) {
    alert("Anda terdeteksi menggunakan HP. Diharapkan untuk mengerjakan ujian menggunakan laptop atau komputer agar User Experience tidak terganggu!")
  }



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
      },
      error: function(){
        alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
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
    },
    error: function(){
      alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
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
      },
      error: function(){
        alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
      }
    })
  }
})

$(document).on("click", ".fa-refresh", function(){
  var name = $(this).attr('name');
  console.log(name)
  var q_index = name.slice(3);
  console.log(q_index);
  var id_team_packet = $("#id_team_packet").val();
  console.log(id_team_packet)

  $(".row.q_"+name+" input[type='radio']").prop('checked', false);
  $("#q_"+name).css('background-color', 'white');

  $.ajax({
    url: '{{route('peserta.reset.ans')}}',
    method: "PUT",
    data: {q_index, id_team_packet, id_packet},
    success: function(data){
      if (typeof data.intended_url !== 'undefined') {
        window.location= '{{route('index')}}';
       }
    },
    error: function(){
      alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
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
          window.location = "{{url('/peserta/home')}}";
        }, 2800);

      }else {
        alertify.error("Gagal menyelesaikan ujian!");
      }
    },
    error: function(){
      alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
    }
  });
});


function submitUjian(){
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
          window.location = "{{url('/peserta/home')}}";
        }, 2800);

      }else {
        alertify.error("Gagal menyelesaikan ujian!");
      }
    },
    error: function(){
      alertify.error("Server error! Mohon untuk refresh halaman atau hubungi panitia.");
    }
  });
}

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
      var days = parseInt(Math.floor(parseInt(distance) / (1000 * 60 * 60 * 24)));
      var hours = parseInt(Math.floor((parseInt(distance) % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
      var minutes = parseInt(Math.floor((parseInt(distance) % (1000 * 60 * 60)) / (1000 * 60)));
      var seconds = parseInt(Math.floor((parseInt(distance) % (1000 * 60)) / 1000));

      if (parseInt(hours) < 10) {
        hours = "0"+hours.toString();
      }
      if (parseInt(minutes) < 10) {
        minutes = "0"+minutes.toString();
      }
      if (parseInt(seconds) < 10) {
        seconds = "0"+seconds.toString();
      }


      document.getElementById("clock").innerHTML = "<strong>Sisa Waktu:</strong> "+hours.toString() + ":"
      + minutes.toString() + ":" + seconds.toString() + "";

      if (parseInt(distance) < 0) {
        document.getElementById("clock").innerHTML = "Waktu Habis!";
          clearInterval(x);
          $(".my_page .main-content").addClass("disabled");
          $(".my_page .main-content").addClass("disabled");
          //$("#confirm_finish").trigger('click');
          submitUjian();
      }
      now = parseInt(now) + 1000;

  }, 1000);

}
</script>
@endsection
