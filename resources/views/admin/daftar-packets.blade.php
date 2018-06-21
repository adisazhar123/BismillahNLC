@extends('layouts.app-admin')

@section('style')
	<style media="screen">
		table .btn{
			margin-right: 3px;
			margin-bottom: 3px;
		}
	</style>
@endsection

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Paket</h4>
				<button style="float: right" type="button" name="button" class="btn btn-primary" id='add_packet'>Tambah Paket</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#ID Paket</th>
					            <th>Nama Paket</th>
					            <th>Tanggal Aktif</th>
											<th>Status</th>
											<th>Action</th>
					        </tr>
					    </thead>
					    <tbody>


					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="#" id="packet_form" enctype="multipart/form-data">
					{{ csrf_field() }}
				  <div class="form-group">
				    <label for="packet_name">Nama paket</label>
						<input type="text" name="packet_name" value="" class="form-control" required>
				  </div>
				  <div class="form-group">
				    <label for="active_date">Tanggal aktif</label>
						<input type="date" name="active_date" value="" class="form-control" required>
				  </div>
				  <div class="form-group">
				    <label for="start_time">Jam mulai</label>
						<input type="time" name="start_time" value="" class="form-control"  required>
				  </div>
					<div class="form-group">
						<label for="end_time">Jam selesai</label>
						<input type="time" name="end_time" value="" class="form-control"  required>
					</div>
					<div class="form-group">
						<label for="duration">Durasi</label>
						<input class="form-control" type="number" name="duration" value="" required min="0">
						<small>Dalam satuan menit</small>
					</div>
					<div class="form-group">
						<label for="packet_file">File paket</label><br>
						<input type="file" id="file" name="file" required>
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
@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready( function () {
			var table1;
			table1 = $('#table_id').DataTable({
			responsive: true,
			ajax: "{{route('get.packets.admin')}}",
			columns:[
					{data: "id_packet"},
					{data: "name"},
					{data: "active_date"},
					{data: "active",
						render: function(data, type, row){
							if (row.active == 1){
								return "Aktif";
							}else{
								return "Tidak aktif";
							}
						}
					},
					{render: function(data, type, row){
						return "<button class='btn btn-danger' id=delete packet-id="+row.id_packet+">Delete</button><button class='btn btn-warning' id=edit packet-id="+row.id_packet+">Edit</button><button packet-id="+row.id_packet+" class='btn btn-info' id=view>View</button>";
					}
					}
			]
		});
		$("#menu-packets").addClass('active')

		$("#add_packet").click(function(){
			$(".modal").modal('show')
		})

		$("#packet_form").submit(function(e){
			e.preventDefault();

			$.ajax({
				url: '{{route('new.packet.admin')}}',
				method: "POST",
				data: $(this).serialize(),
				success: function(data){
					if (data == "ok"){
						alertify.success('Penambahan paket berhasil!');

					}else{
						alertify.error('Penambahan paket gagal!');

					}
					$('#packet_form')[0].reset();
					$(".modal").modal('hide');
					table1.ajax.reload()
				},
				error: function(){
					alertify.error('Server error!');
				}
			})
		})

		$(document).on('click', '#delete', function(){
			id_packet = $(this).attr('packet-id')

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$.ajax({
				url: '{{route('delete.packet.admin')}}',
				method: "DELETE",
				data: {id_packet},
				success: function(data){
					if (data == "ok"){
						alertify.success('Penghapusan paket berhasil!');

					}else{
						alertify.error('Penghapusan paket gagal!');

					}
					table1.ajax.reload()

				},
				error: function(){
					alertify.error('Server error!');
				}
			})
		})
	});



	</script>
@endsection
