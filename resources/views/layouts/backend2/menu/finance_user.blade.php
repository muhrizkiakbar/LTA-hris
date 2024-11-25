<li <?php if($section=="dinas"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="dinas"){echo 'mm-active';}?>">
		<i class="ri-folder-line"></i>
		<span>Perjalanan Dinas</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='dinas_report' ? 'class="mm-active"' : '' : '' }}>Report</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.report.dinas') }}">Perjalanan Dinas</a></li>
			</ul>
		</li>
	</ul>
</li>