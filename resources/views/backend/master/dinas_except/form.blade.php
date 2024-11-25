<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Department</label></div>
	<div class="col-md-8">{!! Form::select('department_id',$department,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Jabatan</label></div>
	<div class="col-md-8">{!! Form::select('jabatan_id',$jabatan,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Lokasi Asal</label></div>
	<div class="col-md-8">{!! Form::select('lokasi_asal_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Lokasi Tujuan</label></div>
	<div class="col-md-8">{!! Form::select('lokasi_tujuan_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Uang Makan</label></div>
	<div class="col-md-6">{!! Form::text('uang_makan',NULL,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Uang Hotel</label></div>
	<div class="col-md-6">{!! Form::text('uang_hotel',NULL,['class'=>'form-control','required'=>true]) !!}</div>
</div>
