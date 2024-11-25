@extends('layouts.backend2.app')
@section('content')
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
				<div class="card">
					<div class="card-body">
						{!! Form::open(['route'=>'backend.employee.store','method'=>'POST','files' => true]) !!}
						<div class="row">
							<div class="col-md-6">
								@include('backend.employee.create.form-left')
							</div>
							<div class="col-md-6">
								@include('backend.employee.create.form-right')
								<div class="form-group row">
									<div class="col-md-4">
										<button class="btn btn-success" type="submit">Simpan</button>
									</div>
								</div>
							</div>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- <div class="content">
	
</div> --}}
<!-- /content area -->
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2();

    $('.datepick').datepicker({
    	autoClose:true
    });
	
		$("#department").on('change', function () {
			var url = '{{ route('backend.get_department_jabatan') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					department:$("#department").val(),
					jabatan:$("#level").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#jabatan").html(response.listdoc);
				},
			});
		});

		$("#level").on('change', function () {
			var url = '{{ route('backend.get_department_jabatan') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					department:$("#department").val(),
					jabatan:$("#level").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#jabatan").html(response.listdoc);
				},
			});
		});

	});
</script>
@endsection
