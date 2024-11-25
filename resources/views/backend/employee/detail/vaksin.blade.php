<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Upload Kartu Vaksinasi</h6>
		</div>
    <div class="modal-body">
      {!! Form::open(['route'=>['backend.employee.vaksin.store'],'method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-4"><label class="col-form-label">Tipe Vaksin</label></div>
				<div class="col-md-8">{!! Form::select('vaksin_type_id',$type,null,['class'=>'form-control select2','placeholder'=>'-- Tipe Vaksin --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-4"><label class="col-form-label">Tanggal Vaksin</label></div>
				<div class="col-md-6">{!! Form::text('date',null,['class'=>'form-control datepick','data-language'=>'en','data-date-format'=>'yyyy-mm-dd','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-4"><label class="col-form-label">File Pendukung</label></div>
				<div class="col-md-6">
					<div class="mt-2">
						{!! Form::file('file',['required'=>'required']) !!}
					</div>
				</div>
			</div>
			<input type="hidden" name="users_id" value="{{ $id }}">
			<div class="form-group row">
				<label class="col-form-label col-md-4"></label>
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
    $(".select2").select2({
			width: '100%'
		});

		$('.datepick').datepicker({
			autoClose:true
		});
  });
</script>