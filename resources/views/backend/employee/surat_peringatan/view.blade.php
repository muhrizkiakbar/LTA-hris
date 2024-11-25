<html>
<head>
	<!-- Fonts  -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="{{ asset('backend/css/print/bootstrap.css') }}" />
	<!-- Base Styling  -->
	<link rel="stylesheet" href="{{ asset('backend/css/print/core.css') }}" />
	<style>
	  *{	
	  	font-family: sans-serif;
			color: #000;
	  }

	  table{
	    font-size: 11px;
      text-align: justify;
	  }


	  .spacingtd {
	    padding: 0px 0px 0px 10px !important;
	    margin: 0 !important;
	  }

	  .spacing tr td {
	    padding: 0 10px 0 0 !important;
	    margin: 0 !important;
	  }

		.page {
			width: 21cm;
			min-height: 29.7cm;
			padding: 0.75cm;
			margin: 0.75cm auto;
			background: white;
		}

		@page {
        size: F4;
        margin: 0.5cm;
		}

		@media print {
			.page {
				margin: 0;
				border: initial;
				border-radius: initial;
				width: initial;
				min-height: initial;
				box-shadow: initial;
				background: initial;
				page-break-after: always;
			}
		}

		@media print and (color) {
		  * {
		      -webkit-print-color-adjust: exact;
		      print-color-adjust: exact;
		  }
		}
 	</style>
