<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>

    <style>
    /*@page {
    margin: 0cm 0cm;
    }*/
    body{
    font-size: 11;
    text-align: justify;
    font-family:Helvetica;
    }
    #watermark {
    position: fixed;
    bottom:   0px;
    left:     0px;
    /** The width and height may change
    according to the dimensions of your letterhead
    **/
    width:    21.8cm;
    height:   27cm;

    /** Your watermark should be behind every content**/
    z-index:  -1000;
    opacity: 0.3;
    }

    .page_break {
    page-break-after: always;
    text-align: center;
    justify-content: center;
    }

    .pages {
    margin: .5in;
    }
    .first-page {
    margin: 0in;
    color: green;
    height: 100%;
    width: 100%;
    margin:-50px;
    position:absolute;
    page-break-after: always;
    }
    .p{
    padding-bottom:15px;
    }
    </style>

  </head>
  <body>

	<div class="pages first-page">
		<img src="{{ resource_path('assets/watermark/c.png') }}" width="100%">
	</div>

	<div id="watermark">
      <img src="{{ resource_path('assets/watermark/w.jpg') }}" height="100%" style="margin-bottom:-20px">
    </div>

	<div class="content">
	  <div>
		<p>Paket soal: {{$identifier}}</p>
		<p>ID: {{$type}}</p><br>
		<p><strong>Pilihlah 1 jawaban yang paling benar!</strong></p>
	  </div>
      <ol>
       @foreach ($questions as $question)
         @if (!empty($question->description))
           {!!str_replace('<p>', '', $question['description']) . "<br>"   !!}
         @endif
          <li class="p">
            {!!str_replace('<p>', '', $question['question'])!!}
              <ol type="A">
                @for ($i=1; $i <= 5; $i++)
                  <li>
                    {!! str_replace('<img','<br><img', str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i]))) !!}
                  </li>
                @endfor
              </ol>
          </li>
        @endforeach
        </ol>
    </div>
  </body>
</html>
