@extends('layouts.backend2.app')
@section('content')
<div id="overlay" style="display:none;">
  <div class="spinner"></div>
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
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-5">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">NIK {{ $row['nik'] }} {!! $row['resign_st']==1 ? '<span class="badge badge-danger">RESIGN</span>' : '' !!}</h6>
						<div class="page-title-right">
							@if ($row['resign_st']!=1)
							<div class="btn-group" role="group">
								<button type="button" class="btn btn-sm bg-grey-300 btn-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<i class="ri-equalizer-line"></i> <i class="mdi mdi-chevron-down"></i>
								</button>
								<div class="dropdown-menu">
									@if ($role=='1' || $role=='3' || $role=='4')
										<a href="javascript:void(0);" data-id="{{ $row['id'] }}" class="dropdown-item edit">Edit Data</a>
										<a href="javascript:void(0);" data-id="{{ $row['id'] }}" class="dropdown-item resign">Karyawan Resign</a>
									@endif
									<a href="javascript:void(0);" data-id="{{ $row['id'] }}" class="dropdown-item detail_cuti">Detail Cuti Karyawan</a>
									<a href="{{ route('backend.employee.reset_password',$row['id']) }}" onclick="return confirm('Anda yakin ingin reset password karyawan ?')" class="dropdown-item">Reset Password</a>
									<a href="javascript:void(0);" data-id="{{ $row['id'] }}" class="dropdown-item sign">Upload Tanda Tangan</a>
									
								</div>
							</div>
							@endif
						</div>
					</div>
					<div class="card-body">
						<table class="table table-striped table-borderless">
							<col style="width:40%">
							<col style="width:60%">
							<tr>
								<td colspan="2" class="text-center">
									{!! $row->image_pic !!}
								</td>
								<tr>
									<td>Nama</td>
									<td>{{ $row->name }}</td>
								</tr>
								<tr>
									<td>Tempat & Tanggal Lahir</td>
									<td>{{ $row->tempat_lahir }}, {{ tgl_indo($row->tgl_lahir) }}</td>
								</tr>
								<tr>
									<td>Handphone</td>
									<td>{{ $row->no_hp }}</td>
								</tr>
								<tr>
									<td>Email</td>
									<td>{{ $row->email }}</td>
								</tr>
								<tr>
									<td>Sloting Karyawan</td>
									<td>{{ isset($row->sloting) ? $row->sloting->kd : '-' }}</td>
								</tr>
								@if ($row->department_id==3)
								<tr>
									<td>Sales Code</td>
									<td>{{ $row->sales_code }}</td>
								</tr>		
								@endif
								<tr>
									<td>Status Belting</td>
									<td>{{ isset($row->training) ? $row->training->belting->title : '-' }}</td>
								</tr>
								<tr>
									<td>Tanggal Masuk</td>
									<td>{{ tgl_indo($row->join_date) }} <i>( {{ time_elapsed_string(date("Y-m-d H:i:s",strtotime($row->join_date)),true) }} )</i></td>
								</tr>
								<tr>
									<td>Golongan Darah</td>
									<td>{{ isset($row->blood_id) ? $row->blood->title : '-' }}</td>
								</tr>
								<tr>
									<td>Suku Bangsa</td>
									<td>{{ $row->suku }}</td>
								</tr>
								<tr>
									<td>Kewarganegaraan</td>
									<td>{{ isset($row->country) ? $row->country->title : '-' }}</td>
								</tr>
								<tr>
									<td>Status Karyawan</td>
									<td>
										{{ isset($row->kontrak) ? $row->kontrak->employee_sts->title : '-' }} <br>
										<i>{{ isset($row->kontrak) ? $row->kontrak->employee_sts_id==4 ? '' : '( Kontrak Berakhir : '.mediumdate_indo($row->kontrak->tgl_end).')' : '' }}</i>
									</td>
								</tr>
								<tr>
									<td>Divisi</td>
									<td>{{ isset($row->divisi) ? $row->divisi->title : '-'  }}</td>
								</tr>
								<tr>
									<td>Department</td>
									<td>{{ empty($row->department_id) ? '-' : $row->department->title }}</td>
								</tr>
								<tr>
									<td>Jabatan</td>
									<td>{{ isset($row->department_jabatan_id) ? isset($row->jabatan) ? $row->jabatan->title : '-' : '-' }}</td>
								</tr>
								<tr>
									<td>Atasan Langsung</td>
									<td>{{ empty($row->atasan_id) ? '-' : $row->atasan->name }}</td>
								</tr>
								<tr>
									<td>Distrik</td>
									<td>{{ empty($row->distrik_id) ? '-' : $row->distrik->title }}</td>
								</tr>
								<tr>
									<td>Lokasi Site</td>
									<td>{{ empty($row->lokasi_id) ? '-' : $row->lokasi }}</td>
								</tr>
								<tr>
									<td>BPJS TK</td>
									<td>{{ $row->bpjstk }}</td>
								</tr>
								<tr>
									<td>BPJS Kesehatan</td>
									<td>{{ $row->bpjs }}</td>
								</tr>
								<tr>
									<td>Bank</td>
									<td>{{ isset($row->bank_id) ? $row->bank->title : '-' }}</td>
								</tr>
								<tr>
									<td>Nomor Rekening</td>
									<td>{{ $row->no_rek }}</td>
								</tr>
								<tr>
									<td>Saldo Cuti Tahunan</td>
									<td>{{ $saldo_cuti }} Hari</td>
								</tr>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-7">
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Dokumen Pendukung</h6>
					</div>
					<div class="card-body">
						<table class="table table-striped table-borderless table-xs">
							<col style="width:25%">
							<col style="width:23%">
							<tr>
								<td>
									<span class="text-primary">
										<strong>KTP</strong>
									</span>
								</td>
								@if (isset($row->ktp))
								<td class="text-center" style="font-size: 20px">
									<i class="text-success fa fa-check"></i>
								</td>
								<td>{{ $row->ktp_no }}</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-sm ktp_view">
											<i class="fa fa-search"></i>
										</a>
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm ktp">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.ktp_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data KTP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@else
								<td class="text-center" style="font-size: 20px">
									<i class="text-warning fa fa-exclamation-triangle"></i>
								</td>
								<td>-</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm ktp">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.ktp_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data KTP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@endif
							</tr>
							<tr>
								<td>
									<span class="text-primary">
										<strong>Kartu Keluarga</strong>
									</span>
								</td>
								@if (isset($row->kk))
								<td class="text-center" style="font-size: 20px">
									<i class="text-success fa fa-check"></i>
								</td>
								<td>{{ $row->kk }}</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-sm kartu_keluarga_view">
											<i class="fa fa-search"></i>
										</a>
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm kartu_keluarga">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.kartu_keluarga_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Kartu Keluarga Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@else
								<td class="text-center" style="font-size: 20px">
									<i class="text-warning fa fa-exclamation-triangle"></i>
								</td>
								<td>-</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm kartu_keluarga">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.kartu_keluarga_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Kartu Keluarga Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@endif
							</tr>
							<tr>
								<td>
									<span class="text-primary">
										<strong>Ijazah</strong>
									</span>
								</td>
								@if (isset($row->ijazah))
								<td class="text-center" style="font-size: 20px">
									<i class="text-success fa fa-check"></i>
								</td>
								<td>{{ isset($row->ijazah_id) ? $row->ijazah_detail->title.' - '.$row->ijazah_institusi : '' }}</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-sm ijazah_view">
											<i class="fa fa-search"></i>
										</a>
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm ijazah">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.ijazah_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Ijazah / Pendidikan Terakhir Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@else
								<td class="text-center" style="font-size: 20px">
									<i class="text-warning fa fa-exclamation-triangle"></i>
								</td>
								<td>-</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm ijazah">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.ijazah_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Ijazah / Pendidikan Terakhir Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@endif
							</tr>
							<tr>
								<td>
									<span class="text-primary">
										<strong>NPWP</strong>
									</span>
								</td>
								@if (isset($row->npwp))
								<td class="text-center" style="font-size: 20px">
									<i class="text-success fa fa-check"></i>
								</td>
								<td>{{ $row->npwp_no }}</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-sm npwp_view">
											<i class="fa fa-search"></i>
										</a>
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm npwp">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.npwp_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data NPWP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@else
								<td class="text-center" style="font-size: 20px">
									<i class="text-warning fa fa-exclamation-triangle"></i>
								</td>
								<td>-</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm npwp">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.npwp_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data NPWP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@endif
							</tr>
							<tr>
								<td>
									<span class="text-primary">
										<strong>Bukti Padan NPWP</strong>
									</span>
								</td>
								@if (isset($row->bukti_padan))
								<td class="text-center" style="font-size: 20px">
									<i class="text-success fa fa-check"></i>
								</td>
								<td>{{ $row->bukti_padan }}</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-sm bukti_padan_view">
											<i class="fa fa-search"></i>
										</a>
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm bukti_padan">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.bukti_padan_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Bukti Padan NPWP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@else
								<td class="text-center" style="font-size: 20px">
									<i class="text-warning fa fa-exclamation-triangle"></i>
								</td>
								<td>-</td>
								<td class="text-right">
									<div class="btn-group btn-group-xs">
										@if ($row->resign_st!=1)																										
										<a href="javascript:void(0);" data-id="{{ $row->id }}" class="btn btn-info btn-sm bukti_padan">
											<i class="fa fa-upload"></i>
										</a>
										@endif
									</div>
								</td>
								<td class="text-right">
									@if ($row->resign_st!=1)
									<a href="{{ route('backend.employee.bukti_padan_delete',$row->id) }}"  onclick="return confirm('Anda yakin ingin hapus data Bukti Padan NPWP Karyawan ?')" class="btn btn-danger btn-sm">
										<i class="fa fa-times"></i>
									</a>
									@endif
								</td> 
								@endif
							</tr>
						</table>
					</div>
				</div>
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Kartu Vaksinasi</h6>
						<div class="page-title-right">
							@if ($row->resign_st!=1)
							<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-icon btn-sm vaksin">
								<i class="ri-add-line"></i>
							</a>
							@endif
						</div>
					</div>
					<table class="table table-striped table-borderless">
						<col style="width:45%">
						<col style="width:35%">
						<thead>
							<tr>
								<th class="text-center">Tipe Vaksinasi</th>
								<th class="text-center">Tanggal Vaksinasi</th>
								<th class="text-center">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($vaksin as $vaksin_item)
							<tr>
								<td>{{ $vaksin_item->vaksin_type->title }}</td>
								<td class="text-center">{{ $vaksin_item->date }}</td>
								<td class="text-center">
									<a href="javascript:void(0)" class="vaksin_view" data-id="{{ $vaksin_item->id }}">
										<span class="badge badge-success">Detail</span>
									</a>
									<a href="{{ route('backend.employee.vaksin.delete',$vaksin_item->id) }}" onclick="return confirm('Anda yakin ingin hapus data ?')">
										<span class="badge badge-danger">Delete</span>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Konseling</h6>
						<div class="page-title-right">
							@if ($row->resign_st!=1)
							<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-icon btn-sm konseling">
								<i class="ri-add-line"></i>
							</a>
							@endif
						</div>
					</div>
					<table class="table table-striped table-borderless">
						<col style="width:25%">
						<col style="width:55%">
						<thead>
							<tr>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Catatan</th>
								<th class="text-center" width="150px">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($konseling as $konseling_item)
							<tr>
								<td class="text-center">{{ $konseling_item->date }}</td>
								<td>{{ $konseling_item->catatan }}</td>
								<td class="text-center">
									<a href="javascript:void(0)" class="vaksin_view" data-id="{{ $konseling_item->id }}">
										<span class="badge badge-success">Detail</span>
									</a>
									<a href="{{ route('backend.employee.vaksin.delete',$konseling_item->id) }}" onclick="return confirm('Anda yakin ingin hapus data ?')">
										<span class="badge badge-danger">Delete</span>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Surat Peringatan</h6>
						<div class="page-title-right">
							@if ($row->resign_st!=1)
							<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-icon btn-sm surat_peringatan">
								<i class="ri-add-line"></i>
							</a>
							@endif
						</div>
					</div>
					<table class="table table-striped table-borderless">
						<thead>
							<tr>
								<th class="text-center">Nomor Surat</th>
								<th class="text-center">Surat Peringatan</th>
								<th class="text-center">Tanggal</th>
								<th class="text-center">Expired</th>
								<th class="text-center">Pelanggaran</th>
								<th class="text-center" width="110px">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($surat_peringatan as $sp)
							<tr>
								<td>{{ $sp->nomor }}</td>
								<td>{{ $sp->sp->title }}</td>
								<td class="text-center">{{ tgl_indo($sp->date) }}</td>
								<td class="text-center">{{ tgl_indo($sp->expired) }}</td>
								<td>{{ $sp->pelanggaran }}</td>
								<td class="text-center">
									<div class="dropdown">
										<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											Actions <i class="mdi mdi-chevron-down"></i>
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="">
											<a href="{{ route('backend.employee.surat_peringatan.view',$sp->id) }}" class="dropdown-item text-success" target="_blank">Print</a>
											<a href="{{ route('backend.employee.surat_peringatan.delete',$sp->id) }}" class="dropdown-item text-danger" onclick="return confirm('Anda yakin ingin hapus data ?')">Delete</a>
										</div>
									</div>
								</td>
							</tr>  	
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Performance Appraisal</h6>
						<div class="page-title-right">
							@if ($row->resign_st!=1)
							<a href="#" data-id="{{ $row->id }}" class="btn btn-success btn-icon btn-sm appraisal">
								<i class="ri-add-line"></i>
							</a>
							@endif
						</div>
					</div>
					<table class="table table-striped table-bordered table-sm">
						<thead>
							<tr>
								<th class="text-center">Periode</th>
								<th class="text-center">Atasan Langsung</th>
								<th class="text-center">Total Nilai</th>
								<th class="text-center" width="120px">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($appraisal->get() as $appraisal)
							<tr>
								<td>{{ date('F Y',strtotime($appraisal->date_start)) }} - {{ date('F Y',strtotime($appraisal->date_end)) }}</td>
								<td class="text-center">{{ $appraisal->atasan->name }}</td>
								<td class="text-center">{{ $appraisal->score_total }}</td>
								<td class="text-center">
									<a href="{{ route('backend.employee.appraisal.view',$appraisal->id) }}" target="_blank">
										<span class="badge badge-primary">
											Detail
										</span>
									</a>
									<a href="{{ route('backend.employee.appraisal.delete',$appraisal->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
										<span class="badge badge-danger">
											Delete
										</span>
									</a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="card">
					<div class="card-header d-flex align-items-center justify-content-between">
						<h6 class="card-title">Absensi {{ date('Y') }}</h6>
					</div>
					<table class="table table-striped table-bordered table-sm">
						<thead>
							<tr>
								<th class="text-center">Periode</th>
								<th class="text-center">Sakit</th>
								<th class="text-center">Izin</th>
								<th class="text-center">Alpa</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($absensi_yearly as $absensi)
							<tr>
								<td>{{ $absensi['periode'] }}</td>
								<td class="text-center">{{ $absensi['monthly_sakit'] }} Hari</td>
								<td class="text-center">{{ $absensi['monthly_izin'] }} Hari</td>
								<td class="text-center">{{ $absensi['monthly_alpa'] }} Hari</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="modalEx" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
