@extends('layouts.backend2.app')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-flex align-items-center justify-content-between">
					<h4 class="mb-0"><?php echo $title;?></h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
							<li class="breadcrumb-item active">Starter page</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			@include($view)
		</div>
	</div>
</div>	
@endsection
@section('customjs')
<script type="text/javascript">
  $(document).ready(function(){
		$.get('/backend/graph/chart_kontrak', function(data) {
			var chartData = {
				labels: data.map(item => item.kontrak),
				series: data.map(item => item.total)
			};
			
			let dataSeries = chartData.series;

			let newData = dataSeries.map(function(element) {
				return parseInt(element, 10); // Menghapus semua tanda kutip dalam string
			});

			var options = {
				series: newData,
				chart: { height: 230, type: "donut" },
				labels: chartData.labels,
				plotOptions: { pie: { donut: { size: "75%" } } },
				dataLabels: { enabled: !1 },
				legend: { show: !1 },
				colors: ["#5664d2", "#1cbb8c", "#eeb902"],
			};

			// Inisialisasi grafik dengan ApexCharts
			var chart = new ApexCharts(document.querySelector("#chart-kontrak"), options);
        
			// Render grafik
			chart.render();
		});

		$.get('/backend/graph/chart_karyawan_gender', function(data) {
			var chartData = {
				labels: data.map(item => item.label),
				series: data.map(item => item.total)
			};
			
			let dataSeries = chartData.series;

			// console.log(chartData.series);

			let newData = dataSeries.map(function(element) {
				return parseInt(element, 10); // Menghapus semua tanda kutip dalam string
			});

			var options = {
				series: newData,
				chart: { height: 230, type: "pie" },
				labels: chartData.labels,
				plotOptions: { pie: { donut: { size: "75%" } } },
				dataLabels: { enabled: !1 },
				legend: { show: !1 },
				colors: ["#3B71CA", "#e91e63"],
			};

			// Inisialisasi grafik dengan ApexCharts
			var chart = new ApexCharts(document.querySelector("#chart-karyawan-gender"), options);
        
			// Render grafik
			chart.render();
		});

		$.get('/backend/graph/chart_range_ages', function(data) {
			var series = data.row;

			// console.log(chartData.series);

			var options = {
				chart: { 
					height: 310,
					type: "bar",
					toolbar: {
						show: false
					}, 
				},
				toolbar: {
					show: false
				},
				plotOptions: {
					bar: {
						horizontal: true
					}
				},
				series: [{
					name: 'Jumlah',
					data: series,
				}],
				colors: ["#e91e63"],
				dataLabels: { enabled: !1 },
			};

			// Inisialisasi grafik dengan ApexCharts
			var chart = new ApexCharts(document.querySelector("#chart-range-ages"), options);
        
			// Render grafik
			chart.render();
		});

		$.get('/backend/graph/chart_absensi', function(data) {
			var options = {
				chart: { 
					height: 300,
					type: "line",
					toolbar: {
						show: false
					},
				},
				stroke: {
					curve: 'smooth',
				},
				series: [{
					name: 'Izin',
          data: data.map(item => item.total_izin)
				}, {
					name: 'Alpa',
          data: data.map(item => item.total_alpa)
				}, {
					name: 'Sakit',
          data: data.map(item => item.total_sakit)
				}],
				xaxis: {
					categories: data.map(item => item.label)
				},
				colors: ["#E94F37", "#393E41", "#3F88C5"],
				dataLabels: { enabled: !1 },
				legend: { show: !1 }
			};

			// Inisialisasi grafik dengan ApexCharts
			var chart = new ApexCharts(document.querySelector("#chart-absensi"), options);
        
			// Render grafik
			chart.render();
		});
	});
</script>
@endsection
