<div class="col-xl-4">
	<div class="card">
		<div class="card-body">
			<h4 class="card-title mb-3">Hari Kerja Periode {{ date('F Y') }}</h4>
			<div class="media">
				<div class="media-body overflow-hidden">
					<p class="text-truncate font-size-14 mb-2"></p>
					<h4 class="font-size-56">{{ $payroll_config->hari_kerja }}</h4>
				</div>
				<div class="text-primary">
					<i class="ri-calendar-event-line font-size-56"></i>
				</div>
			</div>
		</div>
	</div>
</div>