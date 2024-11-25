<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Update Status</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>'backend.dinas.update_payment_store','method'=>'POST','files'=>true]) !!}
			@if ($get->dinas_payment_id==1)
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Bukti Pembayaran</label></div>
				<div class="col-md-6">{!! Form::file('dinas_payment_proof',['required'=>'true']) !!}</div>
			</div>	
			@else
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Bukti Penyelesaian</label></div>
				<div class="col-md-6">{!! Form::file('dinas_payment_done',['required'=>'true']) !!}</div>
			</div>
			@endif
			<input type="hidden" name="dinas_payment_id" value="{{ $get->dinas_payment_id }}">
			<input type="hidden" name="id" value="{{ $get->id }}">
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Update</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
    </div>
  </div>
</div>
