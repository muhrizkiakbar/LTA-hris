@extends('layouts.backend2.app')
@section('content')
<div id="overlay" style="display:none;">
  <div class="spinner-border text-success m-1"></div>
  <br/>
  Loading...
</div>
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						@if (auth()->user()->role_id!=2)
						<a href="javascript:void(0);" class="btn btn-info btn-sm print mr-2">
							<i class="ri-printer-line align-middle mr-2"></i> CETAK
						</a>	
						@endif
						@if ($get->periksa_st==0)
						<a href="#" class="btn btn-success btn-sm mr-2 periksa" data-id="{{ $get->kd }}">
							<i class="ri-check-line align-middle mr-2"></i>PERIKSA
						</a>   
						@elseif ($get->periksa_st==1 && $get->approval1_st==0)
						<a href="#" class="btn btn-success btn-sm mr-2 setuju" data-id="{{ $get->kd }}">
							<i class="ri-check-line align-middle mr-2"></i>SETUJU
						</a> 
						@elseif ($get->periksa_st==1 && $get->approval1_st==1 && $get->approval2_st==0)
						<a href="#" class="btn btn-success btn-sm mr-2 ketahui" data-id="{{ $get->kd }}">
							<i class="ri-check-line align-middle mr-2"></i>MENGETAHUI
						</a> 
						@endif
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-12">
				@include('backend.template.alert')
				<div class="card">
					<div class="card-body">
						<div id="print_page">
              <div class="text-center mb-2">
                <h4 class="text-uppercase" style="font-weight: 800"><u>Pengajuan Surat Tugas</u></h4>
                <span style="font-size: 14px;">Nomor : LTA / ST / {{ $thn }} / {{ $bln }} / {{ $get->employee->nik }} / {{ $get->kd }} </span>
              </div>
							<table class="table table-bordered table-sm">
                <tr>
                  <td class="text-center" width="2%">NO</td>
                  <td class="text-center" width="30%">URAIAN</td>
                  <td class="text-center">KETERANGAN</td>
                </tr>
                <tr>
                  <td class="text-center">1</td>
                  <td>NIK Karyawan</td>
                  <td>{{ $employee->nik }}</td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td>Nama Karyawan</td>
                  <td>{{ $employee->name }}</td>
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td>Department</td>
                  <td>{{ !empty($get->department_id) ? $get->department->title : '-' }}</td>
                </tr>
                <tr>
                  <td class="text-center">4</td>
                  <td>Jabatan</td>
                  <td>{{ isset($get->department_jabatan_id) ? isset($get->department_jabatan) ? $get->department_jabatan->title : '-' : '-' }}</td>
                </tr>
                <tr>
                  <td class="text-center">5</td>
                  <td>Divisi</td>
                  <td>{{ !empty($get->divisi_id) ? $get->divisi->title : '-' }}</td>
                </tr>
                <tr>
                  <td class="text-center">6</td>
                  <td>No. Telp / Hp</td>
                  <td>{{ $employee->no_hp }}</td>
                </tr>
								<tr>
                  <td colspan="3" class="text-center"><strong>DETAIL SURAT TUGAS</strong></td>
                </tr>
                <tr>
                  <td class="text-center">1</td>
                  <td>Tanggal Tugas</td>
                  <td>{{ tgl_def($get->date_start) }} s/d {{ tgl_def($get->date_end) }}</td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td>Tujuan</td>
                  <td>{{ $get->desc }}</td>
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td>Keperluan</td>
                  <td>{{ $get->catatan }}</td>
                </tr>
              </table>
							<table class="table table-borderless">
                <tr>
                  <td>{{ $employee->lokasi }}, {{ tgl_indo($get->date) }}</td>
                </tr>
              </table>
              <table border="0" width="100%">
                <tr>
                  <td class="text-center" width="25%">Pemohon,</td>
                  <td class="text-center" width="25%">Diperiksa,</td>
                  <td class="text-center" width="25%">Disetujui,</td>
                  <td class="text-center" width="25%">Diketahui,</td>
                </tr>
                <tr>
                  <td class="text-center" width="25%">
                    <img style='width: 200px; margin-top: 10px; margin-bottom: 10px; height: 100px' src='{{ get_ttd($get->employee_id) }}'>
                  </td>
                  <td class="text-center" width="25%">
                    @if ($get->periksa_st==1) 
                      <img style='width: 200px; margin-top: 10px; margin-bottom: 10px; height: 100px' src='{{ get_ttd($get->periksa_id) }}'>
                    @endif
                  </td>
                  <td class="text-center" width="25%">
                    @if ($get->approval1_st==1) 
                      <img style='width: 200px; margin-top: 10px; margin-bottom: 10px; height: 100px' src='{{ get_ttd($get->approval1_id) }}'>
                    @endif
                  </td>
                  <td class="text-center" width="25%">
                    @if ($get->approval2_st==1) 
                      <img style='width: 200px; margin-top: 10px; margin-bottom: 10px; height: 100px' src='{{ get_ttd($get->approval2_id) }}'>
                    @endif
                  </td>
                </tr>
                <tr>
                  <td class="text-center" width="25%">
                    <u>{{ $employee->name }}</u> <br> 
                    {{ isset($get->jabatan_id) ? isset($get->department_jabatan) ? $get->department_jabatan->title : '-' : '-' }}
                  </td>
                  <td class="text-center" width="25%">                 
                    <u>{{ $get->periksa_hrd->name }}</u> <br>
                    {{ isset($get->periksa_hrd->department_jabatan_id) ? $get->periksa_hrd->jabatan->title : '-' }}
                  </td>
                  <td class="text-center" width="25%">
                    <u>{{ $get->approval_first->name }}</u> <br>
                    @if ($get->approval1_id=='1785' || $get->approval1_id=='1787' || $get->approval1_id=='1788')
                    {{ get_director_name($get->approval1_id) }} 
                    @else
                    {{ isset($get->approval_first->department_jabatan_id) ? isset($get->approval_first->jabatan) ? $get->approval_first->jabatan->title : '-' :'-' }}    
                    @endif
                  </td>
                  <td class="text-center" width="25%">
                    <u>{{ $get->approval_second->name }}</u> <br>
                    @if ($get->approval2_id=='1785' || $get->approval2_id=='1787' || $get->approval2_id=='1788')
                    {{ get_director_name($get->approval2_id) }} 
                    @else
                    {{ isset($get->approval_second->department_jabatan_id) ? isset($get->approval_second->jabatan) ? $get->approval_second->jabatan->title : '-' : '-' }}    
                    @endif
                  </td>
                </tr>
              </table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('customjs')
