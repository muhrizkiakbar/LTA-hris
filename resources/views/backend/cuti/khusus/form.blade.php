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
<div class="form-group row">
  <div class="col-md-3"><label class="col-form-label">Keperluan</label></div>
  <div class="col-md-8">{!! Form::select('cuti_khusus_id',$khusus,null,['class'=>'form-control select2','required'=>true,'placeholder'=>'-- Cuti Khusus --']) !!}</div>
</div> 
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