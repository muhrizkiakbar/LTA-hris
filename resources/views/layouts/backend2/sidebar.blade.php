<div class="vertical-menu">
	<div data-simplebar class="h-100">
		<!--- Sidemenu -->
		<div id="sidebar-menu">
			<!-- Left Menu Start -->
			<ul class="metismenu list-unstyled" id="side-menu">
				<li <?php if($section=="dashboard"){echo 'class="mm-active"';}?>>
					<a href="{{ route('backend') }}" class="waves-effect <?php if($section=="dashboard"){echo 'mm-active';}?>">
						<i class="ri-dashboard-line"></i>
						<span>Dashboard</span>
					</a>
				</li>
				@if (auth()->user()->role_id==1 || auth()->user()->role_id==2 || auth()->user()->role_id==3)
					@include('layouts.backend2.menu.root')
				@elseif (auth()->user()->role_id==4 || auth()->user()->role_id==11)
					@include('layouts.backend2.menu.hrd')
				@elseif (auth()->user()->role_id==5)
					@if (auth()->user()->department_id==1)
						@if (auth()->user()->jabatan_id == 3)
							@include('layouts.backend2.menu.finance_head')
						@else
							@include('layouts.backend2.menu.finance_user')	
						@endif
					@else
						@include('layouts.backend2.menu.employee')
					@endif
				@elseif (auth()->user()->role_id==10)
					@include('layouts.backend2.menu.kasir')
				@endif
			</ul>
		</div>
	</div>
</div>