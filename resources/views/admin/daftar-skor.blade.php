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
											<th>#</th>
					            <th>Soal</th>
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

@endsection
