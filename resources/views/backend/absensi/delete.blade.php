<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
		<div class="modal-body">
			{!! Form::open(['route'=>'backend.absensi.delete_absensi','method'=>'POST','files' => true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Tanggal</label></div>
				<div class="col-md-4">
					{!! Form::text('periode',null,['class'=>'form-control datepick','id'=>'periode','data-range'=>'true','data-language'=>'en','data-multiple-dates-separator'=>' - ','required'=>true]) !!}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Lokasi</label></div>
				<div class="col-md-4">{!! Form::select('lokasi_id',$lokasi,NULL,['class'=>'form-control select2','placeholder'=>'-- Lokasi --','required'=>true]) !!}</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Delete</button>
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