<tr>
	<td class="text-center">1</td>
	<td>Tanggal Dinas</td>
	<td>{{ tgl_def($row->date_start) }} S/D {{ tgl_def($row->date_end) }} </td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Lama Dinas</td>
	<td>{{ $row->lama_dinas }} Hari</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Tipe Perjalanan Dinas</td>
	<td>{{ $row->dinas_tipe->title }}</td>
</tr>
<tr>
	<td class="text-center">4</td>
	<td>Keperluan / Catatan</td>
	<td>
		<b>Keperluan :</b><br>
		{!! isset($row->desc) ? $row->desc.'<br>' : '-' !!}
		<b>Catatan :</b><br>
		{!! isset($row->catatan) ? $row->catatan.'<br>' : '-' !!}
	</td>
</tr>
@if ($lines->count()==0)
<tr>
	<td class="text-center">6</td>
	<td>Kendaraan</td>
	<td>{{ $row->dinas_kendaraan->title }}</td>
</tr>
<tr>
	<td class="text-center">7</td>
	<td>Estimasi Jarak</td>
	<td>{{ $row->jarak }} Km</td>
</tr>
<tr>
	<td class="text-center">8</td>
	<td>Biaya Transportasi</td>
	<td>@currency($row->estimasi_harga)</td>
</tr>
<tr>
	<td class="text-center">9</td>
	<td>Uang Makan</td>
	<td>@currency($row->uang_makan)</td>
</tr>
<tr>
	<td class="text-center">10</td>
	<td>Uang Hotel</td>
	<td>@currency($row->uang_hotel)</td>
</tr>
<tr>
	<td class="text-center">11</td>
	<td>Estimasi Total Biaya</td>
	<td>@currency($row->total_harga)</td>
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
	<td>@currency($row->estimasi_harga)</td>
</tr>
<tr>
	<td colspan="2">
		<strong>Uang Makan</strong>
	</td>
	<td>@currency($row->uang_makan)</td>
</tr>
<tr>
	<td colspan="2">
		<strong>Uang Hotel</strong>
	</td>
	<td>@currency($row->uang_hotel)</td>
</tr>
<tr>
	<td colspan="2">
		<strong>Estimasi Total Biaya</strong>
	</td>
	<td><strong>@currency($row->total_harga)</strong></td>
</tr>
@if (isset($row->trf_date))
<tr>
	<td colspan="2">
		<strong>Transfer Langsung</strong>
	</td>
	<td><strong>{{ $row->trf_date }}</strong></td>
</tr>
@endif
@endif