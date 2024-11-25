<div class="modal-dialog">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">Detail Cuti Karyawan</h6>
		</div>
    <div class="modal-body">
			<table class="table table-borderless table-striped table-hovered">
				<tr style="font-weight: 800;">
					<td>Sisa Cuti Kemaren </td>
					<td>:</td>
					<td>{{ $sisa_cuti_kemaren }} Hari Kerja</td>
				</tr>
				<tr>
					<td>Periode Cuti</td>
					<td>:</td>
					<td>{{ $periode_start }} s/d {{ $periode_end }}</td>
				</tr>
				<tr style="font-weight: 800;">
					<td>Hak Cuti Tahunan</td>
					<td>:</td>
					<td>{{ $hak_cuti }} Hari Kerja</td>
				</tr>
				<tr>
					<td>Cuti Bersama</td>
					<td>:</td>
					<td>
						@foreach ($cuti_bersama as $item_cb)
							{{ $item_cb->date }}<br>
						@endforeach
					</td>
				</tr>
				<tr>
					<td>Cuti Pribadi</td>
					<td>:</td>
					<td>
						@foreach ($cuti_pribadi as $item_ct)
							{{ $item_ct->date }}<br>
						@endforeach
					</td>
				</tr>
				<tr>
					<td>Ijin (Memotong Cuti)</td>
					<td>:</td>
					<td>
						@foreach ($ijin as $item_ijin)
							{{ $item_ijin->date }}<br>
						@endforeach
					</td>
				</tr>
				<tr style="font-weight: 800;">
					<td>Sisa Cuti</td>
					<td>:</td>
					<td>{{ $sisa_cuti }} Hari Kerja</td>
				</tr>
			</table>
			<button type="button" class="btn btn-danger btn-sm mt-2" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>