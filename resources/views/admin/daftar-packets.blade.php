@extends('layouts.app-admin')

@section('style')
	<style media="screen">
		table .btn{
			margin-right: 3px;
			margin-bottom: 3px;
		}

		.view_packet label{
			margin-top: 9px;
		}

		#loading{
			margin-top: -600px;
			margin-left: 700px;
		}
	</style>
@endsection

@section('main')

<br>
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Cara penggunaan</h4>
  <ul>
  	<li>Untuk menambahkan paket klik 'Tambah Soal'.</li>
		<li>Untuk mengganti pengaturan paket klik 'Ubah'.</li>
		<li>Untuk menghapus paket klik 'Hapus'. <br>
			<strong>Penghapusan paket mengakibatkan seluruh nilai dan generated PDF untuk paket tersebut hilang!</strong>
		</li>
		<li>Jika paket memiliki status 'aktif', maka paket tersebut tersedia untuk dikerjakan oleh peserta. Klik 'non-aktifkan' jika paket belum siap.</li>
		<li>Untuk pengaturan soal pada paket, klik 'Info'.</li>
  </ul>
  <hr>
  <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
</div>
<div class="row my_page">
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
				<div class="loading_gif">

				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal add_packet fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah paket</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="#" id="packet_form" enctype="multipart/form-data">
					{{ csrf_field() }}
				  <div class="form-group">
				    <label for="packet_name">Nama paket</label>
						<input type="text" name="packet_name" value="" class="form-control" required id="name">
				  </div>
				  <div class="form-group">
				    <label for="active_date">Tanggal aktif</label>
						<input type="date" name="active_date" value="" class="form-control" required id="date">
				  </div>
				  <div class="form-group">
				    <label for="start_time">Jam mulai</label>
						<input type="time" name="start_time" value="" class="form-control"  required id="start_time">
				  </div>
					<div class="form-group">
						<label for="end_time">Jam selesai</label>
						<input type="time" name="end_time" value="" class="form-control"  required id="end_time">
					</div>
					<div class="form-group">
						<label for="duration">Durasi</label>
						<input class="form-control" type="number" name="duration" value="" required min="0" id="duration">
						<small>Dalam satuan menit</small>
					</div>
					<div class="form-group">
						<label for="type">Tipe peserta</label>
						<select class="form-control" id="type" name="type">
							<option value='warmup' id="select_option_1">Warmup</option>
							<option value='non-warmup' id="select_option_2">Non warmup</option>
						</select>
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
			var action;
			var id_packet;
			var formData;

			$.ajaxSetup({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});

			var APP_URL = '{!! url('/') !!}';

			table1 = $('#table_id').DataTable({
			responsive: true,
			stateSave: true,
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
						if(row.active == 1)
							return "<button class='btn btn-success' disabled id=toggle packet-id="+row.id_packet+">Aktifkan</button><button type=button name=button id=duplicate class='btn btn-default' packet-id="+row.id_packet+">Duplikat</button><button class='btn btn-danger' id=delete packet-id="+row.id_packet+">Hapus</button><button class='btn btn-warning' id=edit packet-id="+row.id_packet+">Ubah</button><button class='btn btn-danger' id=toggle packet-id="+row.id_packet+">Non-aktifkan</button><a href="+APP_URL+"/admin/list-questions/"+row.id_packet+" class='btn btn-info' id=view>Info</button>";
						else
						return "<button class='btn btn-success' id=toggle packet-id="+row.id_packet+">Aktifkan</button><button type=button name=button id=duplicate class='btn btn-default' packet-id="+row.id_packet+">Duplikat</button><button class='btn btn-danger' id=delete packet-id="+row.id_packet+">Hapus</button><button class='btn btn-warning' id=edit packet-id="+row.id_packet+">Ubah</button><button disabled class='btn btn-danger' id=toggle packet-id="+row.id_packet+">Non-aktifkan</button><a href="+APP_URL+"/admin/list-questions/"+row.id_packet+" class='btn btn-info' id=view>Info</button>";
					}
				}
			]
		});
		$("#menu-packets").addClass('active')

		$("#add_packet").click(function(){
			$('#packet_form')[0].reset();
			action = "add";
			$(".modal.add_packet .modal-title").text('Tambah paket')
			$(".modal.add_packet").modal('show')
		})

		$("#packet_form").submit(function(e){
			e.preventDefault();

			var method;
			formData = new FormData($(this)[0]);
			formData.append('id_packet', id_packet)

			if (action == "add"){
				url = '{{route('new.packet.admin')}}';
			}
			else{
				 url = '{{route('update.packet.admin')}}';
			}


			$.ajax({
				url: url,
				method: "post",
				data: formData,
				processData: false,
				contentType: false,
				success: function(data){
					if (data == "ok"){
						if( action == "add")
							alertify.success('Penambahan paket berhasil!');
						else {
							alertify.success('Pembaharuan paket berhasil!');
						}
					}else{
						if (action == "add")
							alertify.error('Penambahan paket gagal!');
						else{
							alertify.error('Pembaharuan paket gagal!');

						}
					}
					$('#packet_form')[0].reset();
					$(".modal.add_packet").modal('hide');
					table1.ajax.reload(null, false)
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
					table1.ajax.reload(null, false)

				},
				error: function(){
					alertify.error('Server error!');
				}
			})
		})


			$(document).on('click', '#toggle', function(){
				id_packet = $(this).attr('packet-id')
				$.ajaxSetup({
						headers: {
								'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
				});
				$.ajax({
					url: '{{route('toggle.packet.admin')}}',
					data: {id_packet},
					method: "PUT",
					success: function(data){
						if (data == "ok1"){
							alertify.success('Paket berhasil diaktifkan!');
						}else if(data == "ok0"){
							alertify.success('Paket berhasil dinon-aktifkan!');
						}else{
							alertify.error('Gagal!');
						}
						table1.ajax.reload(null, false);
					},
					error: function(){
						alertify.error('Server error!');
					}
				})
			})

			$(document).on('click', '#edit', function(){
				action = "edit";
				id_packet = $(this).attr('packet-id')
				$.ajax({
					url: '{{route('get.packet.details.admin')}}',
					data: {id_packet},
					success: function(data){
						$("#name").val(data.name);
						$("#date").val(data.active_date);
						$("#start_time").val(data.start_time);
						$("#end_time").val(data.end_time);
						$("#duration").val(data.duration);
						$("#type").val(data.type);
					}
				});
				$(".modal.add_packet .modal-title").text('Edit paket');
				$(".modal.add_packet").modal('show');
			});


			$(document).on('click', '#duplicate', function(){
				id_packet = $(this).attr('packet-id');

				$(".loading_gif").html('<img src="{{asset('img/loading.gif')}}" alt="Loading" width="100px" id="loading">');
				$(".row.my_page").addClass("disabled");

				$.ajax({
					url: '{{route('duplicate.packet')}}',
					method: "POST",
					data: {id_packet},
					success: function(data){
						if (data=="ok") {
							alertify.success("Paket berhasil diduplikasi!");
						}else {
							alertify.error("Paket gagal diduplikasi!");

						}
						$(".loading_gif").html('')
						$(".row.my_page").removeClass("disabled")
						table1.ajax.reload();
					},
					error: function(){
						alertify.error("Server error!");
						$(".loading_gif").html('')
						$(".row.my_page").removeClass("disabled")
					}
				})
			});


	});



	</script>
@endsection
