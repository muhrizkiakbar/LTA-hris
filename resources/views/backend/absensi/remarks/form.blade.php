<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Nama Karyawan</label></div>
  <div class="col-md-8">
    {!! Form::select('users_id',$user,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih Karyawan --', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal</label></div>
  <div class="col-md-4">
    {!! Form::text('date1',NULL,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd', 'required'=>'true']) !!}
  </div>
	<div class="col-md-4">
    {!! Form::text('date2',NULL,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Keterangan</label></div>
  <div class="col-md-6">
    {!! Form::textarea('remarks',NULL,['class'=>'form-control','rows'=>3]) !!}
  </div>
</div>