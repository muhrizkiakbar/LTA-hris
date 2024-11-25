<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Upload Kartu Keluarga</h6>
		</div>
    <div class="modal-body">
			{!! Form::model($get,['route'=>['backend.employee.ijazah_update',$get->id],'method'=>'PUT','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Ijazah</label></div>
				<div class="col-md-3">{!! Form::select('ijazah_id',$ijazah,null,['class'=>'form-control select','required'=>'required']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Institusi</label></div>
				<div class="col-md-6">{!! Form::text('ijazah_institusi',null,['class'=>'form-control','required'=>'required']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Jurusan</label></div>
				<div class="col-md-6">{!! Form::text('ijazah_jurusan',null,['class'=>'form-control','required'=>'required']) !!}</div>
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
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-info btn-sm" type="submit">Upload</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $(".select2").select2();
  });
</script>