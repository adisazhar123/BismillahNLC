@extends('layouts.app-admin')

@section('style')
<style media="screen">
	table .btn{
		margin-bottom: 3px;
		margin-left: 3px;
	}

	#field_description{
		display: none;
	}
</style>
@endsection

@section('main')

<br>

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4>List soal paket {{$packet_name}}</h4>
				<button style="float: right" type="button" name="button" class="btn btn-primary" id='add_question'>Tambah Soal</button>

			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table id="table_id" class="table table-striped table-hover">
					    <thead>
					        <tr>
											<th>#</th>
					            <th>Soal</th>
											<th>Action</th>
					        </tr>
					    </thead>
					    <tbody>


					    </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>

<div class="modal question fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
			<div class="modal-header">
			 <h5 class="modal-title">Modal title</h5>
			 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				 <span aria-hidden="true">&times;</span>
			 </button>
		 </div>
		 <div class="modal-body">
			 <form action="#">
				 {{ csrf_field() }}
				 <input type="hidden" name="id_packet" value="{{$id_packet}}">
				 <input type="hidden" name="id_question" id="id_question" value="">
				 <div class="form-group" id="field_description">
			     <label for="description">Petunjuk/ Deskripsi</label>
					 <textarea name="description" id="description"></textarea>
			   </div>
		   <div class="form-group">
		     <label for="question">Soal</label>
				 <textarea name="question" id="question"></textarea>
		   </div>
			 <div class="form-group">
				<label for="option_1">Pilihan A</label>
				<textarea name="option_1" id="option_1"></textarea>
			</div>
			<div class="form-group">
			 <label for="option_2">Pilihan B</label>
			 <textarea name="option_2" id="option_2"></textarea>
		 </div>
			 <div class="form-group">
				<label for="option_3">Pilihan C</label>
				<textarea name="option_3" id="option_3"></textarea>
			</div>
			<div class="form-group">
			 <label for="option_4">Pilihan D</label>
			 <textarea name="option_4" id="option_4"></textarea>
		 </div>
		 <div class="form-group">
			<label for="option_5">Pilihan E</label>
			<textarea name="option_5" id="option_5"></textarea>
		</div>
		<div class="form-group">
			<label for="right_ans">Kunci Jawaban</label>
			<select class="form-control" id="right_ans" name="right_ans">
				<option value=''></option>
				<option value='1' id="select_option_1">A</option>
				<option value='2' id="select_option_2">B</option>
				<option value='3' id="select_option_3">C</option>
				<option value='4' id="select_option_4">D</option>
				<option value='5' id="select_option_5">E</option>
			</select>
		</div>
		<div class="form-group">
			<label for="related">Soal Cerita/ Berurutan</label>
			<select class="form-control" id="related" name="related">
				<option value='0'>Tidak</option>
				<option value='1'>Iya</option>
			</select>
		</div>


		 </div>
		 <div class="modal-footer">
			 <button type="submit" class="btn btn-primary">Submit</button>
		 	</form>
			 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		 </div>
    </div>
  </div>
</div>

@endsection

