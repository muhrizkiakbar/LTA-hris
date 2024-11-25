<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Nama Lengkap</label></div>
  <div class="col-md-7">{!! Form::text('name',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">No. KTP</label></div>
  <div class="col-md-7">{!! Form::text('ktp_no',null,['class'=>'form-control','required'=>true,'required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Email Kantor</label></div>
  <div class="col-md-7">{!! Form::email('email',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Email Pribadi</label></div>
	<div class="col-md-7">{!! Form::text('email_kantor',null,['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">No Handphone</label></div>
  <div class="col-md-6">{!! Form::text('no_hp',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tempat Lahir</label></div>
  <div class="col-md-6">{!! Form::text('tempat_lahir',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal Lahir</label></div>
  <div class="col-md-6">{!! Form::text('tgl_lahir',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Jenis Kelamin</label></div>
  <div class="col-md-4">{!! Form::select('gender_id',$gender,NULL,['class'=>'form-control select2','placeholder'=>'-- Jenis Kelamin --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Agama</label></div>
  <div class="col-md-4">{!! Form::select('religion_id',$religion,NULL,['class'=>'form-control select2','placeholder'=>'-- Agama --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Foto Karyawan</label></div>
  <div class="col-md-6">
    <div class="custom-file">
      {!! Form::file('foto',['class'=>'custom-file-input','id'=>'customFile','required'=>true]) !!}
      <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Perusahaan</label></div>
  <div class="col-md-6">{!! Form::select('perusahaan_id',$perusahaan,null,['class'=>'form-control select2','placeholder'=>'-- Perusahaan --','id'=>'perusahaan','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Principal</label></div>
  <div class="col-md-6">{!! Form::select('divisi_id',$divisi,null,['class'=>'form-control select2','placeholder'=>'-- Principal --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Claim Principal</label></div>
  <div class="col-md-6">{!! Form::select('claim_principal_id',$claim_principal,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
    <div class="col-md-4"><label class="col-form-label">Department</label></div>
    <div class="col-md-4">{!! Form::select('department_id',$department,null,['class'=>'form-control select2','placeholder'=>'-- Department --','id'=>'department','required'=>true]) !!}</div>
  </div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Level</label></div>
  <div class="col-md-6">{!! Form::select('jabatan_id',$jabatan,null,['class'=>'form-control select2','placeholder'=>'-- Level Jabatan --','id'=>'level','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Jabatan</label></div>
  <div class="col-md-6">{!! Form::select('department_jabatan_id',[],null,['class'=>'form-control select2','placeholder'=>'-- Jabatan --','id'=>'jabatan','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Atasan Langsung</label></div>
  <div class="col-md-7">{!! Form::select('atasan_id',$atasan,null,['class'=>'form-control select2','required'=>true,'placeholder'=>'-- Atasan Langsung --','required'=>true]) !!}</div>
</div>
