@extends('layouts.app-admin')

@section('main')
<!-- Page Header-->
<header>
	<h1 class="h3 display">Tables</h1>
</header>
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Tim</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-striped table-hover" id="datatable-teams">
						<thead>
							<tr>
								<th>#</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Username</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Mark</td>
								<td>Otto</td>
								<td>@mdo</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Jacob</td>
								<td>Thornton</td>
								<td>@fat</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter </td>
							</tr>
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
		$('#dataTable-teams').DataTable({
		responsive: true,
		ajax: "{{route('statistics.admin')}}",
		columns:[
				{data: "statistic"},
				{data: "total_teams",
				render: function(data, type, row){
					return row.statistic + " mengirim " + row.total_teams +" tim";
				}
				}
		]
	});


	});
	alert("hi")
	</script>
@endsection
