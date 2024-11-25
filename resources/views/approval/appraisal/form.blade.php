<div class="order-detail">
	<table class="table table-bordered table-sm">
		<col style="width:33%">
    <col style="width:33%">
		<tr>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:40%">
					<col style="width:1%">
					<tr>
						<td>Nama</td>
						<td class="text-center">:</td>
						<td>{{ $header->employee->name }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Jabatan</td>
						<td class="text-center">:</td>
						<td>{{ $header->jabatan->title }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Cabang</td>
						<td class="text-center">:</td>
						<td>{{ $header->lokasi->title }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:40%">
					<col style="width:1%">
					<tr>
						<td>NIK</td>
						<td class="text-center">:</td>
						<td>{{ $header->employee->nik }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Department / Divisi</td>
						<td class="text-center">:</td>
						<td>{{ isset($header->department) ? $header->department->title : '-' }} / {{ isset($header->divisi) ? $header->divisi->title : '-' }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Atasan Langsung</td>
						<td class="text-center">:</td>
						<td>{{ $header->atasan->name }}</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:40%">
					<col style="width:1%">
					<tr>
						<td>Periode Penilaian</td>
						<td class="text-center">:</td>
						<td>{{ date('F Y',strtotime($header->date_start)) }} - {{ date('F Y',strtotime($header->date_end)) }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Tanggal Masuk</td>
						<td class="text-center">:</td>
						<td>{{ tgl_indo($header->employee->join_date) }}</td>
					</tr>
				</table>
			</td>
			<td>
				<table class="table-borderless" width="100%">
					<col style="width:45%">
					<col style="width:1%">
					<tr>
						<td>Status PA</td>
						<td class="text-center">:</td>
						<td>{{ isset($header->kontrak) ? $header->kontrak->employee_sts->title : '-' }}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{!! Form::open(['route'=>$url_store,'method'=>'POST','files' => true]) !!}
	<table class="table table-bordered table-sm"  id="example">
		<col style="width:12%">
		<col style="width:3%">
		<col style="width:55%">
		<col style="width:10%">
		<col style="width:10%">
		<col style="width:10%">
		<thead>
			<tr>
				<td rowspan="2" class="text-center"><strong>Tolak Ukur</strong></td>
				<td colspan="2" rowspan="2" class="text-center"><strong>Elemen Penilaian</strong></td>
				<td colspan="3" class="text-center"><strong>Point / Nilai</strong></td>
			</tr>
			<tr>
				<td class="text-center"><strong>1</strong></td>
				<td class="text-center"><strong>2</strong></td>
				<td class="text-center"><strong>3</strong></td>
			</tr>
		</thead>
		<tbody>
			<?php $no=1; $nox=0;?>
			@foreach ($lines as $item)
			<tr>
				<input type="hidden" name="id[<?php echo $nox;?>]" value="<?php echo $nox;?>">
				<input type="hidden" name="idx[]" value="<?php echo $item->id;?>">
				<td class="text-center"><strong>{{ $item->appraisal_key->title }}</strong></td>
				<td class="text-center">{{ $no++ }}</td>
				<td style="padding-left: 10px; padding-right:10px; text-align: justify;">
					<strong>{{ $item->appraisal_item->title }}</strong> <br>
					{!! nl2br($item->appraisal_item->desc) !!}
				</td>
				<td>
					<center>
						<?php 
							if($item->score==1)
							{
								echo '<i class="fa fa-check"></i>';
							}
							else if($item->score==0) {
						?>
						<input type="checkbox" name="check[<?php echo $nox?>]" class="checkx<?php echo $nox?>" value="1" onclick="onlyOne(this, <?php echo $nox?>)">
						<?php } ?>
					</center>
				</td>
				<td>
					<center>
						<?php 
							if($item->score==2)
							{
								echo '<i class="fa fa-check"></i>';
							}
							else if($item->score==0) {
						?>
						<input type="checkbox" name="check[<?php echo $nox?>]" class="checkx<?php echo $nox?>" value="2" onclick="onlyOne(this, <?php echo $nox?>)">
						<?php } ?>
					</center>
				</td>
				<td>
					<center>
						<?php 
							if($item->score==3)
							{
								echo '<i class="fa fa-check"></i>';
							}
							else if($item->score==0) {
						?>
						<input type="checkbox" name="check[<?php echo $nox?>]" class="checkx<?php echo $nox?>" value="3" onclick="onlyOne(this, <?php echo $nox?>)">
						<?php } ?>
					</center>
				</td>
			</tr>
			<?php $nox++; ?>
			@endforeach
			<tr>
				<td colspan="2" class="text-center text-uppercase"><strong>Kriteria Nilai</strong></td>
				<td class="text-center text-uppercase"><strong>Total Nilai</strong></td>
				<td class="text-center"><strong>{{ $score1 }}</strong></td>
				<td class="text-center"><strong>{{ $score2 }}</strong></td>
				<td class="text-center"><strong>{{ $score3 }}</strong></td>
			</tr>
			<tr>
				<td class="text-uppercase"><strong>- Buruk</strong></td>
				<td class="text-center">:</td>
				<td>Total Nilai <strong>< 22</strong></td>
				<td colspan="3" rowspan="3" class="text-center">
					<strong>Total Nilai = {{ $sum }},</strong> <i>({{ $kriteria }})</i> 
				</td>
			</tr>
			<tr>
				<td class="text-uppercase"><strong>- Cukup</strong></td>
				<td class="text-center">:</td>
				<td>Total Nilai antara <strong>22 - 28</strong> (Tolak Ukur : Performance, Disiplin & Attitude <strong>TIDAK ADA</strong> Nilai 1)</td>
			</tr>
			<tr>
				<td class="text-uppercase"><strong>- Sangat Baik</strong></td>
				<td class="text-center">:</td>
				<td>Total Nilai <strong>> 28</strong> (<strong>TIDAK ADA</strong> Elemen Penilaian dengan Nilai 1)</td>
			</tr>
			@if ($status=='appraisal_atasan' && $atasan_st==0)
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review Penilai (Keunggulan dan hal-hal yang harus diperbaiki) :</strong>
					@if (empty($header->review_atasan))
					{!! Form::textarea('review_atasan',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}   
					@else
					<br>{!! nl2br($header->review_atasan) !!}
					@endif
				</td>
			</tr>
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review & Rekomendasi Manager :</strong>
				</td>
			</tr>
			@elseif ($status=='appraisal_manager' && $manager_st==0)
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review Penilai (Keunggulan dan hal-hal yang harus diperbaiki) :</strong>
					<br>{!! nl2br($header->review_atasan) !!}
				</td>
			</tr>
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review & Rekomendasi Manager :</strong>
					@if (empty($header->review_manager))
					{!! Form::textarea('review_manager',null,['class'=>'form-control','rows'=>3,'required'=>true]) !!}   
					@else
					<br>{!! nl2br($header->review_manager) !!}
					@endif
				</td>
			</tr>
			@else
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review Penilai (Keunggulan dan hal-hal yang harus diperbaiki) :</strong>
					<br>{!! nl2br($header->review_atasan) !!}
				</td>
			</tr>
			<tr>
				<td height="100px" colspan="6" style="vertical-align: top">
					<strong>Review & Rekomendasi Manager :</strong>				
					<br>{!! nl2br($header->review_manager) !!}
				</td>
			</tr>
			@endif
		</tbody>
	</table>
	<div class="mt-2">
		<input type="hidden" name="appraisal_score_id" value="{{ $header->id }}">
		<input type="hidden" name="code" value="{{ $code }}">
		<button type="submit" class="btn btn-success">Review Penilaian</button>
	</div>
	{!! Form::close() !!}
</div>	