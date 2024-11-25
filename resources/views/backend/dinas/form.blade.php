<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Karyawan</label></div>
  <div class="col-md-7">{!! Form::select('users_id',$employee,null,['class'=>'form-control select2','placeholder'=>'-- Karyawan --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Tanggal Mulai</label></div>
  <div class="col-md-5">{!! Form::text('date_start',null,['class'=>'form-control datepick','data-date-format'=>'yyyy-mm-dd','data-language'=>'en','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Tanggal Akhir</label></div>
  <div class="col-md-5">{!! Form::text('date_end',null,['class'=>'form-control datepick','data-date-format'=>'yyyy-mm-dd','data-language'=>'en','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Tujuan</label></div>
  <div class="col-md-6">{!! Form::select('lokasi_tujuan_id',$lokasi,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Tipe</label></div>
  <div class="col-md-6">{!! Form::select('dinas_tipe_id',$tipe,null,['class'=>'form-control select2','placeholder'=>'-- Tipe Perjalanan Dinas --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Keperluan</label></div>
  <div class="col-md-7">{!! Form::textarea('keperluan',null,['class'=>'form-control','required'=>'true','rows'=>3]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Sharing Room Hotel</label></div>
  <div class="col-md-5">{!! Form::select('sharing_room',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Uang Makan</label></div>
  <div class="col-md-5">{!! Form::select('uang_makan',$bool2,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Daily Transport</label></div>
  <div class="col-md-5">{!! Form::select('daily_transport',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Catatan</label></div>
  <div class="col-md-7">{!! Form::textarea('catatan',null,['class'=>'form-control','rows'=>3]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Atasan Langsung</label></div>
  <div class="col-md-6">{!! Form::select('periksa_id',$atasan,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Menyetujui</label></div>
  <div class="col-md-6">{!! Form::select('approval1_id',$atasan,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"><label class="col-form-label">Diketahui</label></div>
  <div class="col-md-6">{!! Form::select('approval2_id',$atasan,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-5"></div>
  <div class="col-md-7"><a href="javascript:void(0);" class="info">Klik Disini untuk Info Biaya Uang Makan & Hotel</a></div>
</div>