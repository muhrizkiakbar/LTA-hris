<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>['backend.cuti.tahunan.store'],'method'=>'POST','files' => true]) !!}
			@include('backend.cuti.tahunan.form')
			<div class="form-group row">
				<div class="col-md-3"></div>
				<div class="col-md-9">
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

    $("#tglExtend").datepicker({
      multidate: true,
      minDate: 0,
      weekStart: 1,
      orientation: 'bottom',
      clearButton : true
    });

    $("#tglExtend").datepicker('show');
		
		$("#employee_id").on('change', function () {
			var url = '{{ route('backend.get_employee_exchange') }}';
			$.ajax({
				type : "POST",
				url : url,
				data: {
					employee_id:$("#employee_id").val(),
					_token:"{{ csrf_token() }}",
				},
				dataType : "json",
				success: function(response){
					$("#employee_exchange_id").html(response.listdoc);
				},
			});
		});
  });
</script>