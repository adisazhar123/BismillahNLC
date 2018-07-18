@extends('layouts.app-admin')

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Pengaturan User</h4>
				<small>Anda bisa mengubah info user disini!</small>
			</div>
			<div class="card-body">
				<form action="{{url('/admin/update-user-info')}}" method="POST">
					<input type="hidden" name="_method" value="PUT">

					{{ csrf_field() }}
					<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
					<div class="form-group">
					 <label for="name">Nama user</label>
					 <input type="text" class="form-control" placeholder="Enter nama" name="user_name" value="{{$user->name}}">
				 </div>
				  <div class="form-group">
				    <label for="exampleInputEmail1">Email user</label>
				    <input type="email" class="form-control"  aria-describedby="emailHelp" placeholder="Enter email" name="user_email" value="{{$user->email}}">
				  </div>
				  <div class="form-group">
				    <label for="exampleInputPassword1">Password user</label>
				    <input type="password" class="form-control"  placeholder="Password" name="user_password">
				  </div>
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

			@if (session()->has('message'))
				alertify.success('{{session()->get('message')}}')
			@endif

			$("#menu-settings").addClass('active');


	});


	</script>
@endsection
