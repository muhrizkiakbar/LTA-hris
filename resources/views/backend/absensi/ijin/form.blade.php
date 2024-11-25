<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Nama Karyawan</label></div>
  <div class="col-md-8">
    {!! Form::select('users_id',$user,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih Karyawan --', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal Mulai</label></div>
  <div class="col-md-4">
    {!! Form::text('date_start',NULL,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal Akhir</label></div>
  <div class="col-md-4">
    {!! Form::text('date_end',NULL,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Label ijin</label></div>
  <div class="col-md-6">
    {!! Form::select('absensi_ijin_type_id',$type,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih Keterangan Ijin --', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Keterangan</label></div>
  <div class="col-md-6">
    {!! Form::textarea('keterangan',NULL,['class'=>'form-control','rows'=>3]) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">File Pendukung</label></div>
  <div class="col-md-8">
    {!! Form::file('file') !!}
    <span class="form-text text-muted">Max. ukuran 1MB</span>
  </div>
</div>