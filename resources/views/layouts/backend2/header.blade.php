<header id="page-topbar">
	<div class="navbar-header">
		<div class="d-flex">
			<!-- LOGO -->
			<div class="navbar-brand-box">
				<a href="{{ route('backend') }}" class="logo logo-light">
					<span class="logo-sm">
						<img src="{{ asset('assets/images/lta-logo-text.png') }}" alt="" height="22">
					</span>
					<span class="logo-lg">
						<img src="{{ asset('assets/images/lta-logo-text.png') }}" alt="" height="30">
					</span>
				</a>
			</div>
			<button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect d-lg-none" id="vertical-menu-btn">
				<i class="ri-menu-2-line align-middle"></i>
			</button>
		</div>

		<div class="d-flex">
			<div class="dropdown d-inline-block user-dropdown">
				<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="rounded-circle header-profile-user" src="{{ asset('assets/images/user.png') }}" alt="Header Avatar">
					<span class="d-none d-xl-inline-block ml-1">{{ auth()->user()->name }}</span>
					<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-right">
					@if (auth()->user()->role_id==1 || auth()->user()->role_id==2)
					<a class="dropdown-item" href="{{ route('backend.users') }}">
						<i class="ri-user-line align-middle mr-1"></i> Users Management
					</a>
					<a class="dropdown-item" href="{{ route('backend.whatsapp') }}">
						<i class="ri-mac-line align-middle mr-1"></i> Whatsapp Monitor
					</a>
					<a class="dropdown-item" href="{{ route('backend.activity_user') }}">
						<i class="ri-mac-line align-middle mr-1"></i> Activity Log User
					</a>
					@elseif (auth()->user()->role_id==3 || auth()->user()->role_id==4)
					<a class="dropdown-item" href="{{ route('backend.whatsapp') }}">
						<i class="ri-mac-line align-middle mr-1"></i> Whatsapp Monitor
					</a>
					<a class="dropdown-item change_password" href="javascript:void(0);">
						<i class="ri-lock-password-fill align-middle mr-1"></i> Ubah Password
					</a>
					@elseif (auth()->user()->role_id==5)
					<a class="dropdown-item change_password" href="javascript:void(0);">
						<i class="ri-lock-password-fill align-middle mr-1"></i> Ubah Password
					</a>	
					@endif
					<a class="dropdown-item text-danger" href="{{ route('backend.logout') }}">
						<i class="ri-shut-down-line align-middle mr-1 text-danger"></i> Logout
					</a>
				</div>
			</div>
		</div>
	</div>
</header>