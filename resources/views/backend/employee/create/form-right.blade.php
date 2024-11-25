<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Tanggal Masuk</label></div>
  <div class="col-md-6">{!! Form::text('join_date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>'true']) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Distrik</label></div>
  <div class="col-md-6">
    {!! Form::select('distrik_id',$distrik,NULL,['class'=>'form-control select2','placeholder'=>'-- Distrik --','required'=>true]) !!}
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Lokasi Kerja</label></div>
  <div class="col-md-6">
    @if ($role==1)
      {!! Form::select('lokasi_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Lokasi Kerja --','required'=>true]) !!}
    @else
      <select name="lokasi_id" class="form-control select2" required>
        <option value="">-- Lokasi Kerja --</option>
        @foreach ($lokasi as $lokasi)
        <option value="{{ $lokasi->lokasi_id }}">{{ $lokasi->lokasi->title }}</option>
        @endforeach
      </select>
    @endif
  </div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Status Pernikahan</label></div>
  <div class="col-md-6">{!! Form::select('marriage_id',$marriage,NULL,['class'=>'form-control select2','placeholder'=>'-- Status Pernikahan --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Golongan Darah</label></div>
  <div class="col-md-5">{!! Form::select('blood_id',$blood,NULL,['class'=>'form-control select2','placeholder'=>'-- Golongan Darah --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Kewarganegaraan</label></div>
  <div class="col-md-7">{!! Form::select('country_id',$country,NULL,['class'=>'form-control select2','placeholder'=>'-- Kewarganegaraan --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Suku Bangsa</label></div>
  <div class="col-md-6">{!! Form::text('suku',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Jenis PTKP</label></div>
  <div class="col-md-6">{!! Form::select('ptkp_id',$ptkp,null,['class'=>'form-control select2','placeholder'=>'-- Jenis PTKP --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Bank</label></div>
  <div class="col-md-6">{!! Form::select('bank_id',$bank,null,['class'=>'form-control select2','placeholder'=>'-- Bank --','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Nomor Rekening</label></div>
  <div class="col-md-6">{!! Form::text('no_rek',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">BPJSTK</label></div>
  <div class="col-md-4">{!! Form::text('bpjstk',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">BPJS Kesehatan</label></div>
  <div class="col-md-4">{!! Form::text('bpjs',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Family Lain</label></div>
  <div class="col-md-2">{!! Form::text('family_lain',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Alamat Domisili</label></div>
  <div class="col-md-8">{!! Form::textarea('alamat_lain',null,['class'=>'form-control','rows'=>2,'required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Kodepos</label></div>
	<div class="col-md-4">{!! Form::text('kodepos',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Alamat KTP</label></div>
  <div class="col-md-8">{!! Form::textarea('alamat',null,['class'=>'form-control','rows'=>2,'required'=>true]) !!}</div>
</div>
<div class="form-group row">
	<div class="col-md-4"><label class="col-form-label">Kontak Darurat</label></div>
	<div class="col-md-8">{!! Form::text('emergency_call',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
<div class="form-group row">
  <div class="col-md-4"><label class="col-form-label">Ibu Kandung</label></div>
  <div class="col-md-8">{!! Form::text('ibu_kandung',null,['class'=>'form-control','required'=>true]) !!}</div>
</div>
