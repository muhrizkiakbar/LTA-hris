<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Lokasi Asal</label></div>
	<div class="col-md-9">{!! Form::select('lokasi_asal_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih Lokasi --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Lokasi Tujuan</label></div>
	<div class="col-md-9">{!! Form::select('lokasi_tujuan_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih Lokasi --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Jarak</label></div>
	<div class="col-md-4">{!! Form::text('jarak',NULL,['class'=>'form-control','required'=>true]) !!}</div>
</div>