<tr>
	<td class="text-center">1</td>
	<td>Tanggal Ijin</td>
	<td>{{ tgl_def($row->date) }} </td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Jam</td>
	<td>{{ $row->time_start }} s/d {{ $row->time_end }}</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Tipe Ijin</td>
	<td>{{ $row->tipe_surat->title }}</td>
</tr> 
<tr>
	<td class="text-center">4</td>
	<td>Keperluan</td>
	<td>{{ $row->keperluan }}</td>
</tr>