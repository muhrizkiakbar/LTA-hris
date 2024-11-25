<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Pengajuan Karyawan Resign</h6>
		</div>
		<div class="modal-body">
			{!! Form::open(['route'=>'backend.employee.resign.update','method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal Efektif</label></div>
				<div class="col-md-4">{!! Form::text('resign_date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Alasan Resign</label></div>
				<div class="col-md-4">{!! Form::select('resign_types_id',$type,NULL,['class'=>'form-control select2','placeholder'=>'-- Pilih --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Keterangan</label></div>
				<div class="col-md-9">{!! Form::textarea('resign_reason',null,['class'=>'form-control','rows'=>3]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label"></label></div>
				<div class="col-md-4">
					<div class="form-check mb-3">
						<input class="form-check-input" name="check_bypass" type="checkbox" value="1" id="defaultCheck1">
						<label class="form-check-label" for="defaultCheck1">
							Bypass Resign Karyawan
						</label>
					</div>
				</div>
			</div>
			
			<input type="hidden" name="id" value="{{ $id }}">
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-success btn-sm" type="submit">Proses Resign</button>
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