</head>
<body onload="window.print();" style="background: #fff;">
	<div class="page">
		<div class="row">
			<div class="col-md-12">
        <div style="margin-top: 0px; margin-bottom: -15px;">
					<center>
						<p style="font-size: 11px; font-weight: bold; margin-bottom: 2px; text-decoration: underline;">
							SURAT PERINGATAN 
						</p>
            <p style="font-size: 11px; margin-top: -3px">Nomor : {{ $nomor }}</p>
					</center>
          <table border="0" width="100%">
            <col style="width:15%">
            <col style="width:2%">
            <col style="width:2%">
            <tr>
              <td valign="top">Menimbang</td>
              <td valign="top">:</td>
              <td valign="top">1.</td>
              <td>
                Bahwa pemberian sanksi atas pelanggaran disiplin dimaksudkan sebagai teguran keras agar yang bersangkutan bersikap dan berperilaku sesuai dengan peraturan.
              </td>
            </tr>
            <tr>
              <td valign="top"></td>
              <td valign="top"></td>
              <td valign="top">2.</td>
              <td>
                Bahwa pemberian Surat Peringatan kepada pekerja merupakan pembinaan sebelum melakukan Pemutusan Hubungan Kerja.
                <br><br>
              </td>
            </tr>
            <tr>
              <td valign="top">Mengingat</td>
              <td valign="top">:</td>
              <td valign="top">1.</td>
              <td>
                Undang-undang ketenagakerjaan Nomor 13 Tahun 2003.
              </td>
            </tr>
            <tr>
              <td valign="top"></td>
              <td valign="top"></td>
              <td valign="top">2.</td>
              <td>
                Peraturan Perusahaan PT. Laut Timur Ardiprima
                <br><br>
              </td>
            </tr>
            <tr>
              <td valign="top">Mendengar</td>
              <td valign="top">:</td>
              <td valign="top">1.</td>
              <td>
                Bahwa pemberian sanksi atas pelanggaran disiplin dimaksudkan sebagai teguran keras agar yang bersangkutan bersikap dan berperilaku sesuai dengan peraturan.
              </td>
            </tr>
            <tr>
              <td valign="top"></td>
              <td valign="top"></td>
              <td valign="top">2.</td>
              <td>
                Bahwa pemberian Surat Peringatan kepada pekerja merupakan pembinaan sebelum melakukan Pemutusan Hubungan Kerja.
                <br><br>
              </td>
            </tr>
          </table>
          <center>
            <p style="font-size: 11px; margin-top: -3px">MEMUTUSKAN <br> Tingkat Disiplin Berupa : <br> <strong style="text-transform: uppercase">{{ $sp }}</strong></p>
					</center>
          <table border="0" width="100%">
            <col style="width:18%">
            <col style="width:2%">
            <tr>
              <td colspan="3" valign="top">Kepada</td>
            </tr>
            <tr>
              <td valign="top">Nama</td>
              <td valign="top">:</td>
              <td>{{ $user->name }}</td>
            </tr>
            <tr>
              <td valign="top">NIK</td>
              <td valign="top">:</td>
              <td>{{ $user->nik }}</td>
            </tr>
            <tr>
              <td valign="top">Jabatan</td>
              <td valign="top">:</td>
              <td>{{ isset($user->department_jabatan_id) ? $user->jabatan->title : '-' }}</td>
            </tr>
            <tr>
              <td valign="top">Department / Divisi</td>
              <td valign="top">:</td>
              <td>{{ isset($user->department_id) ? $user->department->title : '-' }} / {{ isset($user->divisi_id) ? $user->divisi->title : '-' }}</td>
            </tr>
            <tr>
              <td valign="top">Cabang</td>
              <td valign="top">:</td>
              <td>{{ isset($user->lokasi_id) ? $user->lokasi   : '-' }}</td>
            </tr>
            <tr>
              <td colspan="3" valign="top">Karena pelanggaran sebagai berikut : </td>
            </tr>
            <tr>
              <td colspan="3" valign="top">
                <strong>"<i>{{ $pelanggaran }}</i>" <br><br></strong>
              </td>
            </tr>
            <tr>
              <td colspan="3" style="text-align: right">
                Dikeluarkan di {{ isset($user->lokasi_id) ? $user->lokasi   : 'Balikpapan' }} : {{ tgl_indo($date) }}
              </td>
            </tr>
          </table>
          <table border="0" width="100%">
            <col style="width:40%">
            <col style="width:33%">
            <tr>
              <td style="padding-right: 80px" valign="top">
                Mengetahui, mengerti, dan menerima dasar peringatan di atas,
                <br><br><br><br><br><br><br>
                <strong><u>{{ $user->name }}</u></strong><br>
                Karyawan
              </td>
              <td valign="top">
                Diberikan oleh,
                <br><br><br><br><br><br><br><br>
                <strong><u>{{ isset($user->atasan) ? $user->atasan->name : '-' }}</u></strong><br>
                {{ isset($user->atasan) ? isset($user->atasan->jabatan) ? $user->atasan->jabatan->title : '-' : '-' }}
              </td>
              <td valign="top">
                Diketahui oleh,
                <br><br><br><br><br><br><br><br>
                <strong><u>{{ $manager->name }}</u></strong> <br>
                @if ($manager=='1785' || $manager=='1787' || $manager=='1788')
                {{ get_director_name($manager) }} 
                @else
                {{ isset($manager->department_jabatan_id) ? isset($manager->jabatan) ? $manager->jabatan->title : '-' :'-' }}    
                @endif
              </td>
            </tr>
          </table>
          <table border="0" width="100%" style="margin-top: 20px">
            <tr>
              <td><strong>Tembusan :</strong></td>
            </tr>
            <tr>
              <td>1. Branch Manager PT. Laut Timur Ardiprima</td>
            </tr>
            <tr>
              <td>2. Operational Manager PT. Laut Timur Ardiprima</td>
            </tr>
            <tr>
              <td>3. File</td>
            </tr>
          </table>
          <hr>
          <p style="font-size: 11px; margin-top: -3px; text-align:center">
            <strong style="text-transform: uppercase">Sangat Penting Untuk Diperhatikan :</strong>
          </p>
          <table border="0" width="100%">
            <col style="width:2%">
            <tr>
              <td valign="top">1.</td>
              <td>Surat Peringatan ini diberikan dengan maksud agar saudara memperbaiki sikap kerja, tidak mengulangi kesalahan ataupun melakukan pelanggaran yang lain.</td>
            </tr>
            <tr>
              <td valign="top">2.</td>
              <td>Apabila dalam jangka waktu 6 (enam) bulan sejak dikeluarkannya Surat Peringatan ini saudara kembali membuat pelanggaran, maka akan diberlakukan sanksi administrasi sesuai dengan Peraturan Perusahaan PT. Laut Timur Ardiprima.</td>
            </tr>
            <tr>
              <td valign="top">3.</td>
              <td>Peraturan diadakan bukan untuk mengekang ataupun mempersulit tetapi untuk menciptakan situasi yang tertib, aman, dan nyaman di lingkungan perusahaan, baik terhadap saudara sendiri maupun rekan-rekan sekerja lainnya yang pada akhirnya akan membantu saudara mencapai prestasi kerja yang memuaskan.</td>
            </tr>
          </table>
				</div>
      </div>
    </div>
  </div>
</body>
</html>