<div class="modal-dialog modal-xl">
  <div class="modal-content">
		<div class="modal-header">
			<h6 class="modal-title" id="myLargeModalLabel">{{ $title }}</h6>
		</div>
		<div class="modal-body">
			<table class="table table-sm table-bordered table-striped table-hover">
				<thead>
					<tr>
						<th>Gaji Pokok</th>
						<th>Tunjangan Jabatan</th>
						<th>Tunjangan Makan</th>
						<th>Tunjangan Transport</th>
						<th>Tunjangan Sewa</th>
						<th>Tunjangan Pulsa</th>
						<th>Tunjangan Lainnya</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-right">{{ rupiahnon2($row->gaji_pokok) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_jabatan) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_makan) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_transport) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_sewa) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_pulsa) }}</td>
						<td class="text-right">{{ rupiahnon2($row->tunjangan_lain) }}</td>
					</tr>
				</tbody>
			</table>
			<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
		</div>
	</div>
</div>