@extends('layouts.app-admin')

@section('style')
	<style media="screen">
		.btn{
			margin-right: 3px;
			margin-bottom: 3px;
		}

	</style>
@endsection


@section('main')

<br>
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Cara penggunaan</h4>
  <ul>
  	<li>Untuk nge-assign tim bisa secara individu dengan cara klik 'Assign' di kolom <i>Action</i>, atau 'Assign tim online' untuk semua tim online,
			atau 'Assign tim offline' untuk semua tim offline.</li>
		<li>Untuk menghilangkan 'Assign' dengan cara klik 'Unassign semua tim' atau 'Unassign'.</li>

  </ul>
  <hr>
  <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
</div>
<div class="row my_page">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Tim untuk Paket {{$packet->name}}</h4>
				<div class="row" style="float: right">
					<button style="float: right" type="button" name="button" id='unassign_all' class="btn btn-danger" packet-id={{Input::get('id_packet')}}>Unassign semua tim</button>
					<button style="float: right" type="button" name="button" id='assign_online' class="btn btn-primary" packet-id={{Input::get('id_packet')}}>Assign tim online</button>
					<button style="float: right" type="button" name="button" id='assign_offline' class="btn btn-primary" packet-id={{Input::get('id_packet')}}>Assign tim offline</button>

				</div>

			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#</th>
					            <th>Nama Tim</th>
											<th>Status</th>
											<th>Region</th>
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


@endsection

@section('script')
	<script type="text/javascript">
		$(document).ready( function () {
			var table1;
			var method, action, url;

			$.ajaxSetup({
					headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
			});

			table1 = $('#table_id').DataTable({
			responsive: true,
			stateSave: true,
			ajax: '{{url('admin/get-teams-to-assign')}}?id_packet='+{{Input::get('id_packet')}},
			columns:[
					{data: "id_team"},
					{data: "name"},
					{render: function(data,type,row){
						if (row.team_packets.length) {
							if (row.team_packets[0].status) {
								return "Sudah ter-assign";
							}else {
								return "Belum ter-assign";
							}

						}else {
							return "Belum ter-assign";
						}
					}
					},
					{data: "type"},
					{render: function(data, type, row){
						if (row.team_packets.length) {
							if (row.team_packets[0].status) {
								return "<button class='btn btn-success' id=assign team-id="+row.id_team+" disabled>Assign</button>"+
								"<button class='btn btn-danger' id=unassign team-id="+row.id_team+" >Unassign</button>";
							}else {
								return "<button class='btn btn-success' id=assign team-id="+row.id_team+" >Assign</button>"+
								"<button class='btn btn-danger' id=unassign team-id="+row.id_team+" disabled>Unassign</button>";
							}

						}else {
							return "<button class='btn btn-success' id=assign team-id="+row.id_team+" >Assign</button>"+
							"<button class='btn btn-danger' id=unassign team-id="+row.id_team+" disabled>Unassign</button>";
						}
					}
				}
			]
		});

		$(document).on('click', '#assign', function(){
			id_packet = '{{Input::get('id_packet')}}';
			id_team = $(this).attr('team-id');

			$.ajax({
				url: '{{route('assign.team.to.packet')}}',
				method: "PUT",
				data: {id_packet, id_team},
				success: function(data){
					if (data == "ok") {
						alertify.success("Tim telah di-assign!");
					}else {
						alertify.error("Tim gagal di-assign!");
					}
					table1.ajax.reload();
				},
				error: function(){
					alertify.error("Server error!");
				}
			});

		});

		$(document).on('click', '#unassign', function(){
			id_packet = '{{Input::get('id_packet')}}';
			id_team = $(this).attr('team-id');

			$.ajax({
				url: '{{route('unassign.team')}}',
				method: "PUT",
				data: {id_packet, id_team},
				success: function(data){
					if (data == "ok") {
						alertify.success("Tim telah di-unassign!");
					}else {
						alertify.error("Tim gagal di-unassign!");
					}
					table1.ajax.reload();
				},
				error: function(){
					alertify.error("Server error!");
				}
			});
		});

		$("#assign_online").click(function(){
			id_packet = '{{Input::get('id_packet')}}';
			$("body").loading({
				zIndex: 9999999
			});
			$.ajax({
				url: '{{route('assign.online.teams')}}',
				data: {id_packet},
				method: "PUT",
				success: function(data){
					if (data == "ok") {
						alertify.success("Tim region online berhasil di-assign!");
						table1.ajax.reload();
					}else {
						alertify.error("Tim region online gagal di-assign!");
					}
					$("body").loading('stop');
				},
				error: function(){
					$("body").loading('stop');
					alertify.error("Server error!");
				}

			});

		});

		$("#assign_offline").click(function(){
			id_packet = '{{Input::get('id_packet')}}';
			$("body").loading({
				zIndex: 9999999
			});
			$.ajax({
				url: '{{route('assign.offline.teams')}}',
				data: {id_packet},
				method: "PUT",
				success: function(data){
					if (data == "ok") {
						table1.ajax.reload();
						alertify.success("Tim region offline berhasil di-assign!");
					}else {
						alertify.error("Tim region offline gagal di-assign!");
					}
					$("body").loading('stop');
				},
				error: function(){
					$("body").loading('stop');
					alertify.error("Server error!");
				}
			});
		});

		$("#unassign_all").click(function(){
			id_packet = '{{Input::get('id_packet')}}';
			$("body").loading({
				zIndex: 9999999
			});
			$.ajax({
				url: '{{route('unassign.teams')}}',
				data: {id_packet},
				method: "PUT",
				success: function(data){
					if (data == "ok") {
						table1.ajax.reload();
						alertify.success("Semua tim berhasil di-unassign!");
					}else {
						alertify.error("Tim gagal di-unassign!");
					}
					$("body").loading('stop');

				},
				error: function(){
					$("body").loading('stop');
					alertify.error("Server error!");
				}
			});
		});

	});




	</script>
@endsection
