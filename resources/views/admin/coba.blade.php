@extends('layouts.app-admin')

@section('main')
  <h1>TinyMCE Quick Start Guide</h1>
    <form action="#">
      <textarea id="mytextarea">Hello, World!</textarea>
      <button type="submit" name="button">submit</button>
    </form>
@endsection

@section('script')
  {{-- <script type="text/javascript" src='{{asset('js/tinymce/jquery.tinymce.min.js')}}'> </script> --}}
  <script type="text/javascript" src='{{asset('js/tinymce/tinymce.min.js')}}'> </script>
  <script>

  $(document).ready(function(){

    var editor_config = {
    path_absolute : "/",
    selector: "textarea",
    height: "300",
    plugins: [
      "advlist autolink lists link image charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars code fullscreen",
      "insertdatetime media nonbreaking save table contextmenu directionality",
      "emoticons template paste textcolor colorpicker textpattern codesample imagetools"
    ],
    toolbar: "fontselect |  fontsizeselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | codesample",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'NLC Online 2018',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
    };

    tinymce.init(editor_config);

  })

  </script>

  <script type="text/javascript">
    $(document).on('submit', function(e){
      e.preventDefault()
      console.log($('textarea').val())
    })
  </script>
@endsection
