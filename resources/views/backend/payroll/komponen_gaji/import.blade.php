<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.payroll.komponen_gaji.import_store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">File Import</label></div>
				<div class="col-md-8">
					{!! Form::file('file',null,['class'=>'form-control','required'=>true]) !!}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<a href="https://hris.laut-timur.tech/storage/upload/csv/format_komponen_gaji.xlsx" target="_blank">
						Download template
					</a>
					<br>
					<button class="btn btn-primary btn-sm" type="submit">Simpan</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>