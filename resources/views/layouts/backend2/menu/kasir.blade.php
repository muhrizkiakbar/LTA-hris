<li <?php if($section=="dinas"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="dinas"){echo 'mm-active';}?>">
		<i class="ri-folder-line"></i>
		<span>Perjalanan Dinas</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.dinas') }}" {{ isset($sub_section) ? $sub_section=='dinas_data' ? 'class="mm-active"' : '' : '' }}>
				Lihat Data
			</a>
		</li>
	</ul>
</li>