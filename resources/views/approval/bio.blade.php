<tr>
	<td class="text-center" width="2%">NO</td>
	<td class="text-center" width="30%">URAIAN</td>
	<td class="text-center">KETERANGAN</td>
</tr>
<tr>
	<td class="text-center">1</td>
	<td>NIK Karyawan</td>
	<td>{{ $row->employee->nik }}</td>
</tr>
<tr>
	<td class="text-center">2</td>
	<td>Nama Karyawan</td>
	<td>{{ $row->employee->name }}</td>
</tr>
<tr>
	<td class="text-center">3</td>
	<td>Department</td>
	<td>{{ !empty($row->department_id) ? $row->department->title : '-' }}</td>
</tr>
<tr>
	<td class="text-center">4</td>
	<td>Jabatan</td>
	<td>{{ !empty($row->department_jabatan_id) ? $row->department_jabatan->title : '-' }}</td>
</tr>
<tr>
	<td class="text-center">5</td>
	<td>Divisi</td>
	<td>{{ !empty($row->divisi_id) ? $row->divisi->title : '-' }}</td>
</tr>
<tr>
	<td class="text-center">6</td>
	<td>No. Telp / Hp</td>
	<td>{{ $row->employee->no_hp }}</td>
</tr>
<tr>
	<td class="text-center">7</td>
	<td>Cabang</td>
	<td>{{ $row->employee->lokasi }}</td>
</tr>