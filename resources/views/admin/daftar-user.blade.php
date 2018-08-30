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
				<h4>Daftar Users				<button style="float: right" type="button" name="button" id='add_user' class="btn btn-primary">Tambah User</button></h4>
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
				<form id="frm" action="#" method="post">
					{{ csrf_field() }}
					<input type="hidden" name="user_id" id="user_id" value="-1">
					<input type="hidden" name="act" id="act" value="null">
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
							<option value='1'>Web Master</option>
							<option value='2'>Komite</option>
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
		$(document).ready( function(){
			window['table1'] = $('#table_id').DataTable({
				responsive: true,
				stateSave: true,
				ajax: "{{route('get.user.admin')}}",
				columns:[
						{data: "id"},
						{data: "name"},
						{data: "email"},
						{render: function(data, type, row){
							return "<button class='btn btn-danger delete' user-id="+row.id+">Hapus</button>"+
							"<button class='btn btn-warning edit' user-id="+row.id+">Ubah</button>";
							}
						}
				]
			});
		$("#user-list").addClass('active');

		$("#frm").submit(function(e){
			e.preventDefault();
			$.ajax({
		 		url: "{{route('modify.user.admin')}}",
		 		method: "POST",
		 		data: $(this).serialize(),
		 		success: function(p){
					try{
						if (p.success){
							switch(p.op){
							case "add":
								alertify.success('User berhasil ditambah!');
								break;
							case "del":
								alertify.success('User berhasil dihapus!');
								break;
							case "alter":
								alertify.success('User berhasil diubah!');
								break;
							}
						}else{
							switch(p.op){
							case "add":
								alertify.error('User gagal ditambah!');
								break;
							case "del":
								alertify.success('User gagal dihapus!');
								break;
							case "alter":
								alertify.success('User gagal diubah!');
								break;
							}
						}
						table1.ajax.reload(null, false);
					}catch(err){
						alertify.error(err);
					}
					$(".modal").modal('hide');
		 		},
		 		error: function(){
		 			alertify.error('Server error!');
		 		}
		 	});
		});

		$("#add_user").click(function(){
			$("#frm")[0].reset();
			$("#frm #act").val("add");
			$("#frm #user_id").val(-1);
			$(".modal-title").html("Tambah user");
			$("#frm input[name=user_password]").attr("placeholder","Password");
			$(".modal.user").modal('show');
		});

		$(document).on("click", ".delete",function(){
			if(confirm("Hapus user ini?")){
				let f=$("#frm");
				f[0].reset();
				f.find("#user_id").val($(this).attr("user-id"));
				f.find("#act").val("del");
				f.submit();
			}
		});

		$(document).on("click", ".edit",function(){
			let f=$("#frm");
			let id=$(this).attr("user-id");
			f[0].reset();
			f.find("#act").val("alter");
			f.find("#user_id").val(id);
			f.find("#user_password").attr("placeholder","Tidak dirubah");
			$.ajax({
		 		url: '{{route('get.user.detail')}}',
		 		data: {id},
		 		success: function(data){
					f.find("#user_name").val(data[0].name);
					f.find("#user_email").val(data[0].email);
					f.find("#type").val(data[0].role);
					$(".modal.user").modal('show');
		 		}
		 	});
		});

	});
	</script>
@endsection
