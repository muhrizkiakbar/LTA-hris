<!-- App favicon -->
<!-- Bootstrap Css -->
<link href="{{ asset('assets/backend/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="{{ asset('assets/backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="{{ asset('assets/backend/css/app.css') }}" rel="stylesheet" type="text/css" />
<?php if (!empty($assets['style'])): ?>
	<?php foreach ($assets['style'] as $style): ?>
		<link href="{{asset($style)}}" rel="stylesheet">
	<?php endforeach ?>
<?php endif ?>

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/backend/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/backend/libs/node-waves/waves.min.js') }}"></script>
<?php if (!empty($assets['script'])): ?>
	<?php foreach ($assets['script'] as $script): ?>
		<script src="{{ asset($script) }}"></script>
	<?php endforeach ?>
<?php endif ?>