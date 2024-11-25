<li <?php if($section=="cuti"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="cuti"){echo 'mm-active';}?>">
		<i class="ri-calendar-2-line"></i>
		<span>Cuti</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='cuti_pengajuan' ? 'class="mm-active"' : '' : '' }}>Pengajuan</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.cuti.tahunan') }}">Cuti Tahunan</a></li>
				<li><a href="{{ route('backend.cuti.khusus') }}">Cuti Khusus</a></li>
			</ul>
		</li>
	</ul>
</li>