<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">File Upload</label></div>
  <div class="col-md-8">
		{!! Form::file('file') !!}
		<span class="form-text">
			<small>Harap perhatikan untuk mengupload log absensi .txt</small>
		</span>
	</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Mesin Absensi</label></div>
  <div class="col-md-8">{!! Form::select('mesin',$mesin,null,['class'=>'form-control','placeholder'=>'-- Pilih --']) !!}</div>
</div>