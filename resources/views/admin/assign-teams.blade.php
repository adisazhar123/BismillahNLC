@extends('layouts.app-admin')

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Daftar Paket</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#</th>
					            <th>Nama Packet</th>
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

<div class="assign modal fade" tabindex="-1" role="dialog">
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
			ajax: "{{route('get.packets.for.assign')}}",
			columns:[
					{data: "id_packet"},
					{data: "name"},
					{render: function(data, type, row){
						return "<a href='{{url('/admin/get-teams-to-assign-page')}}?id_packet="+row.id_packet+"' class='btn btn-info'>Info</a>";
						}
					}
			]
		});
		//
		// $(document).on('click', '#assign', function(){
		// 	$(".assign.modal").modal('show');
		// })

	});


	</script>
@endsection
