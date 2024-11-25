<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Periode</label></div>
  <div class="col-md-8">
		{!! Form::text('periode',null,['class'=>'form-control datepick','id'=>'periode','data-language'=>'en','required'=>true,'data-min-view'=>'months','data-view'=>'months','data-date-format'=>'MM yyyy']) !!}
  </div>
</div>

<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">File Import</label></div>
  <div class="col-md-8">
		{!! Form::file('file',null,['class'=>'form-control','required'=>true]) !!}
  </div>
</div>