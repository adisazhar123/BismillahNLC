@extends('layouts.app-admin')

@section('style')
	<style media="screen">
		table .btn{
			margin-right: 3px;
		}
	</style>
@endsection

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Users</h4>
				<button style="float: right" type="button" name="button" id='add_user' class="btn btn-primary">Tambah User</button>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
								<th>#ID User</th>
					            <th>Nama User</th>
					            <th>Email</th>
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

<div class="modal user fade" tabindex="-1" role="dialog" id="newuser">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<form action="#">
				{{ csrf_field() }}
				<input type="hidden" name="user_id" id="user_id" value="">
				<div class="form-group">
				 <label for="nama_tim">Nama user</label>
				 <input type="text" class="form-control" id="user_name" placeholder="Enter nama tim" required name="user_name">
			 </div>
				<div class="form-group">
				<label for="user_email">Email user</label>
				<input type="email" class="form-control" id="user_email" aria-describedby="emailHelp" placeholder="Enter email" name="user_email" required>
				</div>
				<div class="form-group">
				<label for="user_password">Password</label>
				<input type="password" class="form-control" id="user_password" placeholder="Password" name="user_password" >
				</div>
				<?php // NOTE: web master role = 1, komite/ user biasa role = 2 ?>
				<div class="form-group">
					<label for="type">Tipe user</label>
					<select class="form-control" id="type" name="type">
						<option value='1' id="select_option_1">Web Master</option>
						<option value='2-warmup' id="select_option_2">Komite</option>
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
			var method, action, url;
			table1 = $('#table_id').DataTable({
			responsive: true,
			stateSave: true,
			ajax: "{{route('get.user.admin')}}",
			columns:[
					{data: "id"},
					{data: "name"},
					{data: "email"},
					{render: function(data, type, row){
						return "<button class='btn btn-danger' id=delete user-id="+row.id_team+">Hapus</button>"+
						"<button class='btn btn-warning' id=view user-id="+row.id_team+">Ubah</button>";
						}
					}
			]
		});
		$("#user-list").addClass('active');

		$("#add_user").click(function(){
			$("form")[0].reset();
			method = "POST";
			url = '{{route('new.team.admin')}}';
			action = "new";
			$(".modal-title").html("Tambah user");
			$(".modal.user").modal('show');
		});

		// $(document).on('click', '#view', function(){
		// 	$("#newuser form")[0].reset();
		//
		// 	id_team = $(this).attr('team-id')
		// 	$("#newuser #user_id").val(id_team)
		// 	method = "PUT";
		// 	url = '{{route('update.team.admin')}}';
		// 	action = "update";
		// 	$(".team.modal-title").html("Edit tim");
		//
		// 	$(".team").modal('show')
		//
		//
		// 	$.ajax({
		// 		url: '{{route('get.team.to.update')}}',
		// 		data: {id_team},
		// 		success: function(data){
		// 			$(".modal-title").text("Lihat Tim");
		// 			$("#newuser #user_name").val(data[1].name);
		// 			$("#newuser #user_email").val(data[1].email)
		// 			// $("#newuser #user_password").val(data[0].password)
		// 			$("#newuser #user_phone").val(data[1].phone)
		// 		}
		// 	});
		//
		// });

		// $("#newuser form").submit(function(e){
		// 	e.preventDefault();
		// 	$.ajax({
		// 		url: url,
		// 		method: method,
		// 		data: $(this).serialize(),
		// 		success: function(data){
		// 			if (data == "ok"){
		// 				if (action == "new")
		// 					alertify.success('Tim berhasil ditambah!');
		// 				else {
		// 					alertify.success('Tim berhasil diperbaruhi!');
		//
		// 				}
		// 			}else{
		// 				if (action == "new")
		// 					alertify.error('Tim gagal ditambah!');
		// 				else
		// 					alertify.error('Tim gagal diperbaruhi!');
		// 			}
		// 			table1.ajax.reload(null, false);
		// 			$(".modal.team").modal('hide')
		//
		// 		},
		// 		error: function(){
		// 			alertify.error('Server error!');
		// 		}
		// 	});
		// });

});


	</script>
@endsection
