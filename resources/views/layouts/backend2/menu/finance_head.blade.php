<li <?php if($section=="karyawan"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="karyawan"){echo 'mm-active';}?>">
		<i class=" ri-user-2-line"></i>
		<span>Karyawan</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.employee') }}" {{ isset($sub_section) ? $sub_section=='data_karyawan' ? 'class="mm-active"' : '' : '' }}>
				Data Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.resign') }}" {{ isset($sub_section) ? $sub_section=='karyawan_resign' ? 'class="mm-active"' : '' : '' }}>
				Data Karyawan Resign
			</a>
		</li>
	</ul>
</li>
<li <?php if($section=="payroll"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="payroll"){echo 'mm-active';}?>">
		<i class="ri-bit-coin-fill"></i>
		<span>Payroll</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.payroll') }}" {{ isset($sub_section) ? $sub_section=='payroll_generate' ? 'class="mm-active"' : '' : '' }}>
				Generate Payroll
			</a>
		</li>
		<li>
			<a href="{{ route('backend.payroll.incentive') }}" {{ isset($sub_section) ? $sub_section=='payroll_incentive' ? 'class="mm-active"' : '' : '' }}>
				Incentive & PPH21
			</a>
		</li>
		<li>
			<a href="{{ route('backend.payroll.komponen_gaji') }}" {{ isset($sub_section) ? $sub_section=='payroll_komponen' ? 'class="mm-active"' : '' : '' }}>
				Komponen Gaji
			</a>
		</li>
	</ul>
</li>
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