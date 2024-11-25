<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Generate Kontrak Kerja</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.employee.kontrak_kerja.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kontrak Kerja</label></div>
				<div class="col-md-6">{!! Form::select('employee_sts_id',$kontrak_sts,null,['class'=>'form-control select2','placeholder'=>'-- Kontrak Kerja --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Mulai</label></div>
				<div class="col-md-4">{!! Form::text('tgl_start',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Berakhir</label></div>
				<div class="col-md-4">{!! Form::text('tgl_end',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
				<div class="col-md-9">
					{{-- {!! Form::select('user_id',$employee,null,['class'=>'form-control select2','required'=>true]) !!} --}}
					<select name="user_id" class="form-control select2" required>
						<option value="">-- Karyawan --</option>
						@foreach ($employee as $user1)
						<option value="{{ $user1->id }}">{{ $user1->nik.' - '.$user1->name }}</option>	
						@endforeach
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">File Pendukung</label></div>
				<div class="col-md-6">
					<div class="mt-2">
						{!! Form::file('file') !!}
					</div>
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
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-success btn-sm" type="submit">Generate</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2({
			width: '100%'
		});

    $(".select2").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
    });

    $('.datepick').datepicker({
    	autoClose:true
    });
  });
</script>