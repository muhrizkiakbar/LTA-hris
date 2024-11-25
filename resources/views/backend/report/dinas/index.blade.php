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
								<div class="col-md-3">{!! Form::select('department',$department,null,['class'=>'form-control select2','id'=>'department','placeholder'=>'-- Pilih Department --','required']) !!}</div>
								<div class="col-md-2">{!! Form::select('lokasi',$lokasi,null,['class'=>'form-control select2','id'=>'lokasi','placeholder'=>'-- Pilih Lokasi --','required']) !!}</div>
								<div class="col-md-2">{!! Form::text('periode',null,['class'=>'form-control datepick','id'=>'periode','data-range'=>'true','data-language'=>'en','data-multiple-dates-separator'=>' - ','required'=>true]) !!}</div>
								<div class="col-md-3">
									<a href="javascript:void(0);" class="btn btn-info waves-effect waves-light" id="searchx">
										Search
									</a>
									<a href="javascript:void(0);" class="btn btn-warning waves-effect waves-light" id="btnexport">
										Export
									</a>
								</div> 
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				<div id="search_result"></div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
		$('.datepick').datepicker();

		$(".select2").select2({
			width: '100%'
		});

		$("#search").on("submit",function(e){
      e.preventDefault();
      var department = $("#department").val();
      var lokasi = $("#lokasi").val();
      var periode = $("#periode").val();
			var token = '{{ csrf_token() }}';
      var url = '{{ route('backend.report.absensi.generate') }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {department:department, lokasi:lokasi, periode:periode, _token:token},
        type : "POST",
        complete : function(data){
          $('#overlay').hide();
        }
      });
    });

		$("#searchx").click(function (e) {
			e.preventDefault();
      var department = $("#department").val();
      var lokasi = $("#lokasi").val();
      var periode = $("#periode").val();
			var token = '{{ csrf_token() }}';
      var url = '{{ route('backend.report.dinas_search') }}';
			$('#overlay').fadeIn();
			$.ajax({
        url : url,
        data  : {department:department, lokasi:lokasi, periode:periode, _token:token},
        type : "POST",
        success : function(data){
          $('#search_result').html(data);
        },
        complete : function(data){
          $('#overlay').hide();
        }
      });

			$("#btnexport").click(function () {
      var tT = new XMLSerializer().serializeToString(document.querySelector('div#search_result')); //Serialised table
      var tF = 'Report Perjalanan Dinas.xls'; //Filename
      var tB = new Blob([tT]); //Blub
      
      if(window.navigator.msSaveOrOpenBlob){
        //Store Blob in IE
        window.navigator.msSaveOrOpenBlob(tB, tF)
      }
      else{
        //Store Blob in others
        var tA = document.body.appendChild(document.createElement('a'));
        tA.href = URL.createObjectURL(tB);
        tA.download = tF;
        tA.style.display = 'none';
        tA.click();
        tA.parentNode.removeChild(tA)
      }
    });
		});
	});
</script>
@endsection