<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Reject</h6>
		</div>
		<div class="modal-body">
			{!! Form::open(['route'=>['approval.cuti_khusus.reject_update'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-12">
					{!! Form::text('reject_excuse',null,['class'=>'form-control','required'=>true,'placeholder'=>'Masukkan alasan reject...']) !!}
				</div>
			</div> 
			<input type="hidden" name="kd" value="{{ $kd }}">
			<input type="hidden" name="approval" value="{{ $approval }}">
			<div class="form-group row">
				<div class="col-md-12">
					<button type="submit" class="btn btn-danger btn-block auth">Reject</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>