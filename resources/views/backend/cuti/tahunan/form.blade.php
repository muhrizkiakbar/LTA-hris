@if (auth()->user()->role_id==5)
<input type="hidden" name="employee_id" value="{{ $users_id }}">
@else
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
  <div class="col-md-8">
		<select name="employee_id" id="employee_id" class="form-control select2" required>
			<option value="">-- Karyawan --</option>
			@foreach ($user as $user1)
			<option value="{{ $user1->id }}">{{ $user1->nik.' - '.$user1->name }}</option>	
			@endforeach
		</select>
	</div>
</div>  
@endif
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Tanggal Cuti</label></div>
  <div class="col-md-8">
    {!! Form::text('tgl',null,['class'=>'form-control','id'=>'tglExtend','data-language'=>'en','data-multiple-dates'=>'true','data-multiple-dates-separator'=>', ','data-date-format'=>'yyyy-mm-dd']) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Pengganti Sementara</label></div>
  <div class="col-md-8">
		<select name="employee_exchange_id" id="employee_exchange_id" class="form-control select2" required>
			<option value="">-- Karyawan --</option>
		</select>
	</div>
</div>
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Deskripsi</label></div>
  <div class="col-md-7">{!! Form::textarea('desc',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}</div>
</div>