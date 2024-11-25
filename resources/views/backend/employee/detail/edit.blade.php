<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Edit Data Karyawan</h6>
		</div>
		<div class="modal-body">
			{!! Form::model($row,['route'=>['backend.employee.update',$row->id],'method'=>'PUT','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Foto Karyawan</label></div>
				<div class="col-md-6">
					{!! $row->image_pic !!}
					<div class="mt-2">
						{!! Form::file('foto') !!}
					</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">NIK</label></div>
				@if ($role==1 || $role==3)
				<div class="col-md-4">{!! Form::text('nik',null,['class'=>'form-control','required'=>true]) !!}</div>	
				@else
				<div class="col-md-4">{!! Form::text('nik',null,['class'=>'form-control','readonly'=>true]) !!}</div>	
				@endif
				<input type="hidden" name="id" id="employee_id" value="{{ $row->id }}">
			</div>
			@if ($row->department_id==3)
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Sales Code SAP</label></div>
				<div class="col-md-4">{!! Form::text('sales_code',null,['class'=>'form-control']) !!}</div>
			</div>
			@endif
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Masuk</label></div>
				<div class="col-md-4">{!! Form::text('join_date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Nama</label></div>
				<div class="col-md-8">{!! Form::text('name',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Email Kantor</label></div>
				<div class="col-md-8">{!! Form::text('email',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Email Pribadi</label></div>
				<div class="col-md-8">{!! Form::text('email_kantor',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Distrik</label></div>
				<div class="col-md-4">{!! Form::select('distrik_id',$distrik,NULL,['class'=>'form-control select2','placeholder'=>'-- Distrik --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi</label></div>
				<div class="col-md-4">{!! Form::select('lokasi_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Lokasi --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Perusahaan</label></div>
				<div class="col-md-6">{!! Form::select('perusahaan_id',$perusahaan,null,['class'=>'form-control select2','placeholder'=>'-- Perusahaan --','id'=>'perusahaan','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Principal</label></div>
				<div class="col-md-6">{!! Form::select('divisi_id',$divisi,null,['class'=>'form-control select2','placeholder'=>'-- Principal --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Claim Principal</label></div>
				<div class="col-md-6">{!! Form::select('claim_principal_id',$claim_principal,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department</label></div>
				<div class="col-md-6">{!! Form::select('department_id',$department,null,['class'=>'form-control select2','placeholder'=>'-- Department --','id'=>'department','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Level</label></div>
				<div class="col-md-6">{!! Form::select('jabatan_id',$jabatan,null,['class'=>'form-control select2','placeholder'=>'-- Level Jabatan --','id'=>'level','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jabatan</label></div>
				<div class="col-md-6">{!! Form::select('department_jabatan_id',[],null,['class'=>'form-control select2','placeholder'=>'-- Jabatan --','id'=>'jabatan','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Atasan Langsung</label></div>
				<div class="col-md-6">{!! Form::select('atasan_id',$atasan,null,['class'=>'form-control select2','required'=>true,'placeholder'=>'-- Atasan Langsung --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">No Handphone</label></div>
				<div class="col-md-4">{!! Form::text('no_hp',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tempat Lahir</label></div>
				<div class="col-md-4">{!! Form::text('tempat_lahir',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Lahir</label></div>
				<div class="col-md-4">{!! Form::text('tgl_lahir',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jenis Kelamin</label></div>
				<div class="col-md-4">{!! Form::select('gender_id',$gender,NULL,['class'=>'form-control select2','placeholder'=>'-- Jenis Kelamin --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Agama</label></div>
				<div class="col-md-4">{!! Form::select('religion_id',$religion,NULL,['class'=>'form-control select2','placeholder'=>'-- Agama --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Status Pernikahan</label></div>
				<div class="col-md-4">{!! Form::select('marriage_id',$marriage,NULL,['class'=>'form-control select2','placeholder'=>'-- Status Pernikahan --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Golongan Darah</label></div>
				<div class="col-md-4">{!! Form::select('blood_id',$blood,NULL,['class'=>'form-control select2','placeholder'=>'-- Golongan Darah --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jenis PTKP</label></div>
				<div class="col-md-4">{!! Form::select('ptkp_id',$ptkp,null,['class'=>'form-control select2','placeholder'=>'-- Jenis PTKP --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kewarganegaraan</label></div>
				<div class="col-md-6">{!! Form::select('country_id',$country,NULL,['class'=>'form-control select2','placeholder'=>'-- Kewarganegaraan --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Suku Bangsa</label></div>
				<div class="col-md-4">{!! Form::text('suku',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">BPJSTK</label></div>
				<div class="col-md-4">{!! Form::text('bpjstk',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">BPJS Kesehatan</label></div>
				<div class="col-md-4">{!! Form::text('bpjs',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Family Lain</label></div>
				<div class="col-md-2">{!! Form::text('family_lain',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kode Pos</label></div>
				<div class="col-md-4">{!! Form::text('kodepos',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Alamat KTP</label></div>
				<div class="col-md-8">{!! Form::textarea('alamat',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Alamat Domisili</label></div>
				<div class="col-md-8">{!! Form::textarea('alamat_lain',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kodepos</label></div>
				<div class="col-md-4">{!! Form::text('kodepos',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kontak Darurat</label></div>
				<div class="col-md-4">{!! Form::text('emergency_call',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Bank</label></div>
				<div class="col-md-3">{!! Form::select('bank_id',$bank,null,['class'=>'form-control select2','placeholder'=>'-- Bank --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Nomor Rekening</label></div>
				<div class="col-md-6">{!! Form::text('no_rek',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Ibu Kandung</label></div>
				<div class="col-md-8">{!! Form::text('ibu_kandung',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Update</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
		loadJabatan();
		
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
	});

	function loadJabatan() {
		var url = '{{ route('backend.get_jabatan_exist') }}';
    $.ajax({
      type : "POST",
      url : url,
      data: {
        employee_id:$("#employee_id").val(),
        _token:"{{ csrf_token() }}",
      },
      dataType : "json",
      success: function(response){ 
        $("#jabatan").html(response.listdoc);
      },
    });
	}
</script>