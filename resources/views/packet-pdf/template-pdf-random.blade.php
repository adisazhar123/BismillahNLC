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

    </style>

  </head>
  <body>
    <p>Paket soal: {{$identifier}}</p>
    <p>
      <strong>Pilihlah 1 jawaban yang paling benar!</strong>
    </p>
    <div class="content">
      <ol>
       @foreach ($non_related as $question)
          <li>
            {!!str_replace('<p>', '', $question['question'])  !!}
              <ol type="A">
                @for ($i=1; $i <= 5; $i++)
                  <li>
                    {!! $question['option_'.$i] !!}
                  </li>
                @endfor
              </ol>
          </li>
        @endforeach
        @foreach ($related as $question)
          @if (!empty($question->description))
            {!!str_replace('<p>', '', $question['description']). "<br>"     !!}
          @endif
           <li>
             {!!str_replace('<p>', '', $question['question'])  !!}
               <ol type="A">
                 @for ($i=1; $i <= 5; $i++)
                   <li>
                     {!! $question['option_'.$i] !!}
                   </li>
                 @endfor
               </ol>
           </li>
         @endforeach
        </ol>
    </div>
  </body>
</html>
