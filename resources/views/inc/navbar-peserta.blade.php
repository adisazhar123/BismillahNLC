<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-alt" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse navbar-alt" id="navbarNavAltMarkup">
  <div class="navbar-nav">
      <a class="navbar-brand" >Selamat Datang Tim ... <span class="sr-only">(current)</span></a>

  </div>

</div>
<div class="collapse navbar-collapse justify-content-end navbar-alt">
  @if (Auth::check())
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log Out<span class="sr-only">(current)</span></a>
    </div>
  @endif
    </div>
</div>
  <form id="logout-form" action="{{ route('logout') }}" method="POST"
        style="display: none;">
      {{ csrf_field() }}
  </form>
</nav>
