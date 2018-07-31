<div id="load">
  <div class="row">
    @foreach ($pdfs as $pdf)
      <div class="col-sm-6 col-md-4 col-lg-2">
        <div class="card pdf">
          <div class="card-body">

          </div>
          <div class="card-footer">
            <h6>{{$pdf->packet_type}}</h6>
            <div class="row">
              <div class="col-4">
                <a href="{{route('view.pdf.admin', $pdf->id)}}" target="_blank" data-title="Lihat PDF">
                  <i class="fa fa-download fa-lg download" aria-hidden="true" pdf-id={{$pdf->id}}></i>
                </a>
              </div>
              <div class="col-4">
                <a href="{{route('view.pdf.info.admin', $pdf->id)}}" target="_blank" data-title="Lihat PDF" style="color: orange">
                  <i class="fa fa-search fa-lg view" aria-hidden="true" pdf-id={{$pdf->id}}></i>
                </a>
              </div>
              <div class="col-4">
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
</div>

{{ $pdfs->appends(Input::except('page'))->links('vendor.pagination.bootstrap-4') }}
