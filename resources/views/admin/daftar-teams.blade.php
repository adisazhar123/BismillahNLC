@extends('layouts.app-admin')

@section('style')
	<style media="screen">
		.btn{
			margin-bottom: 3px;
			margin-right: 3px;
		}
	</style>
@endsection

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="alert alert-info" role="alert">
			<h4 class="alert-heading">Cara penggunaan</h4>
			<ul>
				<li>Klik 'Tambah Tim' untuk menambahkan tim baru.</li>
				<li>Klik 'Impor Data' untuk mengimpor data tim dalam bentuk .csv.</li>
				<li>Klik 'Ubah' untuk melakukan perubahan data tim.</li>
				<li>Klik 'Hapus' untuk menghapus data tim.<br><strong>Ingat, penghapusan tim berarti SELURUH NILAI untuk tim tersebut akan HILANG!</strong></li>
			</ul>
			<hr>
			<p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Daftar Tim<button style="float: right" type="button" name="button" id='add_team' class="btn btn-primary">Tambah Tim</button>
				<button style="float: right" data-toggle="modal" data-target="#import" type="button" name="button" class="btn btn-primary">Impor Data</button></h4>

			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
								<th>#ID Tim</th>
								<th>#ID NLC</th>
					            <th>Nama Tim</th>
					            <th>Email</th>
											<th>Region</th>
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

<div class="modal team fade" tabindex="-1" role="dialog" id="newuser">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Tim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<form action="#">
				{{ csrf_field() }}
				<input type="hidden" name="team_id" id="team_id" value="">
				<div class="form-group">
				 <label for="nama_tim">Nama tim</label>
				 <input type="text" class="form-control" id="team_name" placeholder="Enter nama tim" required name="team_name">
			 </div>
			  <div class="form-group">
				<label for="team_email">Email tim</label>
				<input type="email" class="form-control" id="team_email" aria-describedby="emailHelp" placeholder="Enter email" name="team_email" required>
			  </div>
			  <div class="form-group">
				<label for="team_password">Password</label>
				<input type="password" class="form-control" id="team_password" placeholder="Password" name="team_password" >
			  </div>
				<div class="form-group">
					<label for="team_phone">No HP</label>
					<input type="text" class="form-control" id="team_phone" placeholder="No HP" name="team_phone" required>
				</div>
				<div class="form-group">
					<label for="type">Region</label>
					<select class="form-control" id="region" name="region">
						<option value='online' id="select_option_status_1">Online</option>
						<option value='offline' id="select_option_status_2">Offline</option>
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

<div class="modal fade" tabindex="-1" role="dialog" id="import">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Impor Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<p>Download template CSV disini:</p>
		<a target="_blank" href="{{route('download.team.csv')}}"><button class="btn btn-info" type="button">Download</button><br><br></a>
		<p>Upload CSV disini:</p>
		<form method="post" action="{{route('upload.team.csv')}}" enctype='multipart/form-data'>
			{{ csrf_field() }}
			<input type="file" name="csv" accept=".csv" required id="import_file">
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
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
			ajax: "{{route('get.teams.admin')}}",
			columns:[
					{data: "id_team"},
					{data: "id_team_nlc"},
					{data: "name"},
					{data: "email"},
					{data: "type"},
					{render: function(data, type, row){
						return "<button class='btn btn-danger' id=delete team-id="+row.id_team+">Hapus</button><button class='btn btn-warning' id=view team-id="+row.id_team+">Ubah</button>";
						}
					}
			]
		});

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$("#menu-teams").addClass('active');

		$("#add_team").click(function(){
			$("#newuser form")[0].reset();
			method = "POST";
			url = '{{route('new.team.admin')}}';
			action = "new";
			$("#newuser .modal-title").html("Tambah tim");
			$("#newuser.modal.team").modal('show');
		});

		$(document).on('click', '#view', function(){
			$("#newuser form")[0].reset();

			id_team = $(this).attr('team-id')
			$("#newuser #team_id").val(id_team)
			method = "PUT";
			url = '{{route('update.team.admin')}}';
			action = "update";
			$(".team.modal-title").html("Edit tim");

			$(".team").modal('show')


			$.ajax({
				url: '{{route('get.team.to.update')}}',
				data: {id_team},
				success: function(data){
					$(".modal-title").text("Lihat Tim");
					$("#newuser #team_name").val(data[1].name);
					$("#newuser #team_email").val(data[1].email)
					$("#region").val(data[1].type)
					$("#newuser #team_phone").val(data[1].phone)
				}
			});

		});

		$("#newuser form").submit(function(e){
			e.preventDefault();
			$.ajax({
				url: url,
				method: method,
				data: $(this).serialize(),
				success: function(data){
					if (data == "ok"){
						if (action == "new")
							alertify.success('Tim berhasil ditambah!');
						else {
							alertify.success('Tim berhasil diperbaruhi!');

						}
					}else{
						if (action == "new")
							alertify.error('Tim gagal ditambah!');
						else
							alertify.error('Tim gagal diperbaruhi!');
					}
					table1.ajax.reload(null, false);
					$(".modal.team").modal('hide')

				},
				error: function(data){
					message='Server error!';
					if (data.responseJSON == "23000") {
						message = "Email tsb sudah ada. Gunakan email yang berbeda!";
					}
					alertify.error(message);
				}
			});
		});

		$(document).on('click', '#delete', function(){
			id_team = $(this).attr('team-id');

			alertify.confirm('Warning', "Menghapus tim berarti SELURUH NILAI untuk tim tersebut akan HILANG. Lanjutkan?", function(){
				$.ajax({
					url: '{{route('delete.team')}}',
					data: {id_team},
					method: "DELETE",
					success: function(data){
						if (data == "ok") {
							alertify.success('Tim berhasil dihapus!');
						}else {
							alertify.error('Tim gagal dihapus!');
						}
						table1.ajax.reload();
					},
					error: function(){
						alertify.error('Server error!');
					}
				});
			},
			function(){}
		);



		});

	@if(session()->has('message'))
		alertify.success('{{session()->get('message')}}');
	@endif

	function checkFile(sender) {
    var validExts = new Array(".csv");
    var fileExt = sender.value;
    fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
    if (validExts.indexOf(fileExt) < 0) {
      alert("Invalid file selected, valid files are of " +
               validExts.toString() + " types.");
      return false;
    }
    else return true;
	}

	$("#import_file").change(function(){
		checkFile(this);
	});




});


	</script>
@endsection
