<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tanggal</label></div>
  <div class="col-md-6">{!! Form::text('date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Deskripsi</label></div>
  <div class="col-md-8">{!! Form::textarea('desc',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}</div>
</div>