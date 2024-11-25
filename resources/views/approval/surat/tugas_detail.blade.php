<tr>
	<td class="text-center">1</td>
	<td>Tanggal Tugas</td>
	<td>{{ tgl_def($row->date_start) }} s/d {{ tgl_def($row->date_end) }}</td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Tujuan</td>
	<td>{{ $row->desc }}</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Keperluan</td>
	<td>{{ $row->catatan }}</td>
</tr>