@section('script')

	<script type="text/javascript" src='{{asset('js/tinymce/tinymce.js')}}'> </script>
	<script type="text/javascript" src='{{asset('js/tinymce/jquery.tinymce.min.js')}}'> </script>
	<script type="text/javascript">
		$(document).ready( function () {
			var action, url, method;
			var table1;

			table1 = $('#table_id').DataTable({
				responsive: true,
				stateSave: true,
				ajax: "{{route('get.questions.admin', $id_packet)}}"
			});

			var editor_config = {
			path_absolute : "/",
			selector: "textarea",
			height: "60",
			plugins: [
				"advlist autolink lists link image charmap preview hr anchor pagebreak",
				"searchreplace wordcount visualblocks visualchars fullscreen",
				"media nonbreaking save table contextmenu directionality",
				"paste textcolor imagetools tiny_mce_wiris"
			],
			paste_data_images: true,
			image_dimensions: true,
			toolbar: "undo redo | bold italic | bullist numlist | image tiny_mce_wiris_formulaEditor paste",
			relative_urls: false,
			file_browser_callback : function(field_name, url, type, win) {
				var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
				var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

				// NOTE:
				// Kalau tidak pake XAMPP hilangkan bismillahNLC/public/
				var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
				// var cmsURL = editor_config.path_absolute + 'bismillahNLC/public/laravel-filemanager?field_name=' + field_name;
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

		tinyMCE.init(editor_config);

		$("#related").change(function(){
			if ($(this).val() == "1")
				$("#field_description").css('display','block')
			else
				$("#field_description").css('display','none')

		})

		$(document).on('click', '#edit', function(){

			question_id = $(this).attr('question-id')
			$("#id_question").val(question_id);
			action = "update";
			method = "PUT";
			url = '{{route('update.question.admin')}}';

			$.ajax({
				url: '{{route('get.question.details.admin')}}',
				data: {question_id},
				success: function(data){
					tinyMCE.get('description').setContent('');
					tinyMCE.get('question').setContent(data.question);
					tinyMCE.get('option_1').setContent(data.option_1);
					tinyMCE.get('option_2').setContent(data.option_2);
					tinyMCE.get('option_3').setContent(data.option_3);
					tinyMCE.get('option_4').setContent(data.option_4);
					tinyMCE.get('option_5').setContent(data.option_5);

					if (data.related == 1) {
						if (data.description != null) tinyMCE.get('description').setContent(data.description);
						$("#field_description").css('display', 'block')
					}else{
						$("#field_description").css('display', 'none')
					}
					$("#related").val(data.related);

					for (var i = 1; i <= 5; i++) {
						if ("option_"+data.right_ans == "option_"+i){
							$("#right_ans").val(i);
						}
					}

					$(".modal.question").modal('show')
				},
				error: function(){
					alert("Server error")
				}
			})

		})

		$('#add_question').click(function(){

			action = "new";
			method = "POST";
			url = '{{route('add.new.question.admin')}}';

			tinyMCE.get('question').setContent("");
			tinyMCE.get('question').setContent("");
			tinyMCE.get('option_1').setContent("");
			tinyMCE.get('option_2').setContent("");
			tinyMCE.get('option_3').setContent("");
			tinyMCE.get('option_4').setContent("");
			tinyMCE.get('option_5').setContent("");
			$(".modal.question").modal('show');
		});

		$(document).on('submit', 'form', function(e){
			 tinyMCE.triggerSave();
			e.preventDefault();
			$.ajax({
				url: url,
				method: method,
				data: $(this).serialize(),
				success: function(data){
					if(data == "ok"){
						if (action == "new")
							alertify.success('Penambahan soal berhasil!');
						else
							alertify.success('Pembaharuan soal berhasil!');
					}else{
						if (action == "new")
							alertify.error('Penambahan soal gagal!');
						else
							alertify.error('Pembaharuan soal gagal!');
					}
					table1.ajax.reload(null, false)
					$(".modal.question").modal('hide');
				},
				error: function(){
					alertify.error('Server error!');
				}
			});
		});

		$(document).on('click', '#delete', function(){
			id_question = $(this).attr('question-id');
			$.ajaxSetup({
		    headers: {
		        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		    }
			});

			$.ajax({
				url: '{{route('delete.question.admin')}}',
				method: "DELETE",
				data: {id_question},
				success: function(data){
					if(data =="ok")
						alertify.success('Penghapusan soal berhasil!');
					else
						alertify.error('Penghapusan soal gagal!');
					table1.ajax.reload(null, false);
				},
				error: function(){
					alertify.error('Server error!');

				}
			})

		})

	});



	$(document).ready(function(){



	})


	</script>
@endsection
