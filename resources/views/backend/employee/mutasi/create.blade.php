<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.employee.mutasi.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Principle</label></div>
				<div class="col-md-6">{!! Form::select('divisi_id',$divisi,null,['class'=>'form-control select2','placeholder'=>'-- Principle --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department</label></div>
				<div class="col-md-4">{!! Form::select('department_id',$department,null,['class'=>'form-control select2','placeholder'=>'-- Department --','id'=>'department']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Level</label></div>
				<div class="col-md-6">{!! Form::select('m_jabatan_id',$jabatan,null,['class'=>'form-control select2','placeholder'=>'-- Level Jabatan --','id'=>'level']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jabatan</label></div>
				<div class="col-md-6">{!! Form::select('m_department_jabatan_id',[],null,['class'=>'form-control select2','placeholder'=>'-- Jabatan --','id'=>'jabatan']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi Karyawan</label></div>
				<div class="col-md-6">{!! Form::select('lokasi_idx',$lokasi,null,['class'=>'form-control select2','id'=>'lokasi_karyawan','placeholder'=>'-- Lokasi Karyawan --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
				<div class="col-md-6">{!! Form::select('users_id',[],null,['class'=>'form-control select2','placeholder'=>'-- Pilih Karyawan --','id'=>'users_id']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Status Mutasi</label></div>
				<div class="col-md-4">{!! Form::select('mutasi_sts_id',$mutasi,null,['class'=>'form-control select2','placeholder'=>'-- Pilih Status Mutasi --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Mutasi</label></div>
				<div class="col-md-4">{!! Form::text('tgl_mutasi',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi Sekarang</label></div>
				<div class="col-md-6">{!! Form::select('lokasi_id',$lokasi,null,['class'=>'form-control select2','placeholder'=>'-- Lokasi Kerja --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Atasan Langsung</label></div>
				<div class="col-md-6">{!! Form::select('atasan_id',$atasan,null,['class'=>'form-control select2','placeholder'=>'-- Pilih Atasan Langsung --']) !!}</div>
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
			width: '100%'
		});

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

		$("#lokasi_karyawan").on('change', function () {
			var url = '{{ route('backend.employee.mutasi.employee_department') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					lokasi_karyawan:$("#lokasi_karyawan").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#users_id").html(response.listdoc);
				},
			});
		});



	});
</script>