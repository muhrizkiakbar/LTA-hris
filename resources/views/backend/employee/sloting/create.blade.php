<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.employee.sloting.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department</label></div>
				<div class="col-md-4">{!! Form::select('department_id',$department,null,['class'=>'form-control form-control-sm select2','id'=>'departmentx','required'=>true,'placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Level Jabatan</label></div>
				<div class="col-md-6">{!! Form::select('jabatan_id',$jabatan,null,['class'=>'form-control form-control-sm select2','id'=>'level','required'=>true,'placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department Jabatan</label></div>
				<div class="col-md-6">{!! Form::select('department_jabatan_id',[],null,['class'=>'form-control form-control-sm select2','id'=>'jabatan','required'=>true,'placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Cabang</label></div>
				<div class="col-md-6">{!! Form::select('cabang_id',$cabang,null,['class'=>'form-control form-control-sm select2','id'=>'cabangx','required'=>true,'placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Principle</label></div>
				<div class="col-md-6">{!! Form::select('divisi_id',$divisi,null,['class'=>'form-control form-control-sm select2','id'=>'divisix','required'=>true,'placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
				<div class="col-md-9">{!! Form::select('users_id',[],null,['class'=>'form-control form-control-sm select2','id'=>'user','required'=>true,'placeholder'=>'-- Pilih Karyawan --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button class="btn btn-primary btn-sm" type="submit">Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
		$(".select2").select2({
			width: "100%"
		});

		$("#departmentx").on('change', function () {
			var url = '{{ route('backend.get_department_jabatan') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					department:$("#departmentx").val(),
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
					department:$("#departmentx").val(),
					jabatan:$("#level").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#jabatan").html(response.listdoc);
				},
			});
		});

		$("#cabangx").on('change', function () {
			var url = '{{ route('backend.employee.sloting.employee_cabang') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					department:$("#departmentx").val(),
					jabatan:$("#level").val(),
					department_jabatan:$("#jabatan").val(),
					cabang:$("#cabangx").val(),
					divisi:$("#divisix").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#user").html(response.listdoc);
				},
			});
		});

		$("#divisix").on('change', function () {
			var url = '{{ route('backend.employee.sloting.employee_cabang') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					department:$("#departmentx").val(),
					jabatan:$("#level").val(),
					department_jabatan:$("#jabatan").val(),
					cabang:$("#cabangx").val(),
					divisi:$("#divisix").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#user").html(response.listdoc);
				},
			});
		});

	});
</script>