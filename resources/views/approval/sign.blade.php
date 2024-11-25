<table class="table table-borderless table-sm" width="100%">
	<tr>
		<td class="text-center" width="25%">Pemohon,</td>
		<td class="text-center" width="25%">Diperiksa,</td>
		<td class="text-center" width="25%">Disetujui,</td>
		<td class="text-center" width="25%">Diketahui,</td>
	</tr>
	<tr>
		<td class="text-center" width="25%">
			<img src='{{ isset($row->employee_id) ? get_ttd($row->employee_id) : get_ttd($row->users_id) }}'>
		</td>
		<td class="text-center" width="25%">
			@if ($row->periksa_st==1) 
				<img src='{{ get_ttd($row->periksa_id) }}'>
			@endif
		</td>
		<td class="text-center" width="25%">
			@if ($row->approval1_st==1) 
				<img src='{{ get_ttd($row->approval1_id) }}'>
			@endif
		</td>
		<td class="text-center" width="25%">
			@if ($row->approval2_st==1) 
				<img src='{{ get_ttd($row->approval2_id) }}'>
			@endif
		</td>
	</tr>
	<tr>
		<td class="text-center" width="25%">
			<u>{{ $row->employee->name }}</u> <br> 
			{{ isset($row->jabatan_id) ? $row->department_jabatan->title : '-' }}
		</td>
		<td class="text-center" width="25%">                 
			<u>{{ $row->periksa_hrd->name }}</u> <br>
			{{ isset($row->periksa_hrd->department_jabatan_id) ? $row->periksa_hrd->jabatan->title : '-' }}
		</td>
		<td class="text-center" width="25%">
			<u>{{ $row->approval_first->name }}</u> <br>
			@if ($row->approval1_id=='1785' || $row->approval1_id=='1787' || $row->approval1_id=='1788')
			{{ get_director_name($row->approval1_id) }} 
			@else
			{{ isset($row->approval_first->department_jabatan_id) ? $row->approval_first->jabatan->title : '-' }}    
			@endif
		</td>
		<td class="text-center" width="25%">
			<u>{{ $row->approval_second->name }}</u> <br>
			@if ($row->approval2_id=='1785' || $row->approval2_id=='1787' || $row->approval2_id=='1788')
			{{ get_director_name($row->approval2_id) }} 
			@else
			{{ isset($row->approval_second->department_jabatan_id) ? $row->approval_second->jabatan->title : '-' }}    
			@endif
		</td>
	</tr>
</table>