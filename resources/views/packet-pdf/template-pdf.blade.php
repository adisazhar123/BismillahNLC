<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>

    <style media="screen">
    body{
      font-style: Calibri;
      line-height: 1;
    }

    </style>

  </head>
  <body>

<ol>
  {{-- <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwfMzZWidbLDPeiep0Gtn2B1pi_1GGtgBQrKcxpJSnuCDSQ3KidQ" alt=""> --}}
  <img src="{{asset('storage/photos/9/mazda_rx8_2006_car_for_parts_only_238086_01.jpg')}}" alt="">
        {{-- @foreach ($questions as $question)
        <li>
          {!! str_replace('/laravel-filemanager', '/storage', $question->question) !!}
          {!! str_replace('/laravel-filemanager', '/storage', $question->option_1) !!}
        </li>
      @endforeach --}}
      </ol>
  </body>
</html>
