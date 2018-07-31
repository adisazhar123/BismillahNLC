@extends('layouts.app-admin')

@section('style')
<style media="screen">
	table .btn{
		margin-bottom: 3px;
		margin-left: 3px;
	}


</style>
@endsection

@section('main')

<br>
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Cara penggunaan</h4>
  <ul>
  	<li>Untuk menilai tim klik 'Generate Skor'. Setiap klik akan nge-generate nilai dari 100 tim.</li>
		<li>Angka di kolom progress menunjukkan jumlah tim yang sudah dinilai dari total tim yang ada di paket tersebut.</li>
  </ul>
  <hr>
  <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
</div>

<div class="row my_page">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Generate Skor </h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#ID Paket</th>
					            <th>Nama Paket</th>
											<th>Progress</th>
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
	$(document).ready(function(){

		var table1;
		table1 = $('#table_id').DataTable({
		responsive: true,
		stateSave: true,
		ajax: "{{route('get.packets.to.score.admin')}}",
		columns:[
				{data: "id_packet"},
				{data: "packet_name"},
				{data: "number_of_scored_teams",
				render: function(data, type, row){
					if (row['number_of_scored_teams']/row['total_teams_per_packet'] * 100 < 100) {
						return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="'+row['number_of_scored_teams']/row['total_teams_per_packet'] * 100+'" aria-valuemin="0" aria-valuemax="100" style="width: '+row['number_of_scored_teams']/row['total_teams_per_packet'] * 100+'%"></div></div>'+row['number_of_scored_teams']+"/"+row['total_teams_per_packet'];
					}else {
						return '<div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="'+row['number_of_scored_teams']/row['total_teams_per_packet'] * 100+'" aria-valuemin="0" aria-valuemax="100" style="width: '+row['number_of_scored_teams']/row['total_teams_per_packet'] * 100+'%"></div></div>'+row['number_of_scored_teams']+"/"+row['total_teams_per_packet'];
					}

					},
				},
				{data: "action",
				render: function(data, type, row){
					return "<button class='btn btn-primary generate-score' id-packet="+row.id_packet+">Generate Skor</button>";
				}

				}
			]
		});

		$.ajaxSetup({
    	headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});

		$(document).on('click', '.generate-score', function(){
			$("body").loading({
				zIndex: 9999999
			});
			id_packet = $(this).attr('id-packet');

			$.ajax({
				url: '{{route('generate.score.admin')}}',
				data: {id_packet},
				method: "PUT",
				success: function(data){
					if (data == "ok") {
						alertify.success("Berhasil generate skor!");
						table1.ajax.reload();
					}else {
						alertify.error("Gagal!");
					}
					$("body").loading('stop');
				},
				error: function(data){
					$("body").loading('stop');
					alertify.error("Server error!");
				}
			});
		});


	});
</script>
@endsection
