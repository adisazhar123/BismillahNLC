@extends('layouts.app-admin')


@section('style')
  <style media="screen">
    .card.announce{
      margin-bottom: 5px;
    }

  </style>
@endsection

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>Pengumuman</h4>
			</div>
			<div class="card-body">
				<form action="{{url('/admin/announce')}}" method="POST">
					{{ csrf_field() }}
					<div class="form-group">
					 <label for="name"><strong>Konten</strong></label>
           <textarea name="content" rows="8" cols="80">

           </textarea>
				 </div>
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">

	</div>
</div>

<div class="row">
  <div class="col-lg-12">
      @foreach ($announcements as $a)

  		<div class="card announce">
  			<div class="card-body">
          {{ date_format($a->created_at, 'd/m/Y')}}
          {!! $a->content !!}

  			</div>
        <div class="card-footer">
          <form class="" action="{{url('/admin/delete-announcement')}}" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="id" value="{{$a->id}}">
            <button type="submit" class='btn btn-danger' name="button">Hapus</button>
          </form>
        </div>
  		</div>
    @endforeach
  </div>
</div>


@endsection

@section('script')
  <script type="text/javascript" src='{{asset('js/tinymce/tinymce.js')}}'> </script>
  <script type="text/javascript" src='{{asset('js/tinymce/jquery.tinymce.min.js')}}'> </script>
	<script type="text/javascript">
		$(document).ready( function () {

      var editor_config = {
      path_absolute : "/",
      selector: "textarea",
      height: "60",
      plugins: [
        "advlist autolink lists link charmap preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars fullscreen",
        "nonbreaking save contextmenu directionality",
        "paste textcolor tiny_mce_wiris"
      ],
      paste_data_images: false,
      image_dimensions: false,
      toolbar: "undo redo | bold italic | bullist numlist",
      relative_urls: false
    };

    tinyMCE.init(editor_config);

		@if (session()->has('message'))
			alertify.success('{{session()->get('message')}}')
		@endif

		$("#menu-announcement").addClass('active');


	});


	</script>
@endsection
