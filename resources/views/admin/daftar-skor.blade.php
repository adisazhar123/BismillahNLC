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

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>List Skor </h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#ID Tim</th>
					            <th>Nama Tim</th>
											<th>Nama Paket</th>
											<th>Skor</th>
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
	$(document).ready(function(){

		var table1;
		table1 = $('#table_id').DataTable({
		responsive: true,
		stateSave: true,
		ajax: "{{route('get.team.scores.admin')}}",
		columns:[
				{data: "id_team"},
				{data: "teams.name"},
				{data: "packets.name"},
				{data: "final_score"},
			]
		});


	});
</script>
@endsection
