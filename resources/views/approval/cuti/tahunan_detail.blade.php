<tr>
	<td class="text-center">1</td>
	<td>Tanggal Cuti</td>
	<td>{{ $lines }}</td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Keperluan Cuti</td>
	<td>{{ $row->desc }}</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Saldo Cuti</td>
	<td>{{ $row->cuti_qty }} Hari</td>
</tr>
<tr>
	<td class="text-center">4</td>
	<td>Cuti Yang Diambil</td>
	<td>{{ $lines_count }} Hari</td>
</tr>
<tr>
	<td class="text-center">5</td>
	<td>Sisa Saldo Cuti</td>
	<td>{{ $row->cuti_qty - $lines_count }} Hari</td>
</tr>
<tr>
	<td class="text-center">6</td>
	<td>Pengganti Sementara</td>
	<td>{{ isset($row->employee_exchange) ? $row->employee_exchange->name : '-' }}</td>
</tr>