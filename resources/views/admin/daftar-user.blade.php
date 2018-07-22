@extends('layouts.app-admin')

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Users</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
								<th>#</th>
					            <th>Nama Tim</th>
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
						return "<button class='btn btn-warning' id=view team-id="+row.id_team+">Ubah</button>";
						}
					}
			]
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
					// $("#newuser #team_password").val(data[0].password)
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
				error: function(){
					alertify.error('Server error!');
				}
			})
		})

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
