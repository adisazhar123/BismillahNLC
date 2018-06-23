@extends('layouts.app-admin')

@section('main')

<br>

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
			table1 = $('#table_id').DataTable({
			responsive: true,
			ajax: "{{route('get.teams.admin')}}",
			columns:[
					{data: "id_team"},
					{data: "name"},
					{data: "email"},
					{render: function(data, type, row){
						return "<button class='btn btn-info' id=view>View</button>";
					}

					}
			]
		});
		$("#menu-teams").addClass('active')

	});


	</script>
@endsection
