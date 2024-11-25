<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Surat Peringatan</h6>
		</div>
    <div class="modal-body">
      {!! Form::open(['route'=>['backend.employee.surat_peringatan.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Nomor Surat</label></div>
				<div class="col-md-8">{!! Form::text('nomor',null,['class'=>'form-control','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal</label></div>
				<div class="col-md-4">{!! Form::text('date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tingkat Pelanggaran</label></div>
				<div class="col-md-6">{!! Form::select('m_sp_id',$sp,null,['class'=>'form-control','placeholder'=>'-- Tingkat Pelanggaran --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Pelanggaran</label></div>
				<div class="col-md-9">{!! Form::textarea('pelanggaran',null,['class'=>'form-control','required'=>true,'rows'=>3]) !!}</div>
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