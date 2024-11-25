<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Edit Data Karyawan</h6>
		</div>
		<div class="modal-body">
			{!! Form::model($row,['route'=>['backend.employee.update',$row->id],'method'=>'PUT','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Nama</label></div>
				<div class="col-md-8">{!! Form::text('name',null,['class'=>'form-control']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Distrik</label></div>
				<div class="col-md-4">{!! Form::select('distrik_id',$distrik,NULL,['class'=>'form-control select2x','placeholder'=>'-- Jenis Kelamin --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi</label></div>
				<div class="col-md-4">{!! Form::select('lokasi_id',$lokasi,NULL,['class'=>'form-control select2x','placeholder'=>'-- Jenis Kelamin --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department</label></div>
				<div class="col-md-4">{!! Form::select('department_id',$department,null,['class'=>'form-control select2x','placeholder'=>'-- Department --','id'=>'department']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Principle</label></div>
				<div class="col-md-6">{!! Form::select('divisi_id',$divisi,null,['class'=>'form-control select2x','placeholder'=>'-- Principle --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Level</label></div>
				<div class="col-md-6">{!! Form::select('jabatan_id',$jabatan,null,['class'=>'form-control select2x','placeholder'=>'-- Level Jabatan --','id'=>'level']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jabatan</label></div>
				<div class="col-md-6">{!! Form::select('department_jabatan_id',[],null,['class'=>'form-control select2x','placeholder'=>'-- Jabatan --','id'=>'jabatan']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Atasan Langsung</label></div>
				<div class="col-md-9">{!! Form::select('atasan_id',$atasan,null,['class'=>'form-control select2x','required'=>true,'placeholder'=>'-- Atasan Langsung --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Email</label></div>
				<div class="col-md-8">{!! Form::email('email',null,['class'=>'form-control']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">No HP</label></div>
				<div class="col-md-8">{!! Form::text('no_hp',null,['class'=>'form-control']) !!}</div>
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