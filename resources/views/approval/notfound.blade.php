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
	<div id="print_page">
		<div class="evoucher-wrapper evoucher-wrapper-new">
			<div class="evoucher-body">
				<div class="order-information">
					<div class="text-center mb-2">
						<h4 class="text-uppercase" style="font-size: 16px; font-weight: 600"><u>Pengajuan {{ $title }}</u></h4>
					</div>
				</div>
				<div class="order-detail">
					Maaf, <strong>Pengajuan {{ $kd }}</strong> tidak di temukan, harap hubungi HRD terkait.
				</div>
			</div>
		</div>
	</div>
</body>
</html>
