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
                <h4 class="text-uppercase" style="font-weight: 800"><u>Pengajuan Perjalanan Dinas</u></h4>
                <span style="font-size: 14px;">Nomor : LTA / PD / {{ $thn }} / {{ $bln }} / {{ $get->employee->nik }} / {{ $get->kd }} </span>
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
                  <td colspan="3" class="text-center"><strong>DETAIL PERJALANAN DINAS</strong></td>
                </tr>
                <tr>
                  <td class="text-center">1</td>
                  <td>Tanggal Dinas</td>
                  <td>{{ tgl_def($get->date_start) }} S/D {{ tgl_def($get->date_end) }} </td>
                </tr>
                <tr>
                  <td class="text-center">2</td>
                  <td>Lama Dinas</td>
                  <td>{{ $get->lama_dinas }} Hari</td>
                </tr>
                <tr>
                  <td class="text-center">3</td>
                  <td>Tipe Perjalanan Dinas</td>
                  <td>{{ $get->dinas_tipe->title }}</td>
                </tr>
                <tr>
                  <td class="text-center">4</td>
                  <td>Keperluan / Catatan</td>
                  <td>
                    <b>Keperluan :</b><br>
                    {!! isset($get->desc) ? $get->desc.'<br>' : '-' !!}
                    <b>Catatan :</b><br>
                    {!! isset($get->catatan) ? $get->catatan.'<br>' : '-' !!}
                  </td>
                </tr>
                @if ($lines->count()==0)
                <tr>
                  <td class="text-center">6</td>
                  <td>Kendaraan</td>
                  <td>{{ $get->dinas_kendaraan->title }}</td>
                </tr>
                <tr>
                  <td class="text-center">7</td>
                  <td>Estimasi Jarak</td>
                  <td>{{ $get->jarak }} Km</td>
                </tr>
                <tr>
                  <td class="text-center">8</td>
                  <td>Biaya Transportasi</td>
                  <td>@currency($get->estimasi_harga)</td>
                </tr>
                <tr>
                  <td class="text-center">9</td>
                  <td>Uang Makan</td>
                  <td>@currency($get->uang_makan)</td>
                </tr>
                <tr>
                  <td class="text-center">10</td>
                  <td>Uang Hotel</td>
                  <td>@currency($get->uang_hotel)</td>
                </tr>
                <tr>
                  <td class="text-center">11</td>
                  <td>Estimasi Total Biaya</td>
                  <td>@currency($get->total_harga)</td>
                </tr>  
                @else
                <tr>
                  <td colspan="3" class="text-center"><strong>DETAIL KENDARAAN PERJALANAN DINAS</strong></td>
                </tr>
                <?php $no=1;  ?>
                @foreach ($lines as $lines)
                  @if ($lines->dinas_kendaraan_id==1 || $lines->dinas_kendaraan_id==2)
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $lines->kendaraan->title }}</td>
                    <td>
                      @if ($lines->lokasi_asal_id!=0 && $lines->lokasi_tujuan_id!=0)
                      Rute Trip : {{ $lines->lokasi_asal->title }} - {{ $lines->lokasi_tujuan->title }} <br>
                      @endif
                      Estimasi Jarak {{ isset($lines->twoway) ? $lines->twoway==1 ? '(Pulang - Pergi)' : '(Sekali Jalan)' : '' }} : {{ $lines->jarak }} Km  <br>
                      @if (!empty($lines->jarak_toleransi))
                      Jarak Toleransi : {{ $lines->jarak_toleransi }} Km  <br>
                      @endif
                      Pemakaian BBM : {{ $lines->pemakaian_bbm }} Liter<br>
                      Biaya BBM : @currency($lines->estimasi_harga)
                      @if (!empty($lines->dinas_biaya_tol_id))
                      <br>
                      Biaya Tol {{ isset($lines->twoway_tol) ? $lines->twoway_tol==1 ? '(Pulang - Pergi)' : '(Sekali Jalan)' : '' }} : @currency($lines->dinas_biaya_tol_harga)
                      @endif
                      <br>
                      <strong>Estimasi Harga : @currency($lines->total_harga)</strong>
                    </td>
                  </tr>    
                  @else
                  <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $lines->kendaraan->title }}</td>
                    <td>
                      @if ($lines->lokasi_asal_id!=0 && $lines->lokasi_tujuan_id!=0)
                      Rute Trip : {{ $lines->lokasi_asal->title }} - {{ $lines->lokasi_tujuan->title }} <br>
                      @endif
                      <strong>Estimasi Harga : @currency($lines->total_harga)</strong>
                    </td>
                  </tr>
                  @endif
                @endforeach
                <tr>
                  <td colspan="2">
                    <strong>Estimasi Biaya Kendaraan</strong>
                  </td>
                  <td>@currency($get->estimasi_harga)</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Uang Makan</strong>
                  </td>
                  <td>@currency($get->uang_makan)</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Uang Hotel</strong>
                  </td>
                  <td>@currency($get->uang_hotel)</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <strong>Estimasi Total Biaya</strong>
                  </td>
                  <td><strong>@currency($get->total_harga)</strong></td>
                </tr>
								@if (isset($get->trf_date))
								<tr>
									<td colspan="2">
										<strong>Transfer Langsung</strong>
									</td>
									<td><strong>{{ $get->trf_date }}</strong></td>
								</tr>
								@endif
                @endif
								@if ($get->status==2)
								<tr>
									<td colspan="3" class="text-danger">
										{{ $get->reject_excuse }} <br><br>
										Reject By : {{ $get->reject_user->name }}
									</td>
								</tr>
								@endif
								
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
                    <img style='width: 200px; margin-top: 10px; margin-bottom: 10px; height: 100px' src='{{ get_ttd($get->users_id) }}'>
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
      var url = '{{ route('backend.dinas.periksa') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/dinas/detail') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Approval dokumen berhasil !',
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
      var url = '{{ route('backend.dinas.setuju') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/dinas/detail') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Approval dokumen berhasil !',
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
      var url = '{{ route('backend.dinas.ketahui') }}';
			var token = '{{ csrf_token() }}';
			$('#overlay').fadeIn();
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
				dataType : "JSON",
        success: function (response){
					if (response.message=='sukses') {
						var base = "{{ url('/backend/dinas/detail') }}";
            var href = base+"/"+response.id;
						$('#overlay').hide();
						Swal.fire({
              icon: 'success',
              type: 'success',
              title: 'Approval dokumen berhasil !',
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
	});
</script>
@endsection