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
						{{-- <a href="javascipt:void(0);" class="btn btn-primary btn-sm create">Tambah Data</a> --}}
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
								<div class="col-md-3">{!! Form::select('department',$department,null,['class'=>'form-control select2','id'=>'department','placeholder'=>'-- Pilih Department --']) !!}</div>
								<div class="col-md-3">{!! Form::select('lokasi',$lokasi,null,['class'=>'form-control select2','id'=>'lokasi','placeholder'=>'-- Pilih Lokasi --']) !!}</div>
								<div class="col-md-2">
									<button type="submit" class="btn btn-primary btn-sm">Search</button>
									<a href="javascript:void(0);" class="btn btn-warning btn-sm" id="btnexport">
										Export
									</a>
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
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
		$(".select2").select2();

    $("#search").on("submit",function(e){
      e.preventDefault();
      var department = $("#department").val();
			var lokasi = $("#lokasi").val();
      var url = '{{ route('backend.report.kelengkapan_search') }}';
			var token = '{{ csrf_token() }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {department:department, lokasi:lokasi, _token:token},
        type : "POST",
        success : function(data){
          $('#view').html(data);
        },
        complete : function(data){
          $('#overlay').hide();
        }
      });
    });

		$("#btnexport").click(function () {
      var tT = new XMLSerializer().serializeToString(document.querySelector('div#view')); //Serialised table
      var tF = 'Kelengkapan Dokumen Karyawan.xls'; //Filename
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
</script>
@endsection