<div class="col-xl-4">
	<div class="card">
		<div class="card-body">
			@if (auth()->user()->role_id==1 || auth()->user()->role_id==2)			
			<div class="dropdown float-right">
				<a href="#" class="dropdown-toggle arrow-none card-drop" data-toggle="dropdown" aria-expanded="false">
					<i class="mdi mdi-dots-vertical"></i>
				</a>
				<div class="dropdown-menu dropdown-menu-right" style="">
					<a href="javascript:void(0);" class="dropdown-item hari_kerja">Update</a>
				</div>
			</div>
			@endif
			<h4 class="card-title mb-3">Hari Kerja Periode {{ date('F Y') }}</h4>
			<div class="media">
				<div class="media-body overflow-hidden">
					<p class="text-truncate font-size-14 mb-2"></p>
					<h4 class="font-size-56">{{ $payroll_config->hari_kerja }}</h4>
				</div>
				<div class="text-primary">
					<i class="ri-calendar-event-line font-size-56"></i>
				</div>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between bg-info">
			<h6 class="card-title text-white"><strong>Deadline</strong> Kontrak Kerja Karyawan</h6>
			<div class="page-title-right">
				<span class="badge badge-danger">{{ count($kontrak) }}</span>
			</div>
		</div>
		<table class="table table-sm table-striped" style="font-size: 11px">
			<tbody>
				@foreach ($kontrak as $item)
				<tr>
					<td>
						<div class="d-flex align-items-center">
							<div>
								<strong>{{ $item->name }}</strong><br>
								{{ $item->jabatan }}<br>
								Status Kontrak : {{ $item->kontrak }} <br>
								Lokasi : {{ $item->lokasi }}
							</div>
						</div>
					</td>
					<td>
						<div class="text-right">
							<?php echo date("d-m-Y",strtotime($item->expired_date));?>
							<?php echo daysdiffxx($item->expired_date);?>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<div class="col-xl-8">
	<div class="card">
		<div class="card-header d-flex align-items-center justify-content-between bg-success">
			<h6 class="card-title text-white">Grafik Absensi Karyawan - {{ date('F') }}</h6>
		</div>
		<div class="card-body">
			<div id="chart-absensi" class="apex-charts"></div>
		</div>
	</div>
	<div class="row">
		<div class="col-xl-6">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between bg-success">
					<h6 class="card-title text-white">Jumlah Karyawan</h6>
				</div>
				<div class="card-body">
					<div id="chart-karyawan-gender" class="apex-charts"></div>
					<div class="row">
						@foreach ($karyawan_gender as $karyawan_gender)
						<div class="col-6">
							<div class="text-center mt-4">
								<p class="mb-2">
									{{ $karyawan_gender['label'] }}
								</p>
								@php
									$percent = ($karyawan_gender['total'] / $karyawan_gender_sum) * 100;
								@endphp
								<h5>{{ round($percent,2) }} %</h5>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between bg-primary">
					<h6 class="card-title text-white">Kontrak Karyawan</h6>
				</div>
				<div class="card-body">
					<div id="chart-kontrak" class="apex-charts"></div>
					<div class="row">
						@foreach ($group_kontrak as $group_kontrak)
						<div class="col-4">
							<div class="text-center mt-4">
								<p class="mb-2">
									<i class="mdi mdi-circle {{ $group_kontrak['label'] }} font-size-10 mr-1"></i> 
									{{ $group_kontrak['kontrak'] }}
								</p>
								@php
									$percent = ($group_kontrak['total'] / $group_kontrak_sum) * 100;
								@endphp
								<h5>{{ round($percent,2) }} %</h5>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-6">
			<div class="card">
				<div class="card-header d-flex align-items-center justify-content-between bg-warning">
					<h6 class="card-title text-white">Umur Karyawan</h6>
				</div>
				<div class="card-body">
					<div id="chart-range-ages" class="apex-charts"></div>
				</div>
			</div>
		</div>
	</div>
</div>	