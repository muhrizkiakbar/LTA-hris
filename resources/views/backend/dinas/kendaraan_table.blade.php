<table class="table table-striped table-bordered table-sm">
	<thead>
		<tr>
			<th class="text-center">Kendaraan</th>
			<th class="text-center">Rute</th>
			<th class="text-center">Jarak Tempuh</th>
			<th class="text-center">Pemakaian BBM</th>
			<th class="text-center">Harga BBM</th>
			<th class="text-center">Biaya Tol</th>
			<th class="text-center">Total Harga</th>
			<th class="text-center" width="110px">#</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($row as $item)
		<tr>
			<td>{{ $item->kendaraan->title }}</td>
			<td>{{ $item->lokasi_asal->title.'-'.$item->lokasi_tujuan->title }}</td>
			<td class="text-center">{{ round($item->jarak,2) }} Km <br>{{ isset($item->twoway) ? $item->twoway==1 ? '(Pulang - Pergi)' : '(Sekali Jalan)' : '' }}</td>
			<td class="text-right">{{ round($item->pemakaian_bbm,2) }} L</td>
			<td class="text-right">@currency($item->kendaraan->harga_bbm)</td>
			<td class="text-right">@currency($item->dinas_biaya_tol_harga) <br>{{ $item->dinas_bayar_tol_id!=0 ? isset($item->twoway_tol) ? $item->twoway_tol==1 ? '(Pulang - Pergi)' : '(Sekali Jalan)' : '' : '' }}</td>
			<td class="text-right">@currency($item->total_harga)</td>
			<td class="text-center">
				<a href="{{ route('backend.dinas.kendaraan_delete',$item->id) }}" onclick="return confirm('Anda yakin ingin menghapus ?')">
					<span class="badge badge-danger">Delete</span>
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
