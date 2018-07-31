
<h5 class="sidenav-heading">Menu Utama</h5>
<ul id="side-main-menu" class="side-menu list-unstyled">
	@if (Auth::user()->role == 1)
		<li id="menu-teams">
			<a href="{{route('index.admin')}}"> <i class="fa fa-users"></i>Daftar Tim </a>
		</li>
		<li id="user-list">
			<a href="{{route('list.user.admin')}}"> <i class="fa fa-users"></i>Daftar User </a>
		</li>
	@endif
	<li><a href="#m1" id="menu-score" aria-expanded="false" data-toggle="collapse"> <i class="fa fa-list-ol"></i>Menu Skor </a>
		<ul id="m1" class="collapse list-unstyled ">
			<li><a href="{{route('scoreboard.page.admin')}}"><i class="fa fa-star" aria-hidden="true"></i>Daftar Skor </a></li>
			<li><a href="{{route('generate.score.page.admin')}}"><i class="fa fa-spinner" aria-hidden="true"></i>Generate Skor </a></li>
		</ul>
	</li>
	<li><a href="#m2" id="menu-packets" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Menu Paket </a>
		<ul id="m2" class="collapse list-unstyled ">
			<li><a href="{{route('assign.team')}}"> <i class="fa fa-book"></i>Assign Tim </a></li>
			<li><a href="{{route('packet.admin')}}"> <i class="fa fa-book"></i>Daftar Paket </a></li>
			<li><a href="{{route('list.pdf.page.admin')}}"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Generate PDF</a></li>
		</ul>
	</li>
	<li id="menu-settings">
		<a href="{{url('/admin/settings')}}"> <i class="fa fa-wrench"></i>Pengaturan </a>
	</li>
	<li id="menu-announcement">
		<a href="{{url('/admin/announcement')}}"> <i class="fa fa-bell"></i>Pengumuman </a>
	</li>
</ul>
