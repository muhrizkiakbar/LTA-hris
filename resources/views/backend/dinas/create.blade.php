@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-5">
				@include('backend.template.alert')
				<div class="card">
					<div class="card-body">
						{!! Form::open(['route'=>'backend.dinas.store','method'=>'POST','files'=>true]) !!}
              @include('backend.dinas.form')
              <div class="form-group row">
                <div class="col-md-5"></div>
                <div class="col-md-6">
                  <button class="btn btn-success" type="submit">Simpan</button>
                </div>
              </div>
              {!! Form::close() !!}  
					</div>
				</div>
			</div>
			<div class="col-xl-7">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Pemakaian Kendaraan</h6>
						<div class="page-title-right">
							<a href="#" class="btn btn-success btn-icon btn-sm kendaraan">
								<i class="ri-add-line"></i>
							</a>
						</div>
					</div>
					<div id="kendaraan_view"></div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
</div>
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){

		kendaraanLoad();

		$(".select2").select2({
			width: "100%"
		});

		$('.datepick').datepicker({
    	autoClose:true
    });

		$(".info").click(function(e) {
      var url = '{{ route('backend.dinas.info') }}';
      $.ajax({
        url: url,
        type: "GET",
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".kendaraan").click(function(e) {
      var url = '{{ route('backend.dinas.kendaraan') }}';
			var token = "{{ csrf_token() }}";
      $.ajax({
        url: url,
        type: "POST",
				data: { _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });
  });

	function kendaraanLoad(){
		var url = '{{ route('backend.dinas.kendaraan_view') }}';
		$.ajax({
			url: url,
			type: "GET",
			success: function (data){
				$('#kendaraan_view').html(data);
			}
		});
	}
</script>
@endsection