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
  <?php // BUG:
    // Bug in a, b,.., e, when its the answer
  ?>
  <body>
    <p>Paket soal: {{$identifier}}</p>
    <p>
      <strong>Pilihlah 1 jawaban yang paling benar!</strong>
    </p>
    <div class="content">
      <ol>
       @foreach ($non_related as $question)
         <small>Soal ID: {{$question['id_question']}}</small>
          <li>
            {!!str_replace('<p>', '', $question['question'])  !!}
              <ol type="A">
                @for ($i=1; $i <= 5; $i++)
                  @if ($i == $question['right_ans'])
                  <strong>
                    <li>
                      {!! str_replace('<img','<br><img', str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i]))) !!}
                    </li>
                  </strong>
                @elseif ($i != $question['right_ans'])
                    <li>
                      {!! str_replace('<img','<br><img', str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i]))) !!}
                    </li>
                  @endif

                @endfor
              </ol>
          </li>
        @endforeach
        @foreach ($related as $question)
          @if (!empty($question->description))
            {!!str_replace('<p>', '', $question['description']). "<br>"     !!}
          @endif
          <small>Soal ID: {{$question['id_question']}}</small>
           <li>
             {!!str_replace('<p>', '', $question['question'])  !!}
               <ol style="list-style-type: upper-latin">
                 @for ($i=1; $i <= 5; $i++)
                   @if ($i == $question['right_ans'])
                   <strong>
                     <li>
                       {!! str_replace('<img','<br><img', str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i]))) !!}
                     </li>
                   </strong>
                 @elseif ($i != $question['right_ans'])
                     <li>
                       {!! str_replace('<img','<br><img', str_replace('</p>', '', str_replace('<p>', '', $question['option_'.$i]))) !!}
                     </li>
                   @endif
                 @endfor
               </ol>
           </li>
         @endforeach
        </ol>
    </div>
  </body>
</html>
