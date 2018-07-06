@extends('layouts.app-admin')

@section('style')
<style media="screen">
.pdf {
  background: url('https://www.shareicon.net/data/256x256/2016/08/13/808584_document_512x512.png');
  background-size: contain;
  background-repeat: no-repeat;
  background-position: right;
  text-align: center;
  border-radius: 3px;
  transition: 200ms ease-in-out;
  box-shadow: 0 0 10px rgba(0,0,0,0.3);
  background-color: rgba(0,0,0,0);
  overflow-y: hidden ! important;
  overflow-x: hidden ! important;
}

.pdf:hover {
	margin-bottom: -10px;
	box-shadow: 0 0 5px rgba(0,0,0,0.7);
}
.pdf h6 {
	color: black;
	padding: 32px;
	margin-top: 210px;
	text-align: center;
  margin-bottom: -30px;
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
      @if (!$pdfs->total())
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
    </div>


  </div>
  <div class="row">
    @foreach ($pdfs as $pdf)
      <div class="col-sm-6 col-md-4 col-lg-2">
        <div class="card pdf">
          <div class="card-body">
            <h6>{{$pdf->packet_type}}</h6>
            <div class="row">
              <div class="col-6">
                <a href="{{route('view.pdf.admin', $pdf->id)}}" target="_blank" data-title="Lihat PDF">
                  <i class="fa fa-download fa-lg download" aria-hidden="true" pdf-id={{$pdf->id}}></i>
                </a>
              </div>
              <div class="col-6">
                <a href="#" style="color: red">
                  <i class="fa fa-trash-o fa-lg delete" aria-hidden="true" pdf-id={{$pdf->id}}></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  {{ $pdfs->links('vendor.pagination.bootstrap-4') }}

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


</script>
@endsection
