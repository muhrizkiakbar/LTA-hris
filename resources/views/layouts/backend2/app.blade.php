<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta content="ERP 2.0 Integrated System ERP & SAP" name="description" />
		<meta content="IT Team" name="author" />
		<link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
		<title>{{ isset($title) ? $title.' | ' : '' }}Human Resources Information System | LTA - TAA</title>
		@include('layouts.backend2.assets')
	</head>
	<body data-sidebar="dark">
		<div id="layout-wrapper">
			@include('layouts.backend2.header')
			@include('layouts.backend2.sidebar')
			<div class="main-content">
				@yield('content')
				@include('layouts.backend2.footer')
			</div>
		</div>
		<div id="modalEx99" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
		</div>
		<script src="{{ asset('assets/backend/js/app.js') }}"></script>
		@yield('customjs')
		<script type="text/javascript">
			$(document).ready(function(){
				$(".change_password").click(function(e) {
					var url = '{{ route('backend.password') }}';
					var token = '{{ csrf_token() }}';
					$.ajax({
						url: url,
						type: "POST",
						data : { _token:token },
						success: function (ajaxData){
							$("#modalEx99").html(ajaxData);
							$("#modalEx99").modal('show',{backdrop: 'true'});
						}
					});
				});
			});
		</script>
	</body>
</html>