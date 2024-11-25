<div class="form-group row">
	<div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
	<div class="col-md-9">
		<select name="employee[]" class="form-control select2"  multiple='multiple' required>
			@foreach ($user as $user)
			<option value="{{ $user->id }}">{{ $user->nik.' - '.$user->name }}</option>	
			@endforeach
		</select>
		{{-- {!! Form::select('employee[]',$user,null,['class'=>'form-control select2','multiple'=>'multiple']) !!} --}}
	</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Gaji Pokok</label></div>
  <div class="col-md-5">{!! Form::text('gaji_pokok',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Jabatan</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_jabatan',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Transport</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_transport',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Makan</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_makan',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Sewa</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_sewa',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Pulsa</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_pulsa',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tunjangan Lainnya</label></div>
  <div class="col-md-5">{!! Form::text('tunjangan_lain',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">BPJS Except</label></div>
  <div class="col-md-5">{!! Form::text('bpjs_except',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>