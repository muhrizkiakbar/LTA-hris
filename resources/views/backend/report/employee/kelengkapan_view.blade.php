<div class="card">
  <div class="text-center mb-2 mt-2">
    <h4 style="font-weight: 400;">Report Data Karyawan</h4>
  </div>
	<table class="tablex table-bordered table-hover table-sm">
		<thead>
			<th class="text-center" width="2px">No</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama Karyawan</th>
			<th class="text-center">Department</th>
			<th class="text-center">Level Jabatan</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">KTP</th>
			<th class="text-center">Kartu Keluarga</th>
			<th class="text-center">Ijazah</th>
			<th class="text-center">NPWP</th>
			<th class="text-center">Bukti Padan</th>
		</thead>
		<tbody>
			@if (empty($row))
				<tr>
					<td colspan="11" class="text-center">
						<i>Maaf, Data Tidak Ditemukan</i>
					</td>
				</tr>
			@else
				@php $no=1; @endphp
				@foreach ($row as $item)
				<tr>
					<td class="text-center">{{ $no++ }}</td>
					<td class="text-center">{{ $item->nik }}</td>
					<td>{{ $item->name }}</td>
					<td class="text-center">{{ isset($item->department) ? $item->department->title : '-' }}</td>
					<td>{{ isset($item->jabatan) ? $item->jabatan->title : '-' }}</td>
					<td>{{ isset($item->lvl) ? $item->lvl->title : '-' }}</td>
					<td class="text-center">{!! isset($item->ktp) ? 'YA' : '<div class="text-danger">TIDAK ADA</i></div>' !!}</td>
					<td class="text-center">{!! isset($item->kk) ? 'YA' : '<div class="text-danger">TIDAK ADA</i></div>' !!}</td>
					<td class="text-center">{!! isset($item->ijazah) ? 'YA' : '<div class="text-danger">TIDAK ADA</i></div>' !!}</td>
					<td class="text-center">{!! isset($item->npwp) ? 'YA' : '<div class="text-danger">TIDAK ADA</i></div>' !!}</td>
					<td class="text-center">{!! isset($item->bukti_padan_file) ? 'YA' : '<div class="text-danger">TIDAK ADA</i></div>' !!}</td>
				</tr>
				@endforeach
			@endif
			</tbody>
	</table>
</div>
