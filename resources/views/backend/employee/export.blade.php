<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Export Data Karyawan</h6>
		</div>
		<div class="modal-body">
			{!! Form::open(['route'=>'backend.employee.export_proses','method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tipe</label></div>
				<div class="col-md-8">{!! Form::select('tipe',$tipe,null,['class'=>'form-control']) !!}</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Export</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>