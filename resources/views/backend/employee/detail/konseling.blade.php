<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Konseling Karyawan</h6>
		</div>
    <div class="modal-body">
      {!! Form::open(['route'=>['backend.employee.konseling.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal</label></div>
				<div class="col-md-4">{!! Form::text('date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Catatan</label></div>
				<div class="col-md-8">{!! Form::textarea('catatan',null,['class'=>'form-control','required'=>'required','rows'=>3]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">File Pendukung</label></div>
				<div class="col-md-6">
					<div class="mt-2">
						{!! Form::file('file',['required'=>'required']) !!}
					</div>
				</div>
			</div>
			<input type="hidden" name="users_id" value="{{ $id }}">
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-success btn-sm" type="submit">Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('.datepick').datepicker({
    	autoClose:true
    });
  });
</script>