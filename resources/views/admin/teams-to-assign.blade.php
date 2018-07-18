@extends('layouts.app-admin')

<style media="screen">
	.btn{
		margin-right: 3px;
	}
</style>

@section('main')

<br>
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Cara penggunaan</h4>
  <ul>
  	<li>Peringatan, jika anda <i>unassign</i> tim, maka data nilai tim untuk paket tersebut akan hilang!</li>
  </ul>
  <hr>
  <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Tim</h4>
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
			</div>
		</div>
	</div>
</div>

{{-- <div class="assign modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Assign Tim</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<div class="card">
					<div class="card-header">
						<h4>Daftar Tim</h4>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table_id" class="table table-striped table-hover">
							    <thead>
							        <tr>
													<th>#ID Tim</th>
							            <th>Nama Tim</th>
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


        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> --}}


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
							return "Sudah ter-assign";
						}else {
							return "Belum ter-assign";
							}
						}
					},
					{data: "type"},
					{render: function(data, type, row){
						if (row.team_packets.length) {
							return "<button class='btn btn-success' id=assign team-id="+row.id_team+" disabled>Assign</button>"+
							"<button class='btn btn-danger' id=unassign team-id="+row.id_team+" >Unassign</button>";
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
				method: "DELETE",
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

	});


	</script>
@endsection
