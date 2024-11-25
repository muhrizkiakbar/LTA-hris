<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Nama Training</label></div>
	<div class="col-md-8">{!! Form::text('name',null,['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Kualifikasi</label></div>
	<div class="col-md-4">{!! Form::select('klasifikasi_training_id',$row['klasifikasi'],null,['class'=>'form-control','placeholder'=>'-- Kualifikasi --']) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Tanggal</label></div>
	<div class="col-md-4">{!! Form::text('date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Nama Trainer</label></div>
	<div class="col-md-8">{!! Form::text('trainer',null,['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Peserta</label></div>
	<div class="col-md-9">{!! Form::select('peserta[]',$row['peserta'],null,['class'=>'form-control select2','multiple'=>'multiple']) !!}</div>
</div>