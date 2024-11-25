<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Nama</label></div>
  <div class="col-md-6">{!! Form::text('name',null,['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Email</label></div>
  <div class="col-md-6">{!! Form::text('email',null,['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Password</label></div>
  <div class="col-md-9">{!! Form::password('password',['class'=>'form-control']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">User Role</label></div>
  <div class="col-md-6">{!! Form::select('role_id',$role,NULL,['class'=>'form-control select2','placeholder'=>'-- User Role --']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Lokasi</label></div>
  <div class="col-md-9">{!! Form::select('lokasi_id[]',$lokasi,NULL,['class'=>'form-control select2','multiple'=>'multiple']) !!}</div>
</div>