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
								<div class="col-md-2"><label class="col-form-label">Nama Lengkap</label></div>
								<div class="col-md-4">{!! Form::text('name',null,['class'=>'form-control','id'=>'name','required'=>true]) !!}</div>
							</div>
							<div class="form-group row">
								<div class="col-md-2"><label class="col-form-label">Tanggal Lahir</label></div>
								<div class="col-md-3">{!! Form::text('tanggal_lahir',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','id'=>'tanggal_lahir','readonly'=>true,'required'=>true]) !!}</div>
							</div>
							<div class="form-group row">
								<div class="col-md-2"><label class="col-form-label">Nomor KTP</label></div>
								<div class="col-md-4">{!! Form::text('ktp_no',null,['class'=>'form-control','id'=>'ktp_no','required'=>true]) !!}</div>
							</div>
							<div class="form-group row">
								<div class="col-md-2"></div>
								<div class="col-md-3">
									<button type="submit" class="btn btn-primary btn-xs">Search</button>
									{{-- <a href="javascipt:void(0);" class="btn btn-primary btn-sm create">Tambah Data</a> --}}
								</div>
							</div>
						</form>
					</div>
				</div>
				<div id="view"></div>
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
		$('.datepick').datepicker({
    	autoClose:true
    });

    $("#search").on("submit",function(e){
      e.preventDefault();
      var name = $("#name").val();
			var tanggal_lahir = $("#tanggal_lahir").val();
			var ktp_no = $("#ktp_no").val();
      var url = '{{ route('backend.employee.verifikasi_employee_search') }}';
			var token = '{{ csrf_token() }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {name:name, tanggal_lahir:tanggal_lahir, ktp_no:ktp_no, _token:token},
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
</script>
@endsection