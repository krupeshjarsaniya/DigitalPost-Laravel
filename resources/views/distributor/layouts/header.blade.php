

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="{{ asset('public/admin/logo/user-image.jpg')}}" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="{{ asset('public/admin/logo/user-image.jpg')}}" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4> @if(!empty(Auth::user()->distributor->full_name))
													{{ Auth::user()->name }}
												</h4>
												<p class="text-muted">{{ Auth::user()->distributor->email }}</p>
												@endif
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{-- {{ route('profile') }} --}}">Edit Profile</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="{{ route('distributors.logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-forms').submit();">Logout</a>
                                        <form id="logout-forms" action="{{ route('distributors.logout') }}" method="GET" style="display: none;">
	                                        @csrf
	                                    </form>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->


