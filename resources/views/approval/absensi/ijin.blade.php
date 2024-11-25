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
					<em>Approval HRIS</em>
				</div>
			</div>
			<div class="col-7">
				<div class="header-action">
					@if (empty($row->status) || $row->status!=2)
						@if ($row->approval2_st==0 && $status=='approval2')
						<a href="{{ route('approval.absensi_ijin.ketahui',$code) }}" class="btn2">
							<i class="ri-check-line align-middle mr-2"></i> Mengetahui
						</a>
						<a href="javascript:void(0);" class="btn reject">
							<i class="ri-close-line align-middle mr-2"></i> Reject
						</a>
						@elseif ($row->approval1_st==0 && $status=='approval1')
						<a href="{{ route('approval.absensi_ijin.setuju',$code) }}" class="btn2">
							<i class="ri-check-line align-middle mr-2"></i> Setuju
						</a>
						<a href="javascript:void(0);" class="btn reject">
							<i class="ri-close-line align-middle mr-2"></i> Reject
						</a>
						@elseif ($row->periksa_st==0 && $status=='periksa')
						<a href="{{ route('approval.absensi_ijin.periksa',$code) }}" class="btn2">
							<i class="ri-check-line align-middle mr-2"></i> Periksa
						</a>
						<a href="javascript:void(0);" class="btn reject">
							<i class="ri-close-line align-middle mr-2"></i> Reject
						</a>
						@endif
					@else
						<span>Reject By : {{ isset($row->reject_user) ? $row->reject_user->name : ''  }}</span>
					@endif
				</div>
			</div>
		</div>
	</div>
	<div id="print_page">
		<div class="evoucher-wrapper evoucher-wrapper-new">
			<div class="evoucher-body">
				<div class="order-information">
					<div class="text-center mb-2">
						<h4 class="text-uppercase" style="font-size: 16px; font-weight: 600"><u>Pengajuan {{ $tipe==5 ? 'Dinas Luar' : 'Ijin Karyawan' }}</u></h4>
						<span style="font-size: 12px;">Nomor : LTA / SIK / {{ $thn }} / {{ $bln }} / {{ $row->employee->nik }} / {{ $row->kd }}</span>
					</div>
				</div>
				<div class="order-detail">
					<table class="table table-bordered table-sm">
						<tr>
							<td class="text-center" width="2%">NO</td>
							<td class="text-center" width="30%">URAIAN</td>
							<td class="text-center">KETERANGAN</td>
						</tr>
						<tr>
							<td class="text-center">1</td>
							<td>NIK Karyawan</td>
							<td>{{ $row->employee->nik }}</td>
						</tr>
						<tr>
							<td class="text-center">2</td>
							<td>Nama Karyawan</td>
							<td>{{ $row->employee->name }}</td>
						</tr>
						<tr>
							<td class="text-center">3</td>
							<td>Department</td>
							<td>{{ !empty($row->department_id) ? $row->department->title : '-' }}</td>
						</tr>
						<tr>
							<td class="text-center">4</td>
							<td>Jabatan</td>
							<td>{{ !empty($row->department_jabatan_id) ? $row->department_jabatan->title : '-' }}</td>
						</tr>
						<tr>
							<td class="text-center">5</td>
							<td>Divisi</td>
							<td>{{ !empty($row->divisi_id) ? $row->divisi->title : '-' }}</td>
						</tr>
						<tr>
							<td class="text-center">6</td>
							<td>No. Telp / Hp</td>
							<td>{{ $row->employee->no_hp }}</td>
						</tr>
						<tr>
							<td class="text-center">7</td>
							<td>Cabang</td>
							<td>{{ $row->employee->lokasi }}</td>
						</tr>
						<tr>
							<td colspan="3" class="text-center"><strong>DETAIL {{ $tipe==5 ? 'DINAS LUAR' : 'IJIN KARYAWAN' }}</strong></td>
						</tr>
						<tr>
							<td class="text-center">1</td>
							<td>Tanggal Ijin</td>
							<td>{{ tgl_def($row->date_start) }} S/D {{ tgl_def($row->date_end) }} </td>
						</tr>
						<tr>
							<td class="text-center">2</td>
							<td>Tipe Ijin</td>
							<td>{{ $row->absensi_ijin_type->title }} {{ isset($row->keterangan) ? '('.$row->keterangan.')' : '' }}</td>
						</tr>
						<tr>
							<td class="text-center">3</td>
							<td>File Pendukung</td>
							<td>
								@if (empty($row->file))
								-  
								@else
								<a href="{{ Storage::url('upload/employee/'.$row->employee->nik.'/'.$row->file) }}" target="_blank">
									{{ $row->file }}
								</a>
								@endif
							</td>
						</tr>
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
							<td>{{ $row->employee->lokasi }}, {{ tgl_indo($row->date_start) }}</td>
						</tr>
					</table>
					<table class="table table-borderless table-sm" width="100%">
						<tr>
							<td class="text-center" width="25%">Pemohon,</td>
							<td class="text-center" width="25%">Diperiksa,</td>
							<td class="text-center" width="25%">Disetujui,</td>
							<td class="text-center" width="25%">Diketahui,</td>
						</tr>
						<tr>
							<td class="text-center" width="25%">
								<img src='{{ get_ttd($row->users_id) }}'>
							</td>
							<td class="text-center" width="25%">
								@if ($row->periksa_st==1) 
									<img src='{{ get_ttd($row->periksa_id) }}'>
								@endif
							</td>
							<td class="text-center" width="25%">
								@if ($row->approval1_st==1) 
									<img src='{{ get_ttd($row->approval1_id) }}'>
								@endif
							</td>
							<td class="text-center" width="25%">
								@if ($row->approval2_st==1) 
									<img src='{{ get_ttd($row->approval2_id) }}'>
								@endif
							</td>
						</tr>
						<tr>
							<td class="text-center" width="25%">
								<u>{{ $row->employee->name }}</u> <br> 
								{{ isset($row->jabatan_id) ? $row->department_jabatan->title : '-' }}
							</td>
							<td class="text-center" width="25%">                 
								<u>{{ $row->periksa_hrd->name }}</u> <br>
								{{ isset($row->periksa_hrd->department_jabatan_id) ? $row->periksa_hrd->jabatan->title : '-' }}
							</td>
							<td class="text-center" width="25%">
								<u>{{ $row->approval_first->name }}</u> <br>
								@if ($row->approval1_id=='1785' || $row->approval1_id=='1787' || $row->approval1_id=='1788')
								{{ get_director_name($row->approval1_id) }} 
								@else
								{{ isset($row->approval_first->department_jabatan_id) ? $row->approval_first->jabatan->title : '-' }}    
								@endif
							</td>
							<td class="text-center" width="25%">
								<u>{{ $row->approval_second->name }}</u> <br>
								@if ($row->approval2_id=='1785' || $row->approval2_id=='1787' || $row->approval2_id=='1788')
								{{ get_director_name($row->approval2_id) }} 
								@else
								{{ isset($row->approval_second->department_jabatan_id) ? $row->approval_second->jabatan->title : '-' }}    
								@endif
							</td>
						</tr>
					</table>
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
		var url = '{{ route('approval.absensi_ijin.otp') }}';
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
      var url = '{{ route('approval.absensi_ijin.reject') }}';
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