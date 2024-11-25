<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.payroll.komponen_gaji.store'],'method'=>'POST','files' => true]) !!}
			@include('backend.payroll.komponen_gaji.form')
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Simpan</button>
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

		$(".select2").on("select2:select", function (evt) {
      var element = evt.params.data.element;
      var $element = $(element);
      
      $element.detach();
      $(this).append($element);
      $(this).trigger("change");
    });
  });
</script>