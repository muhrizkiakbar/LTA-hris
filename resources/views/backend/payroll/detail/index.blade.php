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
								<div class="col-md-1"><label class="col-form-label">Pencarian</label></div>
								<div class="col-md-3">{!! Form::select('department',$department,null,['class'=>'form-control select2','id'=>'department','placeholder'=>'-- Pilih Department --']) !!}</div>
								<div class="col-md-3">
									<button type="submit" class="btn btn-success waves-effect waves-light">
										Search
									</button>
									<a href="javascript:void(0);" class="btn btn-info" onclick="exportExcel()">Export</a>
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
		loadView();

		$('.datepick').datepicker();

		$(".select2").select2({
			width: '100%'
		});

		$("#search").on("submit",function(e){
      e.preventDefault();
      var department = $("#department").val();
			var payroll_id = '{{ $payroll_id }}';
			var token = '{{ csrf_token() }}';
      var url = '{{ route('backend.payroll.detail_view') }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {department:department, payroll_id:payroll_id, _token:token},
        type : "POST",
				success : function(data){
          $('#search_result').html(data);
        },
        complete : function(data){
          $('#overlay').hide();
        }
      });
    });

		$("#export").on("submit",function(e){
      e.preventDefault();
			var payroll_id = '{{ $payroll_id }}';
			var token = '{{ csrf_token() }}';
      var url = '{{ route('backend.payroll.export') }}';
      $('#overlay').fadeIn();
      $.ajax({
        url : url,
        data  : {payroll_id:payroll_id, _token:token},
        type : "POST",
				success : function(data){
          $('#search_result').html(data);
        },
        complete : function(data){
          $('#overlay').hide();
        }
      });
    });
	});

	function loadView() {
		var department = $("#department").val();
		var payroll_id = '{{ $payroll_id }}';
		var token = '{{ csrf_token() }}';
		var url = '{{ route('backend.payroll.detail_view') }}';
		$.ajax({
			url : url,
			data  : {department:department, payroll_id:payroll_id, _token:token},
			type : "POST",
			success : function(data){
				$('#search_result').html(data);
			}
		});
	}

	function exportExcel() {
		var payroll_id = '{{ $payroll_id }}';

		var url = `/backend/payroll/export?payroll_id=${payroll_id}`;
		window.location = url
	}
</script>
@endsection