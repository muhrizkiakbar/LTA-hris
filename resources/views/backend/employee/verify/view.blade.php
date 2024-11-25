<div class="card">
	<div class="card-body">
		<p class="text-center" style="font-size:24px; padding-left: 20px">
			Verifikasi Data - Calon Karyawan
		</p>
		<table class="table table-sm table-striped table-bordered">
			<thead>
				<tr>
					<th class="text-center">NIK</th>
					<th class="text-center">Nama</th>
					<th class="text-center">Join Date</th>
					<th class="text-center">Department</th>
					<th class="text-center">Posisi</th>
					<th class="text-center">Lokasi</th>
					<th class="text-center">Status</th>
					<th class="text-center">Resign Date</th>
					<th class="text-center">Keterangan</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($row as $item)
				<tr>
					<td>{{ $item['nik'] }}</td>
					<td>{{ $item['name'] }}</td>
					<td class="text-center">{{ $item['join_date'] }}</td>
					<td class="text-center">{{ $item['department'] }}</td>
					<td class="text-center">{{ $item['posisi'] }}</td>
					<td class="text-center">{{ $item['lokasi'] }}</td>
					<td class="text-center">{!! $item['status'] !!}</td>
					<td class="text-center">{{ $item['resign_date'] }}</td>
					<td>{{ $item['keterangan'] }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
