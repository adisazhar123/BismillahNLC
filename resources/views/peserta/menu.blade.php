
<h5 class="sidenav-heading">Menu Utama</h5>
<ul id="side-main-menu" class="side-menu list-unstyled">
	<li id="menu-home">
		<a href="{{route('peserta.home')}}"><i class="fa fa-home"></i>Beranda</a>
	</li>
	<li id="menu-score">
		<a href="{{url('/peserta/hasil-ujian')}}">
			<i class="fa fa-star"></i>
			Hasil Ujian
		</a>
	</li>
	<li id="menu-announcement">
		<a href="{{url('/peserta/announcement')}}"> <i class="fa fa-bell"></i>Pengumuman </a>
	</li>
	<li id="menu-settings">
		<a href="{{route('peserta.changepsw')}}"> <i class="fa fa-wrench"></i>Pengaturan </a>
	</li>
</ul>
