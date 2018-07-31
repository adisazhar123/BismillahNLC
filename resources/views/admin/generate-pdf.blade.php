@extends('layouts.app-admin')
@section('style')
<style media="screen">
  .card-body{
    justify-content: center;
    text-align: center;
  }

  table .btn{
    margin-right: 3px;
    margin-bottom: 3px;
  }
</style>
@endsection

@section('main')
  <br>
  <div class="row my_page">
  	<div class="col-lg-12">
      <div class="alert alert-info" role="alert">
        <h4 class="alert-heading">Cara penggunaan</h4>
        <ul>
          <li>Untuk membuat PDF silahkan klik <i>generate</i>. Lalu pilih kebutuhan selanjutnya. Pembuatan PDF <strong>maksimal 10</strong> per
            <i>generate</i>.</li>
          <li>Untuk melihat kumpulan PDF per paket, klik 'Info'.</li>
        </ul>
        <hr>
        <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
      </div>
  		<div class="card">
  			<div class="card-header">
  				<h4>Generate PDF paket soal</h4>

  			</div>
  			<div class="card-body">
  				<div class="table-responsive">
  					<table id="table_id" class="table table-striped table-hover">
  					    <thead>
  					        <tr>
  											<th>#ID Paket</th>
  					            <th>Nama Paket</th>
  											<th>Action</th>
  					        </tr>
  					    </thead>
  					    <tbody>


  					    </tbody>
  					</table>
  				</div>
          <div class="loading_gif">

          </div>
  			</div>
  		</div>
  	</div>
    <div class="modal generate_pdf fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Generate PDF</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="#" id="packet_form">
              {{ csrf_field() }}
              <input type="hidden" name="id_packet" id="id_packet" value="">
              <div class="form-group">
                <label for="packet_count">Jumlah Paket PDF</label>
                <input type="number" name="packet_count" value="" class="form-control" required id="packet_count" min="1" max="10">
              </div>
              <div class="">
                <div class="form-group">
                  <label for="randomize">Acak Soal</label>
                  <select class="form-control" id="randomize" name="randomize" required>
                    <option value='0'>Tidak</option>
                    <option value='1'>Iya</option>
                  </select>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>



@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    table1 = $('#table_id').DataTable({
    responsive: true,
    stateSave: true,
    ajax: "{{route('get.packets.for.pdf.admin')}}",
    columns:[
        {data: "id_packet"},
        {data: "name"},
        {render: function(data, type, row){
          return "<button class='btn btn-primary' id=generate packet-id="+row.id_packet+">Generate</button><a class='btn btn-info' href='{{url('admin/list-pdf')}}/"+row.id_packet+"'>Info</a>";
        }
      }
    ]
  });

    $(document).on('click', '#generate', function(){
      id_packet = $(this).attr('packet-id');
      $("#id_packet").val(id_packet);
      $(".modal.generate_pdf").modal('show');

    })

    $("form").submit(function(e){
      $("body").loading({
        zIndex: 9999999
      });

      e.preventDefault();

      $.ajax({
        url: '{{route('generate.packets.admin')}}',
        method: "POST",
        data: $(this).serialize(),
        success: function(data){
          $("body").loading('stop');
          $(".modal.generate_pdf").modal('hide');
          alertify.success("PDF berhasil dibuat");
        },
        error: function(){
          $("body").loading('stop');
          alertify.error("Server error!");
        }
      })
    });


  })
</script>
@endsection
