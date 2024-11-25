<div class="card">
	<div class="table-responsive">
    <table class="tablex table-bordered table-hover table-sm">
      <thead>
				<tr>
          <th class="text-center">No</th>
          <th class="text-center">Tanggal Pengajuan</th>
					<th class="text-center">Tanggal Approval</th>
          <th class="text-center">Nomor Perdin</th>
          <th class="text-center">NIK</th>
          <th class="text-center">Nama</th>
          <th class="text-center">Perusahaan</th>
          <th class="text-center">Cabang</th>
          <th class="text-center">Department</th>
          <th class="text-center">Jabatan</th>
          <th class="text-center">Principal</th>
          <th class="text-center">Bank</th>
          <th class="text-center">No. Rek</th>
          <th class="text-center">Tujuan</th>
					<th class="text-center">Keperluan</th>
					<th class="text-center">Tanggal Berangkat</th>
					<th class="text-center">Tanggal Kembali</th>
					<th class="text-center">Jenis Transport</th>
					<th class="text-center">Biaya Transportasi</th>
					<th class="text-center">Biaya Hotel</th>
					<th class="text-center">Uang Makan</th>
					<th class="text-center">Total Transfer</th>
        </tr>
			</thead>
			<tbody>
				@php
						$no=1;
				@endphp
				@foreach ($row as $item)
				<tr {!! isset($item->trf_date) ? 'class="table-success"' : '' !!}>
					<td class="text-center">{{ $no++ }}</td>
					<td>{{ $item->date }}</td>
					<td>{{ date('Y-m-d',strtotime($item->updated_at)) }}</td>
					<td>{{ $item->kd }} {!! isset($item->trf_date) ? '<strong>['.$item->trf_date.']</strong>' : '' !!}</td>
					<td>{{ $item->employee->nik }}</td>
					<td>{{ $item->employee->name }}</td>
					<td>{{ $item->employee->perusahaan->title }}</td>
					<td>{{ $item->employee->distrik->title }}</td>
					<td>{{ $item->department->title }}</td>
					<td>{{ $item->jabatan->title }}</td>
					<td>{{ $item->employee->divisi->title }}</td>
					<td>{{ $item->employee->bank->title }}</td>
					<td>{{ $item->employee->no_rek }}</td>
					<td>{{ dinas_lokasi($item->id) }}</td>
					<td>{{ $item->desc }}</td>
					<td>{{ $item->date_start }}</td>
					<td>{{ $item->date_end }}</td>
					<td>{{ dinas_kendaraan($item->id) }}</td>
					<td class="text-right">{{ rupiahnon($item->estimasi_harga) }}</td>
					<td class="text-right">{{ rupiahnon($item->uang_hotel) }}</td>
					<td class="text-right">{{ rupiahnon($item->uang_makan) }}</td>
					<td class="text-right">{{ rupiahnon($item->total_harga) }}</td>
				</tr>	
				@endforeach
			</tbody>
		</table>
	</div>
</div>