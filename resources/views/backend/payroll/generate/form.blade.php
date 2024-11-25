<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Disktrik</label></div>
  <div class="col-md-8">
    {!! Form::select('lokasi_id',$distrik,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --', 'required'=>'true']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Periode</label></div>
  <div class="col-md-8">
		{!! Form::text('periode',null,['class'=>'form-control datepick','id'=>'periode','data-language'=>'en','required'=>true,'data-min-view'=>'months','data-view'=>'months','data-date-format'=>'MM yyyy']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Hari Kerja</label></div>
  <div class="col-md-3">
		{!! Form::text('hari_kerja',null,['class'=>'form-control','id'=>'hari_kerja','required'=>'true']) !!}
  </div>
</div>