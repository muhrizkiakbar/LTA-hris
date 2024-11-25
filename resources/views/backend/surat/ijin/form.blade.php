<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Karyawan</label></div>
  <div class="col-md-8">{!! Form::select('employee_id',$user,null,['class'=>'form-control select2','placeholder'=>'-- Karyawan --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal</label></div>
  <div class="col-md-6">{!! Form::text('date',null,['class'=>'form-control datepick','data-date-format'=>'yyyy-mm-dd','data-language'=>'en','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Jam Awal</label></div>
  <div class="col-md-4">{!! Form::text('time_start',null,['class'=>'form-control only-time','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Jam Akhir</label></div>
  <div class="col-md-4">{!! Form::text('time_end',null,['class'=>'form-control only-time','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tipe Keperluan</label></div>
  <div class="col-md-6">{!! Form::select('tipe',$tipe,null,['class'=>'form-control select2','placeholder'=>'-- Tipe Keperluan --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Keperluan</label></div>
  <div class="col-md-8">{!! Form::textarea('keperluan',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}</div>
</div>