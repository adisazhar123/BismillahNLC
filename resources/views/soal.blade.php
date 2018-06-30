<!doctype html>
<html>
	<head>
		<style>
		html,body{
			margin:40px!important;
			font-family:Helvetica;
			font-size:11pt;
			text-align:justify;
		}
		ul{
			padding-left:25px;
		}
		.a{
			list-style:none;
		}
		.a .n{
			position:absolute;
			left:0;
		}
		p{
			line-height:1.5em;
		}
		.c{
			margin-bottom:20px;
		}
		li > p{
			margin-top:-2px;
		}
		.page-break {
			page-break-after: always;
		}
		</style>
	</head>
	<body>
		<p><b>Pilihlah 1 jawaban yang paling benar!</b></p>
		@php $num = 1 @endphp
		@foreach ($soal as $d)
		@if ($d[0] == "page-break")
			<div class="page-break"></div>
		@elseif (isset($d[1]))
		<ul class="a">
			<div class="n">{{$num}}.</div>
			<li class="c">
				<p>{!!$d[0]!!}</p>
				<ul type="a">
					@foreach ($d[1] as $p)
					<li>{{$p}}</li>
					@endforeach
				</ul>
			</li>
		</ul>
		@php $num++ @endphp
		@else
		<p>{!!$d[0]!!}</p><br>
		@endif
		@endforeach
	</body>
</html>