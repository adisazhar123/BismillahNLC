<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>

    <style media="screen">
    body{
      font-size: 11;
      text-align: justify;
    }
    #watermark {
              position: fixed;
              bottom:   0px;
              left:     0px;
              /** The width and height may change
                  according to the dimensions of your letterhead
              **/
              width:    21.8cm;
              height:   28cm;

              /** Your watermark should be behind every content**/
              z-index:  -1000;
              opacity: 0.3;
          }
          @page {
              margin: 0cm 0cm;
          }
    </style>

  </head>
  <body>
    <div id="watermark">
      <img src="http://www.color-hex.com/palettes/7808.png" alt="" height="100%" width="100%">
    </div>
    <p>
      <strong>Pilihlah 1 jawaban yang paling benar!</strong>
    </p>
    <div class="content">
      <ol>
       @foreach ($questions as $question)
         @if (!empty($question->description))
           {!!str_replace('<p>', '', $question['description']) . "<br>"   !!}
         @endif
          <li>
            {!!str_replace('<p>', '', $question['question'])!!}
              <ol type="A">
                @for ($i=1; $i <= 5; $i++)
                  <li>
                    {!! str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i])) !!}
                  </li>
                @endfor
              </ol>
          </li>
        @endforeach
        </ol>
    </div>
  </body>
</html>
