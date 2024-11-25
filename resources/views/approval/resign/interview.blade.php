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
	<div class="header">
		<div class="row justify-content-between">
			<div class="col-5">
				<div class="header-logo">
					<em>Exit Interview Form</em>
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
						<h4 class="text-uppercase" style="font-size: 16px; font-weight: 600"><u>{{ $title }}</u></h4>
						<span style="font-size: 12px;">Nomor : LTA / {{ $doc }} / {{ $thn }} / {{ $bln }} / {{ $row->nik }}</span>
					</div>
				</div>
				@if ($resign_interview_st==1)
					<div class="text-center">
						<h3>Interview, telah di lakukan !!!</h3>
					</div>
				@else
				<div class="order-detail">
					{!! Form::open(['route'=>'resign.interview.store','method'=>'POST','files' => true]) !!}
					<table class="table table-borderless table-sm">
						@php
							$no=1;
							$nox=0;
						@endphp
						@foreach ($score as $item)
						<tr>
							<td style="font-size: 14px;" class="text-center" width="5px">{{ $no.') '}}</td>
							<td style="font-size: 14px;">{{ $item['title'] }}</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="hidden" name="id[<?php echo $nox;?>]" value="<?php echo $nox;?>">
                <input type="hidden" name="idx[]" value="{{ $item['id'] }}">
								@if (!empty($item['key']))
									@if ($item['id']==5)
										@foreach ($item['key'] as $key)
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="check[<?php echo $nox?>][]" value="{{ $key['id'] }}">
											<label class="form-check-label" for="defaultCheck1">
												{{ $key['title'] }}	
											</label>
										</div>
										@endforeach
									@else
										@foreach ($item['key'] as $key)
										<div class="form-check">
											<input class="form-check-input" type="radio" name="check[<?php echo $nox?>]" value="{{ $key['id'] }}" required>
											<label class="form-check-label">
												{{ $key['title'] }}	
											</label>
										</div>
										@endforeach
									@endif
								@else
									<input type="text" class="form-control form-control-sm" name="check[<?php echo $nox?>]" required>
								@endif
								<br>
							</td>
						</tr>
						@php
							$no++;
							$nox++;
						@endphp
						@endforeach
						<input type="hidden" name="users_id" value="{{ $users_id }}">
						<input type="hidden" name="code" value="{{ $code }}">
						<tr>
							<td colspan="2">
								<button type="submit" class="btn btn-success btn-sm btn-block">Submit Interview</button>
							</td>
						</tr>
					</table>
					{!! Form::close() !!}
				</div>
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
		var url = '{{ route('resign.interview.otp') }}';
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
</script>
