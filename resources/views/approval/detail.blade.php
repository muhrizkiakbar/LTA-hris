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
</head>
<body>
	@include('approval.header')
	<div id="print_page">
		<div class="evoucher-wrapper evoucher-wrapper-new">
			<div class="evoucher-body">
				<div class="order-information">
					<div class="text-center mb-2">
						<h4 class="text-uppercase" style="font-size: 16px; font-weight: 600"><u>Pengajuan {{ $title }}</u></h4>
						@if ($status != 'resign_interview')
						<span style="font-size: 12px;">Nomor : LTA / {{ $doc }} / {{ $thn }} / {{ $bln }} / {{ $row->employee->nik }} / {{ $row->kd }}</span>
						@else
						<span style="font-size: 12px;">Nomor : LTA / {{ $doc }} / {{ $thn }} / {{ $bln }} / {{ $row->nik }}</span>
						@endif
					</div>
				</div>
				<div class="order-detail">
					<table class="table table-bordered table-sm">
						@include('approval.bio')
						<tr>
							<td colspan="3" class="text-center"><strong>Detail {{ $title }}</strong></td>
						</tr>
						@include($view_detail)
						@if ($row->reject_excuse!='')
						<tr>
							<td colspan="3" class="text-center text-danger"><strong>ALASAN REJECT</strong></td>
						</tr>
						<tr>
							<td colspan="3" class="text-danger">{{ $row->reject_excuse }}</td>
						</tr>
						@endif
					</table>
					<table class="table table-borderless table-sm">
						<tr>
							<td>{{ $row->employee->lokasi }}, {{ tgl_indo($row->date) }}</td>
						</tr>
					</table>
					@include('approval.sign')
					@include('approval.disclaimer')
				</div>
			</div>
		</div>
	</div>
	<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
	</div>
</body>
</html>
<script type="text/javascript">
  $(document).ready(function(){
		var url = '{{ route($url_otp) }}';
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

		$(".reject").click(function(e) {
      var url = '{{ route($url_reject) }}';
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
    });
  });
</script>
