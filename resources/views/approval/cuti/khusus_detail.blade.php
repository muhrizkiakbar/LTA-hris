<tr>
	<td class="text-center">1</td>
	<td>Tanggal Cuti</td>
	<td>{{ $lines }}</td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Keperluan Cuti</td>
	<td>{{ $row->khusus->title }}</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Keperluan Cuti</td>
	<td>{{ $row->desc }}</td>
</tr>
<tr>
	<td class="text-center">4</td>
	<td>Pengganti Sementara</td>
	<td>{{ isset($row->employee_exchange) ? $row->employee_exchange->name : '-' }}</td>
</tr>