<script type="text/javascript">
	$(document).ready(function(){
		$(".print").bind("click", function(event) {
	  	$('#print_page').printArea();
	  });

		$(".periksa").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.surat.tugas_periksa') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/surat/tugas_detail/') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Push dokumen berhasil !',
              text: 'Anda akan di arahkan dalam 3 Detik',
              timer: 1500,
              showCancelButton: false,
              showConfirmButton: false
            }).then (function() {
              window.location.href = href
            });
					} else {
						$('#overlay').hide();
						Swal.fire(
							'Cancelled',
							'Your imaginary file is safe :)',
							'error'
						);
					}
        }
      });
    });

		$(".setuju").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.surat.tugas_setuju') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/surat/tugas_detail/') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Push dokumen berhasil !',
              text: 'Anda akan di arahkan dalam 3 Detik',
              timer: 1500,
              showCancelButton: false,
              showConfirmButton: false
            }).then (function() {
              window.location.href = href
            });
					} else {
						$('#overlay').hide();
						Swal.fire(
							'Cancelled',
							'Your imaginary file is safe :)',
							'error'
						);
					}
        }
      });
    });

		$(".ketahui").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.surat.tugas_ketahui') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/surat/tugas_detail/') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Push dokumen berhasil !',
              text: 'Anda akan di arahkan dalam 3 Detik',
              timer: 1500,
              showCancelButton: false,
              showConfirmButton: false
            }).then (function() {
              window.location.href = href
            });
					} else {
						$('#overlay').hide();
						Swal.fire(
							'Cancelled',
							'Your imaginary file is safe :)',
							'error'
						);
					}
        }
      });
    });

		$(".reject").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.surat.tugas_reject') }}';
			var token = '{{ csrf_token() }}';
			Swal.fire({
				title: 'Anda yakin reject pengajuan ?',
				icon: 'warning',
				showCancelButton: !0,
				confirmButtonText: "Ya, Reject !",
				cancelButtonText: "Tidak",
				confirmButtonClass: "btn btn-success btn-sm mt-2",
				cancelButtonClass: "btn btn-danger btn-sm ml-2 mt-2",
				buttonsStyling: !1,
			}).then(function(result) {
				if(result.value) {
					$('#overlay').fadeIn();
					$.ajax({
						url: url,
						type: "POST",
						data : { id:id, _token:token },
						dataType : "JSON",
						success: function (response){
							if (response.message=='sukses') {
								var base = "{{ url('/backend/cuti/tahunan/detail') }}";
								var href = base+"/"+response.id;
								$('#overlay').hide();
								Swal.fire({
									icon: 'success',
									type: 'success',
									title: 'Reject berhasil !',
									text: 'Anda akan di arahkan dalam 3 Detik',
									timer: 1500,
									showCancelButton: false,
									showConfirmButton: false
								}).then (function() {
									window.location.href = href
								});
							}
						}
					});
				} else if(result.dismiss === swal.DismissReason.cancel) {
					Swal.fire({
						title: 'Cancelled',
						text: 'Gagal reject pengajuan',
						icon: 'error',
						showConfirmButton: !1,
						timer: 1500
					});
				}
			});
    });

	});
</script>
@endsection