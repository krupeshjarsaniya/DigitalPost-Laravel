<!-- Sidebar -->
@php
	$page = \Request::route()->getName();
	use App\DistributorMenu;
	use App\Helper;
	$menus = DistributorMenu::where('parent_id', 0)->get();
@endphp
<div class="sidebar sidebar-style-2">
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="{{ asset('public/admin/logo/user-image.jpg')}}" alt="..." class="avatar-img rounded-circle">
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#" aria-expanded="true">
						<span>
							 @if(!empty(Auth::user()->distributor))
								{{ Auth::user()->distributor->full_name }}
							 @endif
							 @if(Auth::user()->user_role == 1)
								<span class="user-level">Administrator</span>
							@elseif(Auth::user()->user_role == 2)
								<span class="user-level">Telecaller</span>
							@elseif(Auth::user()->user_role == 3)
								<span class="user-level">Manager</span>
							@else
								<span class="user-level">Distributor</span>
							@endif
						</span>
					</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<ul class="nav nav-primary">
				@foreach($menus as $menu)
						@if(!$menu->has_child)
							<li @if($page==$menu->route) class="nav-item active" @else class="nav-item" @endif>
							<a href="{{ route($menu->route) }}" class="collapsed" aria-expanded="false">
								<i class="{{$menu->icon}}"></i>
								<p>{{$menu->name}}</p>
							</a>
						@else
						@php
							$submenus = Menu::where('parent_id', $menu->id)->get();
							$submenusArray = Menu::where('parent_id', $menu->id)->pluck('route')->toArray();
						@endphp
							<li @if(in_array($page, $submenusArray)) class="nav-item active" @else class="nav-item" @endif>
							<a data-toggle="collapse" href="#{{$menu->route}}">
								<i class="{{$menu->icon}}"></i>
								<p>{{$menu->name}}</p>
								<span class="caret"></span>
							</a>
							<div @if(in_array($page, $submenusArray)) class="collapse show" @else class="collapse" @endif id="{{$menu->route}}">
								<ul class="nav nav-collapse">
									@foreach($submenus as $submenu)
										<li @if($page==$submenu->route) class="nav-item active" @else class="nav-item" @endif>
											<a href="{{ route($submenu->route) }}">
												<span class="{{$submenu->icon}}">{{$submenu->name}}</span>
											</a>
										</li>
									@endforeach
								</ul>
							</div>
						</li>
						@endif
				</li>
				@endforeach
				@if(Auth::user()->user_role == 1)
					<li @if($page=="permission") class="nav-item active" @else class="nav-item" @endif>
						<a href="{{ route("permission") }}" class="collapsed" aria-expanded="false">
							<i class="fa fa-home"></i>
							<p>Permission</p>
						</a>
					</li>
				@endif
				<li class="nav-item">
					<a class="collapsed" href="{{ route('distributors.logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-forms').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>
						<p>Logout</p></a>
                    <form id="logout-forms" action="{{ route('distributors.logout') }}" method="GET" style="display: none;">
                        @csrf
                    </form>
				</li>
			</ul>
		</div>
	</div>
</div>
