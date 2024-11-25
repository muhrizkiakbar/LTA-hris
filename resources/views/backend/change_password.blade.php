<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.password_update'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-4"><label class="col-form-label">New Password</label></div>
				<div class="col-md-8">
					{!! Form::password('password',['class'=>'form-control','required'=>true]) !!}
				</div>
			</div>
			<input type="hidden" name="users_id" value="{{ $users_id }}">
			<div class="form-group row">
				<div class="col-md-4"></div>
				<div class="col-md-8">
					<button class="btn btn-primary btn-sm" type="submit">Update Password</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>