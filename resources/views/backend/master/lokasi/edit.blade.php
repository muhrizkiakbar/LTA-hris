<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Edit Data - {{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::model($row,['route'=>['backend.master.lokasi.update',$row->id],'method'=>'PUT','files' => true]) !!}
			@include('backend.master.lokasi.form')
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<button class="btn btn-success btn-sm" type="submit">Update</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!} 
		</div>
	</div>
</div>