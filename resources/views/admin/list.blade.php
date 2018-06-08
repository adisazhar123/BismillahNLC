@extends('admin.template')

@section('userstatus')
	Logged in as Admin
@endsection

@section('usermenu')
	<a class="dropdown-item" href="#">Edit Profile</a>
	<a class="dropdown-item" href="#">Logout</a>
	<div class="dropdown-divider"></div>
	<a class="dropdown-item" href="#">Something</a>
@endsection

@section('content')
	<h1>Daftar Peserta</h1>
	@include('admin.search')
	
	<table class="table table-hover table-striped">
		<thead>
			<tr>
				<th>Nama Peserta</th>
				<th>Status Peserta</th>
				<th style="width:1%">Hapus</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-success badge-pill" style="font-size:14px">Teraktivasi</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-success badge-pill" style="font-size:14px">Teraktivasi</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-danger badge-pill" style="font-size:14px">Gagal</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-success badge-pill" style="font-size:14px">Teraktivasi</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-success badge-pill" style="font-size:14px">Teraktivasi</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
			<tr>
				<td>Botak</td>
				<td><span class="badge badge-success badge-pill" style="font-size:14px">Teraktivasi</span></td>
				<td><button class="btn btn-danger"><i class="fas fa-trash-alt"></i></button></td>
			</tr>
		</tbody>
	</table>
@endsection