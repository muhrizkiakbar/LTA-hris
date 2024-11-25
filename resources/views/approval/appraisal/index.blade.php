<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
	<title>{{ isset($title) ? $title.' - ' : '' }} Approval System | Human Resources Information System | LTA - TAA</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

	<link href="{{ asset('assets/backend/print/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/backend/print/icons.min.css') }}" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.css') }}">
	<link rel="stylesheet" href="{{ asset('assets/backend/print/custom.css') }}" />

	<script src="{{ asset('assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<script src="{{ asset('assets/js/plugins/rowspanizer/jquery.rowspanizer.min.js') }}"></script>
</head>
<body>
	<div class="header">
		<div class="row justify-content-between">
			<div class="col-5">
				<div class="header-logo">
					<em>Performance Appraisal Karyawan</em>
				</div>
			</div>
			<div class="col-7">
			</div>
		</div>
	</div>
	<div id="print_page">
		<div class="evoucher-wrapper evoucher-wrapper-new">
			<div class="evoucher-body">
				<div class="order-information">
					<div class="text-center mb-2">
						<h4 class="text-uppercase" style="font-size: 16px; font-weight: 600"><u>Formulir {{ $title }}</u></h4>
					</div>
				</div>
				@if ($atasan_st==1 && $manager_st==1)
					<div class="text-center">
						<h3>Penilaian telah di lakukan !!!</h3>
					</div>
				@else
					@if ($status=='appraisal_atasan' && $atasan_st==0)
						@include('approval.appraisal.form')
					@elseif ($status=='appraisal_manager' && $manager_st==0)
						@include('approval.appraisal.form')
					@else
					<div class="text-center">
						<h3>Penilaian telah di lakukan !!!</h3>
					</div>
					@endif
				@endif
			</div>
		</div>
	</div>
	<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	</div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
		var url = '{{ route('approval.appraisal.otp') }}';
		var code = '{{ $code }}';
		var token = '{{ csrf_token() }}';
		$.ajax({
			url: url,
			type: "POST",
			data : { code:code,_token:token },
			success: function (ajaxData){
				$("#modalEx").html(ajaxData);
				$("#modalEx").modal('show',{backdrop: 'true'});
			}
		});

		$("#example").rowspanizer({
      vertical_align: 'middle',
      columns: [0]
    });
  });

	function onlyOne(checkbox, no) {
    // var checkboxes = document.getElementsByClassName('checkx')
    $(".checkx"+no).each(function (index, val) { 
      if (val !== checkbox) val.checked = false
    })
  }
</script>
