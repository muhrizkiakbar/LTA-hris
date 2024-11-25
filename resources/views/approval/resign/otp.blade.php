<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Kode OTP</h6>
		</div>
		<div class="modal-body">
			<div class="form-group row">
				<div class="col-md-12">{!! Form::text('otp',null,['class'=>'form-control','id'=>'otp','required'=>true,'placeholder'=>'Masukkan kode OTP...']) !!}</div>
			</div> 
			<input type="hidden" id="otp_wa" value="{{ $otp }}">
			<div class="form-group row">
				<div class="col-md-12">
					<a href="javascript:void(0);" class="btn btn-primary btn-block auth">Authorize OTP</a>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
		$(".auth").click(function(e) {
			var otp = $("#otp").val();
			var otp_wa = $("#otp_wa").val();
			if (otp==otp_wa) {
				Swal.fire({
					icon: 'success',
					title: 'Kode OTP Berhasil di Input',
					timer: 3000,
					showCancelButton: false,
					showConfirmButton: false
				});

				$("#modalEx").modal('hide');
			} else {
				Swal.fire({
					icon: 'error',
					title: 'Error, Kode OTP salah !!!',
					timer: 3000,
					showCancelButton: false,
					showConfirmButton: false
				});	
			}
    });
  });
</script>