
<h5 class="sidenav-heading">Menu Utama</h5>
<ul id="side-main-menu" class="side-menu list-unstyled">
	<li id="menu-teams">
		<a href="{{route('index.admin')}}"> <i class="fa fa-users"></i>Daftar Tim </a>
	</li>

	<li><a href="#exampledropdownDropdown" id="menu-packets" aria-expanded="false" data-toggle="collapse"> <i class="icon-interface-windows"></i>Menu Paket </a>
		<ul id="exampledropdownDropdown" class="collapse list-unstyled ">
			<li><a href="{{route('packet.admin')}}"> <i class="fa fa-book"></i>Daftar Paket </a></li>
			<li><a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Generate PDF</a></li>
		</ul>
	</li>

	<li id="menu-questions">
		<a> <i class="fa fa-file-text"></i>Daftar Soal </a>
	</li>
</ul>
