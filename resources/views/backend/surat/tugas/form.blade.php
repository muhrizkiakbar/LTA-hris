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
  <div class="col-md-4"><label class="col-form-label">Tujuan</label></div>
  <div class="col-md-8">
    {!! Form::text('desc',NULL,['class'=>'form-control','required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Keterangan</label></div>
  <div class="col-md-6">
    {!! Form::textarea('catatan',NULL,['class'=>'form-control','rows'=>3]) !!}
  </div>
</div>