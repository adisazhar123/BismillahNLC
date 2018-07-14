@extends('layouts.app-admin')

@section('style')
<style media="screen">
  .pdf {
    text-align: center;
    border-radius: 3px;
    transition: 200ms ease-in-out;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    background-color: rgba(0,0,0,0);
    overflow-y: hidden ! important;
    overflow-x: hidden ! important;
  }

  .pdf:hover {
  	box-shadow: 0 0 5px rgba(0,0,0,0.7);
  }

  .fa:hover{
    cursor: pointer;
  }

</style>
@endsection

@section('main')
  <br>
  <div class="row">
    <div class="col-lg-12">
      @if ($search_empty == 1)
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Keterangan</h4>
          <ul>
            <li>
              Tidak ada <i>generated</i> PDF untuk dengan <i>keyword</i> {{Input::get('keywords')}}.
            </li>
          </ul>
          <hr>
          <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
        </div>
      @elseif (!$pdfs->total())
        <div class="alert alert-danger" role="alert">
          <h4 class="alert-heading">Keterangan</h4>
          <ul>
            <li>
              Tidak ada <i>generated</i> PDF untuk paket ini.
            </li>
            <li>
              Anda bisa <i>generate</i> PDF <a href="{{url('admin/generate-pdf')}}">disini</a>.
          </li>
          </ul>
          <hr>
          <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
        </div>
      @else
        <div class="alert alert-info" role="alert">
          <h4 class="alert-heading">Kumpulan PDF untuk paket {{''}}</h4>
          <ul>
            <li>Untuk melihat hasil PDF klik icon berwarna hijau disebelah kiri-bawah.</li>
            <li>Untuk menghapus hasil PDF klik icon berwarna merah disebelah kanan-bawah.</li>
          </ul>
          <hr>
          <p class="mb-0">Jika ada masalah yang muncul, mohon untuk menghubungi WebKes.</p>
        </div>

      @endif



      <form action="{{url('/admin/list-pdf', 1)}}" id="search_pdf">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search" aria-describedby="basic-addon1" name="keywords">
          <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button">Search</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  @if ($pdfs->total())
    <section class="pdfs">
      @include('admin.partial-list-pdf')
    </section>
  @endif

  <form action="{{route('delete.pdf.admin')}}" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="id" value="" id="id">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
  </form>

@endsection

@section('script')
<script type="text/javascript">
  $(".delete").click(function(){
    id = $(this).attr('pdf-id');
    $("#id").val(id)
    $("form").trigger("submit")
  });


  @if (session('status'))
    alertify.success('{{session('status')}}')
  @endif

  $('body').on('click', '.pagination a', function(e) {
    e.preventDefault();

    $('#load a').css('color', '#dfecf6');
    //$('#load').append('<img style="position: absolute; left: 0; top: 0; z-index: 100000;" src="/images/loading.gif" />');

    var url = $(this).attr('href');
    getPdfs(url);
    window.history.pushState("", "", url);
  });

  function getPdfs(url) {
      $.ajax({
          url : url
      }).done(function (data) {
          $('.pdfs').html(data);
      }).fail(function () {
          alert('Articles could not be loaded.');
      });
  }


</script>
@endsection
