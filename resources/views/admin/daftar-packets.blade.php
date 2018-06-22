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

<div class="modal view_packet fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Info paket</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<h3>Kunji jawaban paket</h3>
				<div class="row col-md-12">

					<div class="col-md-4 content1">



					</div>
					<div class="col-md-4 content2">


					</div>
					<div class="col-md-4 content3">


					</div>
				</div>
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
						return "<button class='btn btn-success' id=toggle packet-id="+row.id_packet+">Toggle</button><button class='btn btn-danger' id=delete packet-id="+row.id_packet+">Delete</button><button class='btn btn-warning' id=edit packet-id="+row.id_packet+">Edit</button><button packet-id="+row.id_packet+" class='btn btn-info' id=view>View</button>";
					}
					}
			]
		});
		$("#menu-packets").addClass('active')

		$("#add_packet").click(function(){
			$(".modal.add_packet").modal('show')
		})

		$("#packet_form").submit(function(e){
			e.preventDefault();

			var formData = new FormData($(this)[0]);

			$.ajax({
				url: '{{route('new.packet.admin')}}',
				method: "POST",
				data: formData,
				processData: false,
				contentType: false,
				success: function(data){
					if (data == "ok"){
						alertify.success('Penambahan paket berhasil!');

					}else{
						alertify.error('Penambahan paket gagal!');

					}
					$('#packet_form')[0].reset();
					$(".modal.add_packet").modal('hide');
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

	function checkSelected(answer){
		if (answer == 'A'){
			return "<option value=></option>"+
			"<option value=A selected>A</option>"+
			"<option value=B>B</option>"+
			"<option value=C>C</option>"+
			"<option value=D>D</option>"+
			"<option value=E>E</option>";
		}else if(answer == 'B'){
			return "<option value=></option>"+
			"<option value=A>A</option>"+
			"<option value=B selected>B</option>"+
			"<option value=C>C</option>"+
			"<option value=D>D</option>"+
			"<option value=E>E</option>";
		}else if(answer == 'C'){
			return "<option value=></option>"+
			"<option value=A>A</option>"+
			"<option value=B>B</option>"+
			"<option value=C selected>C</option>"+
			"<option value=D>D</option>"+
			"<option value=E>E</option>";
		}else if(answer == 'D'){
			return "<option value=></option>"+
			"<option value=A>A</option>"+
			"<option value=B>B</option>"+
			"<option value=C>C</option>"+
			"<option value=D selected>D</option>"+
			"<option value=E>E</option>";
		}else if (answer == 'E'){
			return "<option value=></option>"+
			"<option value=A>A</option>"+
			"<option value=B>B</option>"+
			"<option value=C>C</option>"+
			"<option value=D>D</option>"+
			"<option value=E selected>E</option>";
		}else{
			return "<option selected></option>"+
			"<option value=A>A</option>"+
			"<option value=B>B</option>"+
			"<option value=C>C</option>"+
			"<option value=D>D</option>"+
			"<option value=E>E</option>";
		}
	}

	$(document).on('click', '#view', function(){
		id_packet = $(this).attr('packet-id')
		//alert(id_packet)
		var content1="", content2="", content3="";
		var content_select1="", content_select2="", content_select3="";

		$.ajax({
			url: '{{route('get.packet.info.admin')}}',
			data: {id_packet},
			success: function(data){
				for (var i = 0; i < 30; i++) {
					content_select1 = checkSelected(data[i].right_ans);
					content1 += "<div class='form-group row'>"+
							"<label for=no_"+data[i].question_no+ " class='col-sm-1 control-label'>"+data[i].question_no+"</label>"+
							"<div class=col-sm-5>"+
									"<select class=form-control name=no_"+data[i].question_no+ " id=no_"+data[i].question_no+">"+
											content_select1 +
									"</select>"+
							 "</div>"+
					"</div>";

				}
				for (var i = 30; i < 60; i++) {
					content_select2 = checkSelected(data[i].right_ans);
					content2 += "<div class='form-group row'>"+
							"<label for=no_"+data[i].question_no+ " class='col-sm-1 control-label'>"+data[i].question_no+"</label>"+
							"<div class=col-sm-5>"+
									"<select class=form-control name=no_"+data[i].question_no+ " id=no_"+data[i].question_no+">"+
										content_select2 +
									"</select>"+
							 "</div>"+
					"</div>";
				}
				for (var i = 60; i < 90; i++) {
					content_select3 = checkSelected(data[i].right_ans);
					content3 += "<div class='form-group row'>"+
							"<label for=no_"+data[i].question_no+ " class='col-sm-1 control-label'>"+data[i].question_no+"</label>"+
							"<div class=col-sm-5>"+
									"<select class=form-control name=no_"+data[i].question_no+ " id=no_"+data[i].question_no+">"+
											content_select3 +
									"</select>"+
							 "</div>"+
					"</div>";
				}

			//	console.log(content1)
				$(".content1").html(content1);
				$(".content2").html(content2);
				$(".content3").html(content3);
				$(".modal.view_packet").modal('show')
			}
		})
	})

	$(document).on('change', 'select', function(){
		$.ajaxSetup({
				headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
		});

		var right_ans = $(this).val();
		var question_no = $(this).attr('id').slice(3);

		$.ajax({
			url: '{{route('update.packet.ans.admin')}}',
			data: {right_ans, question_no, id_packet},
			method: "PUT",
			success: function(data){
				console.log(data)
			},
			error: function(data){
				alert("server error")
			}
		})

	})



	</script>
@endsection