</div>
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
    $(".edit").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.edit') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".detail_cuti").click(function(e) {
			var id = $(this).data('id');
      var url = '{{ route('backend.employee.detail_cuti') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
		});

		$(".sign").click(function(e) {
			var id = $(this).data('id');
      var url = '{{ route('backend.employee.sign') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
		});

		$(".ktp").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.ktp') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".ktp_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.ktp_view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".kartu_keluarga").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.kartu_keluarga') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".kartu_keluarga_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.kartu_keluarga_view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".ijazah").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.ijazah') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".ijazah_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.ijazah_view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".npwp").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.npwp') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".npwp_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.npwp_view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".bukti_padan").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.bukti_padan') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".bukti_padan_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.bukti_padan_view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".vaksin").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.vaksin') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".vaksin_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.vaksin.view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".konseling").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.konseling') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".konseling_view").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.konseling.view') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".surat_peringatan").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.surat_peringatan') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".appraisal").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.appraisal') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

		$(".resign").click(function(e) {
      var id = $(this).data('id');
      var url = '{{ route('backend.employee.resign.create') }}';
			var token = '{{ csrf_token() }}';
      $.ajax({
        url: url,
        type: "POST",
        data : { id:id, _token:token },
        success: function (ajaxData){
          $("#modalEx").html(ajaxData);
          $("#modalEx").modal('show',{backdrop: 'true'});
        }
      });
    });

  });
</script>
@endsection