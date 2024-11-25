<div class="card">
  <div class="text-center mb-2 mt-2">
    <h4 style="font-weight: 400;">Report Absensi Karyawan</h4>
  </div>
	<p style="font-weight: 400;">
    Department : {{ $department }} <br> 
    Lokasi : {{ $lokasi }} <br> 
		Rasio Kehadiran : {{ $ratio }} %<br> 
  </p>
	<div class="table-responsive">
    <table class="tablex table-bordered table-hover table-sm">
      <thead>
        <tr>
          <th rowspan="2" class="text-center">NIK</th>
          <th rowspan="2" class="text-center">Nama Karyawan</th>
          <th rowspan="2" class="text-center">Jabatan</th>
					<?php for ($i=1; $i <= $hari ; $i++) { ?>
					<th class="text-center" rowspan="2"><?php echo $i;?></th>
					<?php } ?>
					<th colspan="13" class="text-center">Keterangan</th>
          <th rowspan="2" class="text-center">TOTAL HARI</th>
          <th rowspan="2" class="text-center">MDP</th>
          <th rowspan="2" class="text-center">MDA</th>
          <th rowspan="2" class="text-center">MDL</th>
				</tr>
				<tr>
          <th class="text-center">H</th>
          <th class="text-center">T</th>
          <th class="text-center">S</th>
          <th class="text-center">I</th>
          <th class="text-center">A</th>
          <th class="text-center">ISO</th>
          <th class="text-center">WFH</th>
          <th class="text-center">DL</th>
          <th class="text-center">OFF</th>
          <th class="text-center">CT</th>
          <th class="text-center">CB</th>
          <th class="text-center">CK</th>
          <th class="text-center">PD</th>
        </tr>
			</thead>
			<tbody>
        @foreach ($absen as $month => $item)
        <tr>
          <td><?php echo $item['nik'] ?></td>
          <td><?php echo $item['name'] ?></td>
					<td><?php echo $item['jabatan'] ?></td>
					@foreach ($item['daily'] as $key => $absen)
          <td class="text-center {{ $absen['color'] }}">{{ $absen['label']!='NULL' ? $absen['label'] : ''  }}</td>   
          @endforeach
					<td class="text-center">{{ $item['hadir'] }}</td>
          <td class="text-center">{{ $item['telat'] }}</td>
          <td class="text-center">{{ $item['sakit'] }}</td>
          <td class="text-center">{{ $item['ijin'] }}</td>
          <td class="text-center">{{ $item['alpa'] }}</td>
          <td class="text-center">{{ $item['iso'] }}</td>
          <td class="text-center">{{ $item['wfh'] }}</td>
          <td class="text-center">{{ $item['dl'] }}</td>
          <td class="text-center">{{ $item['off'] }}</td>
          <td class="text-center">{{ $item['ct'] }}</td>
          <td class="text-center">{{ $item['cb'] }}</td>
          <td class="text-center">{{ $item['ck'] }}</td>
          <td class="text-center">{{ $item['pd'] }}</td>
          <td class="text-center">{{ $item['jumhari'] }}</td>
          <td class="text-center">{{ $item['mdp'] }}</td>
          <td class="text-center">{{ $item['mda'] }}</td>
          <td class="text-center">{{ $item['mdl'] }}</td>
				</tr>
				@endforeach
				<tr>
          <td colspan="{{ $hari + 3 }}" class="text-center"><strong>TOTAL</strong></td>
					<td class="text-center"><strong>{{ $sum_hadir }}</strong></td>
          <td class="text-center"><strong>{{ $sum_telat }}</strong></td>
          <td class="text-center"><strong>{{ $sum_sakit }}</strong></td>
          <td class="text-center"><strong>{{ $sum_ijin }}</strong></td>
          <td class="text-center"><strong>{{ $sum_alpa }}</strong></td>
          <td class="text-center"><strong>{{ $sum_iso }}</strong></td>
          <td class="text-center"><strong>{{ $sum_wfh }}</strong></td>
          <td class="text-center"><strong>{{ $sum_dl }}</strong></td>
          <td class="text-center"><strong>{{ $sum_off }}</strong></td>
          <td class="text-center"><strong>{{ $sum_ct }}</strong></td>
          <td class="text-center"><strong>{{ $sum_cb }}</strong></td>
          <td class="text-center"><strong>{{ $sum_ck }}</strong></td>
          <td class="text-center"><strong>{{ $sum_pd }}</strong></td>
          <td class="text-center"><strong>{{ $sum_hari }}</strong></td>
          <td class="text-center"><strong>{{ $sum_mdp }}</strong></td>
          <td class="text-center"><strong>{{ $sum_mda }}</strong></td>
          <td class="text-center"><strong>{{ $sum_mdl }}</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>