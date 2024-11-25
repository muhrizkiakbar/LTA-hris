<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::model($row,['route'=>['backend.employee.sloting.update',$row->id],'method'=>'PUT','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kode Sloting</label></div>
				<div class="col-md-6">{!! Form::text('kd',null,['class'=>'form-control','readonly'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Depatment</label></div>
				<div class="col-md-4">{!! Form::text('department',isset($row->department) ? $row->department->title : null,['class'=>'form-control','readonly'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Level Jabatan</label></div>
				<div class="col-md-4">{!! Form::text('level',isset($row->level) ? $row->level->title : null,['class'=>'form-control ','readonly'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Department Jabatan</label></div>
				<div class="col-md-4">{!! Form::text('jabatan',isset($row->jabatan) ? $row->jabatan->title : null,['class'=>'form-control','readonly'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Karyawan</label></div>
				<div class="col-md-6">{!! Form::select('users_id',$user,null,['class'=>'form-control select2','placeholder'=>'-- Pilih Karyawan --']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
					<button class="btn btn-primary btn-sm" type="submit">Update</button>
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
				</div>
			</div>
			{!! Form::close() !!}
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
		$(".select2").select2({
			width: "100%"
		});
	});
</script>