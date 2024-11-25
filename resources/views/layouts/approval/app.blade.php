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
		@include('layouts.approval.assets')
	</head>
	<body data-sidebar="dark">
		<div id="layout-wrapper">
			<div class="main-content">
				@yield('content')
			</div>
		</div>
		<script src="{{ asset('assets/backend/js/app.js') }}"></script>
		@yield('customjs')
	</body>
</html>