<div class="modal-dialog modal-lg">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Tambah Pemakaian Kendaraan</h6>
		</div>
    <div class="modal-body">
			{!! Form::open(['route'=>'backend.dinas.kendaraan_store','method'=>'POST','files'=>true]) !!}
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Kendaraan</label></div>
				<div class="col-md-6">{!! Form::select('dinas_kendaraan_id',$kendaraan,null,['class'=>'form-control select2','placeholder'=>'-- Kendaraan --','required'=>'true','id'=>'kendaraan']) !!}</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Rute Trip</label></div>
				<div class="col-md-4">{!! Form::select('lokasi_asal_id',$lokasi,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','id'=>'lokasi_asal_id']) !!}</div>
				<div class="col-md-4">{!! Form::select('lokasi_tujuan_id',$lokasi,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','id'=>'lokasi_tujuan_id']) !!}</div>
			</div>
			<div class="trans-darat">
				<div class="form-group row">
					<div class="col-md-3"><label class="col-form-label">Estimasi Jarak</label></div>
					<div class="col-md-3">
						<div class="input-group">
							{!! Form::text('jarak',null,['class'=>'form-control estimasi_jarak']) !!}
							<span class="input-group-append">
								<span class="input-group-text">Km</span>
							</span>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3"><label class="col-form-label">Pulang Pergi</label></div>
					<div class="col-md-3">{!! Form::select('pp',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --']) !!}</div>
				</div>
				<div class="form-group row tol">
					<div class="col-md-3"><label class="col-form-label">Biaya Tol</label></div>
					<div class="col-md-9">{!! Form::select('dinas_biaya_tol_id',$tol,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --']) !!}</div>
				</div>
				<div class="form-group row tol">
					<div class="col-md-3"><label class="col-form-label">Pulang Pergi Tol</label></div>
					<div class="col-md-3">{!! Form::select('pp_tol',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --']) !!}</div>
				</div>
			</div>
			<div class="trans-luar">
				<div class="form-group row ppx">
					<div class="col-md-3"><label class="col-form-label">Pulang Pergi</label></div>
					<div class="col-md-3">{!! Form::select('ppx',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --']) !!}</div>
				</div>
				<div class="form-group row">
					<div class="col-md-3"><label class="col-form-label">Estimasi Harga</label></div>
					<div class="col-md-6">{!! Form::text('estimasi_harga',null,['class'=>'form-control']) !!}</div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-3"><label class="col-form-label">Sharing Kendaraan</label></div>
				<div class="col-md-3">{!! Form::select('sharing_kendaraan',$bool,null,['class'=>'form-control select2','placeholder'=>'-- Pilih --','required'=>'true']) !!}</div>
			</div>
			<input type="hidden" name="users_id" value="{{ $users_id }}">
			<div class="form-group row">
				<label class="col-form-label col-md-3"></label>
				<div class="col-md-6">
					<button class="btn btn-primary btn-sm" type="submit">Tambah</button>
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

		$(".trans-darat").hide();
    $(".trans-luar").hide();
    $(".tol").hide();
    $(".ppx").hide();
    $(".estimasi_jarak").attr("readonly", true);

		$('#kendaraan').change(function() {
      var kendaraan = $('#kendaraan').val();
      if(kendaraan == 1  || kendaraan == 2){
        if(kendaraan==2){
          $(".tol").show();
        }else{
          $(".tol").hide();
        }
        $(".trans-darat").show();
        $(".trans-luar").hide();
      } else if (kendaraan == 3  || kendaraan == 4 || kendaraan==5 || kendaraan==6) {
        if(kendaraan==5){
          $(".ppx").show();
        }else{
          $(".ppx").hide();
        }
        $(".trans-luar").show();
        $(".trans-darat").hide();
      } else {
        $(".trans-luar").hide();
        $(".trans-darat").hide();
      }
    });

		$("#lokasi_asal_id").change(function() {
      var url = '{{ route('backend.dinas.lokasi_jarak') }}';
	    $.ajax({
	      type : "POST",
	      url : url,
	      data: {
          lokasi_asal_id:$("#lokasi_asal_id").val(),
          lokasi_tujuan_id:$("#lokasi_tujuan_id").val(),
          _token:"{{ csrf_token() }}",
        },
	      dataType : "json",
	      success: function(response){ 
          if(response.info==1){
            $(".estimasi_jarak").attr("readonly", true);
            $(".estimasi_jarak").val(response.jarak);
          } else {
            $(".estimasi_jarak").val(0);
            $(".estimasi_jarak").attr("readonly", false);
          }
	      },
	    });
	  });

    $("#lokasi_tujuan_id").change(function() {
      var url = '{{ route('backend.dinas.lokasi_jarak') }}';
	    $.ajax({
	      type : "POST",
	      url : url,
	      data: {
          lokasi_asal_id:$("#lokasi_asal_id").val(),
          lokasi_tujuan_id:$("#lokasi_tujuan_id").val(),
          _token:"{{ csrf_token() }}",
        },
	      dataType : "json",
	      success: function(response){ 
          if(response.info==1){
            $(".estimasi_jarak").attr("readonly", true);
            $(".estimasi_jarak").val(response.jarak);
          } else {
            $(".estimasi_jarak").val(0);
            $(".estimasi_jarak").attr("readonly", false);
          }
	      },
	    });
	  });
	});
</script>
