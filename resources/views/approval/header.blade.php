<div class="header">
	<div class="row justify-content-between">
		<div class="col-5">
			<div class="header-logo">
				<em>Approval HRIS</em>
			</div>
		</div>
		<div class="col-7">
			@if ($status != 'resign_interview')
			<div class="header-action">
				@if (empty($approval) || $approval!=2)
					@if ($row->approval2_st==0 && $status=='approval2')
					@if (isset($url_ketahui_trf))
					<a href="{{ route($url_ketahui_trf,$code) }}" class="btn2">
						<i class="ri-check-line align-middle mr-2"></i> Mengetahui & Transfer Langsung
					</a>		
					@endif
					<a href="{{ route($url_ketahui,$code) }}" class="btn2">
						<i class="ri-check-line align-middle mr-2"></i> Mengetahui
					</a>
					<a href="javascript:void(0);" class="btn reject">
						<i class="ri-close-line align-middle mr-2"></i> Reject
					</a>
					@elseif ($row->approval1_st==0 && $status=='approval1')
					<a href="{{ route($url_setuju,$code) }}" class="btn2">
						<i class="ri-check-line align-middle mr-2"></i> Setuju
					</a>
					<a href="javascript:void(0);" class="btn reject">
						<i class="ri-close-line align-middle mr-2"></i> Reject
					</a>
					@elseif ($row->periksa_st==0 && $status=='periksa')
					<a href="{{ route($url_periksa,$code) }}" class="btn2">
						<i class="ri-check-line align-middle mr-2"></i> Periksa
					</a>
					<a href="javascript:void(0);" class="btn reject">
						<i class="ri-close-line align-middle mr-2"></i> Reject
					</a>
					@endif
				@else
					<span>Reject By : {{ isset($row->reject_user) ? $row->reject_user->name : ''  }}</span>
				@endif
			</div>
			@endif
		</div>
	</div>
</div>