<li <?php if($section=="karyawan"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="karyawan"){echo 'mm-active';}?>">
		<i class=" ri-user-2-line"></i>
		<span>Karyawan</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.employee.verifikasi_employee') }}" {{ isset($sub_section) ? $sub_section=='data_verifikasi_karyawan' ? 'class="mm-active"' : '' : '' }}>
				Verifikasi Calon Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee') }}" {{ isset($sub_section) ? $sub_section=='data_karyawan' ? 'class="mm-active"' : '' : '' }}>
				Data Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.kontrak_kerja') }}" {{ isset($sub_section) ? $sub_section=='kontrak_kerja' ? 'class="mm-active"' : '' : '' }}>
				Kontak Kerja Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.sloting') }}" {{ isset($sub_section) ? $sub_section=='sloting_karyawan' ? 'class="mm-active"' : '' : '' }}>
				Sloting Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.training') }}" {{ isset($sub_section) ? $sub_section=='training_belting' ? 'class="mm-active"' : '' : '' }}>
				Training & Belting
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.mutasi') }}" {{ isset($sub_section) ? $sub_section=='mutasi' ? 'class="mm-active"' : '' : '' }}>
				Mutasi Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.employee.resign') }}" {{ isset($sub_section) ? $sub_section=='karyawan_resign' ? 'class="mm-active"' : '' : '' }}>
				Data Karyawan Resign
			</a>
		</li>
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='karyawan_report' ? 'class="mm-active"' : '' : '' }}>Report</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.report.karyawan') }}">Data Karyawan</a></li>
				<li><a href="{{ route('backend.report.kelengkapan') }}">Kelengkapan Dokumen</a></li>
				<li><a href="javascript: void(0);">Nomor Rekening</a></li>
				<li><a href="javascript: void(0);">Pendidikan Karyawan</a></li>
			</ul>
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
<li <?php if($section=="cuti"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="cuti"){echo 'mm-active';}?>">
		<i class="ri-calendar-2-line"></i>
		<span>Cuti</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.cuti.libur') }}" {{ isset($sub_section) ? $sub_section=='cuti_libur' ? 'class="mm-active"' : '' : '' }}>
				Tanggal Libur
			</a>
		</li>
		<li>
			<a href="{{ route('backend.cuti.bersama') }}" {{ isset($sub_section) ? $sub_section=='cuti_bersama' ? 'class="mm-active"' : '' : '' }}>
				Cuti Bersama
			</a>
		</li>
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='cuti_pengajuan' ? 'class="mm-active"' : '' : '' }}>Pengajuan</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.cuti.tahunan') }}">Cuti Tahunan</a></li>
				<li><a href="{{ route('backend.cuti.khusus') }}">Cuti Khusus</a></li>
			</ul>
		</li>
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='cuti_report' ? 'class="mm-active"' : '' : '' }}>Report</a>
			<ul class="sub-menu" >
				<li><a href="javascript: void(0);">Cuti Tahunan</a></li>
				<li><a href="javascript: void(0);">Cuti Khusus</a></li>
			</ul>
		</li>
	</ul>
</li>
<li <?php if($section=="absensi"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="absensi"){echo 'mm-active';}?>">
		<i class="ri-calendar-2-line"></i>
		<span>Absensi</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.absensi') }}" {{ isset($sub_section) ? $sub_section=='absensi_karyawan' ? 'class="mm-active"' : '' : '' }}>
				Absensi Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.absensi.ijin') }}" {{ isset($sub_section) ? $sub_section=='absensi_ijin' ? 'class="mm-active"' : '' : '' }}>
				Absensi Ijin Karyawan
			</a>
		</li>
		<li>
			<a href="{{ route('backend.absensi.remarks') }}" {{ isset($sub_section) ? $sub_section=='absensi_remarks' ? 'class="mm-active"' : '' : '' }}>
				Absensi Remarks
			</a>
		</li>
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='absensi_report' ? 'class="mm-active"' : '' : '' }}>Report</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.report.absensi') }}">Absensi Karyawan</a></li>
				<li><a href="{{ route('backend.report.absensi.resign') }}">Absensi Karyawan Resign</a></li>
			</ul>
		</li>
	</ul>
</li>
<li <?php if($section=="surat"){echo 'class="mm-active"';}?>>
	<a href="javascript: void(0);" class="has-arrow waves-effect <?php if($section=="surat"){echo 'mm-active';}?>">
		<i class="ri-folder-line"></i>
		<span>Surat</span>
	</a>
	<ul class="sub-menu" aria-expanded="false">
		<li>
			<a href="{{ route('backend.surat.tugas') }}" {{ isset($sub_section) ? $sub_section=='surat_tugas' ? 'class="mm-active"' : '' : '' }}>
				Surat Tugas
			</a>
		</li>
		<li>
			<a href="{{ route('backend.surat.ijin') }}" {{ isset($sub_section) ? $sub_section=='surat_ijin' ? 'class="mm-active"' : '' : '' }}>
				Surat Ijin Meninggalkan
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
			<a href="{{ route('backend.dinas') }}" {{ isset($sub_section) ? $sub_section=='dinas_data' ? 'class="mm-active"' : '' : '' }}>
				Lihat Data
			</a>
		</li>
		<li>
			<a href="javascript: void(0);" class="has-arrow" {{ isset($sub_section) ? $sub_section=='dinas_report' ? 'class="mm-active"' : '' : '' }}>Report</a>
			<ul class="sub-menu" >
				<li><a href="{{ route('backend.report.dinas') }}">Perjalanan Dinas</a></li>
			</ul>
		</li>
	</ul>
</li>
<li class="menu-title">Web Configuration</li>
<li <?php if($section=="direktur"){echo 'class="mm-active"';}?>>
	<a href="#" class="waves-effect <?php if($section=="direktur"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Direktur</span>
	</a>
</li>
<li <?php if($section=="department"){echo 'class="mm-active"';}?>>
	<a href="#" class="waves-effect <?php if($section=="department"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Department</span>
	</a>
</li>
<li <?php if($section=="principle"){echo 'class="mm-active"';}?>>
	<a href="#" class="waves-effect <?php if($section=="principle"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Principle</span>
	</a>
</li>
<li <?php if($section=="master_lokasi"){echo 'class="mm-active"';}?>>
	<a href="{{ route('backend.master.lokasi') }}" class="waves-effect <?php if($section=="master_lokasi"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Lokasi</span>
	</a>
</li>
<li <?php if($section=="master_dinas_lokasi"){echo 'class="mm-active"';}?>>
	<a href="{{ route('backend.master.dinas_lokasi') }}" class="waves-effect <?php if($section=="master_dinas_lokasi"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Dinas Lokasi Jarak</span>
	</a>
</li>
<li <?php if($section=="master_dinas_lokasi"){echo 'class="mm-active"';}?>>
	<a href="{{ route('backend.master.dinas_except') }}" class="waves-effect <?php if($section=="master_dinas_except"){echo 'mm-active';}?>">
		<i class=" ri-folder-5-line"></i>
		<span>Dinas Biaya - Except</span>
	</a>
</li>