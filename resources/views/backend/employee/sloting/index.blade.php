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
								<div class="col-md-3">{!! Form::select('department',$department,null,['class'=>'form-control select-search','id'=>'department','placeholder'=>'-- Pilih Department --']) !!}</div>
								<div class="col-md-3">{!! Form::select('cabang',$cabang,null,['class'=>'form-control select-search','id'=>'cabang','placeholder'=>'-- Pilih Cabang --']) !!}</div>
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

		var swalInit = swal.mixin({
			buttonsStyling: false,
			customClass: {
				confirmButton: 'btn btn-primary',
				cancelButton: 'btn btn-light',
				denyButton: 'btn btn-light',
				input: 'form-control'
			}
		});

		$(".create").click(function(e) {
      var url = '{{ route('backend.employee.sloting.create') }}';
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
      var department = $("#department").val();
			var cabang = $("#cabang").val();
      var url = '{{ route('backend.employee.sloting.search') }}';
			var token = '{{ csrf_token() }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {department:department, cabang:cabang, _token:token},
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

	function sloting_search(department, cabang){
		var url = '{{ route('backend.employee.sloting.search') }}';
		var token = '{{ csrf_token() }}';
		$.ajax({
        url : url,
        data  : {department:department, cabang:cabang, _token:token},
        type : "POST",
        success : function(data){
          $('#view').html(data);
        }
      });
	}
</script>
@endsection