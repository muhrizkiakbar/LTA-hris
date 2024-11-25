<div class="card">
  <div class="text-center mb-2 mt-2">
    <h4 style="font-weight: 400;">Report Data Karyawan</h4>
  </div>
	<table class="tablex table-bordered table-hover table-sm">
		<thead>
			<th class="text-center" width="2px">No</th>
			<th class="text-center">NIK</th>
			<th class="text-center">Nama Karyawan</th>
			<th class="text-center">Distrik</th>
			<th class="text-center">Lokasi Kerja</th>
			<th class="text-center">Department</th>
			<th class="text-center">Level Jabatan</th>
			<th class="text-center">Jabatan</th>
			<th class="text-center">Atasan Langsung</th>
			<th class="text-center">Principle</th>
			<th class="text-center">Email</th>
			<th class="text-center">No HP</th>
			<th class="text-center">#</th>
		</thead>
		<tbody>
			@if (empty($row))
				<tr>
					<td colspan="13" class="text-center">
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
					<td class="text-center">{{ isset($item->distrik) ? $item->distrik->title : '-'  }}</td>
					<td class="text-center">{{ $item->lokasi }}</td>
					<td class="text-center">{{ isset($item->department) ? $item->department->title : '-' }}</td>
					<td>{{ isset($item->jabatan) ? $item->jabatan->title : '-' }}</td>
					<td>{{ isset($item->lvl) ? $item->lvl->title : '-' }}</td>
					<td>{{ isset($item->atasan) ? $item->atasan->name : '-' }}</td>
					<td>{{ isset($item->divisi) ? $item->divisi->title : '-'  }}</td>
					<td>{{ $item->email }}</td>
					<td>{{ $item->no_hp }}</td>
					<td class="text-center">
						<a href="javascript:void(0);" class="edit" data-id="{{ $item->id }}">
							<span class="badge badge-info">Edit</span>
						</a>
					</td>
				</tr>
				@endforeach
			@endif
			</tbody>
	</table>
</div>
