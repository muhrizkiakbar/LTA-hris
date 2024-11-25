{!! Form::open(['route'=>['backend.payroll.detail_update'],'method'=>'POST','files' => true]) !!}
<div class="card">
	<div class="table-basic mb-4">
    <table cellspacing="0" id="table-basic" class="tablex table-sm table-bordered table-striped table-hover" style="min-width: 1200px;">
			<thead>
				<tr>
					<th class="text-center">NIK</th>
					<th class="text-center">Nama Karyawan</th>
					<th class="text-center">Lokasi</th>
					<th class="text-center">Department</th>
					<th class="text-center">Jabatan</th>
					<th class="text-center">Posisi</th>
					<th class="text-center">Gaji Pokok</th>
					<th class="text-center">Tunjangan Jabatan</th>
					<th class="text-center">Uang Makan</th>
					<th class="text-center">Uang Transport</th>
					<th class="text-center">Tunjangan Sewa Rumah</th>
					<th class="text-center">Tunjangan Pulsa</th>
					<th class="text-center">Tunjangan Lainnya</th>
					<th class="text-center">Incentive REG</th>
					<th class="text-center">Incentive GM</th>
					<th class="text-center">Incentive Klaim Principal</th>
					<th class="text-center">Lembur</th>
					<th class="text-center">THR</th>
					<th class="text-center">Transfer Tgl 15</th>
					<th class="text-center table-info">Total Pendapatan</th>
					<th class="text-center table-danger">Potongan Absensi</th>
					<th class="text-center table-danger">Potongan JHT</th>
					<th class="text-center table-danger">Potongan JP</th>
					<th class="text-center table-danger">Potongan Kesehatan</th>
					<th class="text-center table-danger">Potongan PPH 21</th>
					<th class="text-center table-danger">Potongan Pinjaman</th>
					<th class="text-center table-danger">Potongan Batal Nota</th>
					<th class="text-center table-info">Total Potongan</th>
					<th class="text-center table-success">Total Transfer</th>
					<th class="text-center table-default">Claim Principal</th>
				</tr>
			</thead>
			<tbody>
				<?php $index=0; ?>
				@foreach ($row as $item)
				<tr>
					<td>{{ $item->nik }}</td>
					<td>{{ $item->user_detail->name }}</td>
					<td>{{ $item->lokasi }}</td>
					<td>{{ $item->department->title }}</td>
					<td>{{ $item->jabatan->title }}</td>
					<td>{{ $item->user_detail->jabatan->title }}</td>
					<td class="text-right">{{ rupiahnon2($item->gaji_pokok) }}</td>
					<td class="text-right">{{ rupiahnon2($item->tunjangan_jabatan) }}</td>
					<td>
						<input type="text" name="tunjangan_makan[]" class="form-control form-control-sm-custom" value="{{ $item->tunjangan_makan }}">
					</td>
					<td>
						<input type="text" name="tunjangan_transport[]" class="form-control form-control-sm-custom" value="{{ $item->tunjangan_transport }}">
					</td>
					<td>
						<input type="text" name="tunjangan_sewa[]" class="form-control form-control-sm-custom" value="{{ $item->tunjangan_sewa }}">
					</td>
					<td class="text-right">{{ rupiahnon2($item->tunjangan_pulsa) }}</td>
					<td class="text-right">{{ rupiahnon2($item->tunjangan_lain) }}</td>
					<td class="text-right">{{ rupiahnon2($item->incentive_reg) }}</td>
					<td class="text-right">{{ rupiahnon2($item->incentive_gm) }}</td>
					<td class="text-right">{{ rupiahnon2($item->principal) }}</td>
					<td>
						<input type="text" name="lembur[]" class="form-control form-control-sm-custom" value="{{ isset($item->lembur) ? $item->lembur : 0 }}">
					</td>
					<td class="text-right">{{ isset($item->thr) ? rupiahnon2($item->thr) : 0 }}</td>
					<td class="text-right">{{ rupiahnon2($item->trf15) }}</td>
					<td class="table-info">{{ rupiahnon($item->full_pendapatan) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_absensi) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_jht) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_jp) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_kes) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_pph21) }}</td>
					<td class="table-danger text-right">{{ rupiahnon2($item->potongan_pinjaman) }}</td>
					<td class="table-danger text-right">{{ isset($item->potongan_batal_nota) ? rupiahnon2($item->potongan_batal_nota) : 0 }}</td>
					<td class="table-info">{{ rupiahnon($item->full_potongan) }}</td>
					<td class="table-success">{{ rupiahnon($item->total_trf) }}</td>
					<td class="text-center">{{ isset($item->user_detail) ? isset($item->user_detail->claim_principal) ? $item->user_detail->claim_principal->title : '-' : '-' }}</td>
					<input type="hidden" name="id[]" value="{{ $item->id }}">
					<input type="hidden" name="idx[{{ $index }}]" value="{{ $index }}">
				</tr>
				<?php $index++ ?>
				@endforeach
			</tbody>
		</table>
	</div>
	<button type="submit" class="btn btn-success btn-sm">Update Payroll</button>
</div>
{!! Form::close() !!}
<script type="text/javascript">
	$(document).ready(function(){
		$(".table-basic").freezeTable({
			'columnNum' : 3,
		});
	});
</script><script type="text/javascript">