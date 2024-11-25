@extends('layouts.backend2.app')
@section('content')
<div id="overlay" style="display:none;">
  <div class="spinner"></div>
  <br/>
  Loading...
</div>
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						<a href="javascipt:void(0);" class="btn btn-primary btn-sm create">Tambah Data</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				@include('backend.template.alert')
				<div class="card">
					<div class="card-body">
						<form method="POST" id="search">
							<div class="form-group row">
								<div class="col-md-1"><label class="col-form-label">Pencarian</label></div>
								<div class="col-md-3">{!! Form::select('klasifikasi',$row['klasifikasi'],null,['class'=>'form-control select-search','id'=>'klasifikasi','placeholder'=>'-- Pilih Klasifikasi --']) !!}</div>
								<div class="col-md-6">{!! Form::select('training',[],null,['class'=>'form-control select-search','id'=>'training','placeholder'=>'-- Pilih Training --']) !!}</div>
								<div class="col-md-1">
									<button type="submit" class="btn btn-primary btn-xs">Search</button>
									{{-- <a href="javascipt:void(0);" class="btn btn-primary btn-sm create">Tambah Data</a> --}}
								</div>
							</div>
						</form>
					</div>
					<div id="view"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
</div>
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){

		$("#klasifikasi").on('change', function () {
			var url = '{{ route('backend.employee.training.search_training') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					klasifikasi:$("#klasifikasi").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#training").html(response.listdoc);
				},
			});
		});

		$(".create").click(function(e) {
      var url = '{{ route('backend.employee.training.create') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

    $("#search").on("submit",function(e){
      e.preventDefault();
      var training = $("#training").val();
      var url = '{{ route('backend.employee.training.search') }}';
			var token = '{{ csrf_token() }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {training:training, _token:token},
        type : "POST",
        success : function(data){
          $('#view').html(data);
        },
        complete : function(data){
          $('#overlay').hide();
        }
      });
    });
  });

	function training_search(training){
		var url = '{{ route('backend.employee.training.search') }}';
		var token = '{{ csrf_token() }}';
		$.ajax({
			url : url,
			data  : {training:training, _token:token},
			type : "POST",
			success : function(data){
				$('#view').html(data);
			}
		});
	}
</script>
@endsection