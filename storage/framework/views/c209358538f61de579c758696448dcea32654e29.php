<!-- Sidebar -->
<?php
	$page = \Request::route()->getName();
	use App\DistributorMenu;
	use App\Helper;
	$menus = DistributorMenu::where('parent_id', 0)->get();
?>
<div class="sidebar sidebar-style-2">
	<div class="sidebar-wrapper scrollbar scrollbar-inner">
		<div class="sidebar-content">
			<div class="user">
				<div class="avatar-sm float-left mr-2">
					<img src="<?php echo e(asset('public/admin/logo/user-image.jpg')); ?>" alt="..." class="avatar-img rounded-circle">
				</div>
				<div class="info">
					<a data-toggle="collapse" href="#" aria-expanded="true">
						<span>
							 <?php if(!empty(Auth::user()->distributor)): ?>
								<?php echo e(Auth::user()->distributor->full_name); ?>

							 <?php endif; ?>
							 <?php if(Auth::user()->user_role == 1): ?>
								<span class="user-level">Administrator</span>
							<?php elseif(Auth::user()->user_role == 2): ?>
								<span class="user-level">Telecaller</span>
							<?php elseif(Auth::user()->user_role == 3): ?>
								<span class="user-level">Manager</span>
							<?php else: ?>
								<span class="user-level">Distributor</span>
							<?php endif; ?>
						</span>
					</a>
					<div class="clearfix"></div>
				</div>
			</div>
			<ul class="nav nav-primary">
				<?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<?php if(!$menu->has_child): ?>
							<li <?php if($page==$menu->route): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
							<a href="<?php echo e(route($menu->route)); ?>" class="collapsed" aria-expanded="false">
								<i class="<?php echo e($menu->icon); ?>"></i>
								<p><?php echo e($menu->name); ?></p>
							</a>
						<?php else: ?>
						<?php
							$submenus = Menu::where('parent_id', $menu->id)->get();
							$submenusArray = Menu::where('parent_id', $menu->id)->pluck('route')->toArray();
						?>
							<li <?php if(in_array($page, $submenusArray)): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
							<a data-toggle="collapse" href="#<?php echo e($menu->route); ?>">
								<i class="<?php echo e($menu->icon); ?>"></i>
								<p><?php echo e($menu->name); ?></p>
								<span class="caret"></span>
							</a>
							<div <?php if(in_array($page, $submenusArray)): ?> class="collapse show" <?php else: ?> class="collapse" <?php endif; ?> id="<?php echo e($menu->route); ?>">
								<ul class="nav nav-collapse">
									<?php $__currentLoopData = $submenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<li <?php if($page==$submenu->route): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
											<a href="<?php echo e(route($submenu->route)); ?>">
												<span class="<?php echo e($submenu->icon); ?>"><?php echo e($submenu->name); ?></span>
											</a>
										</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</ul>
							</div>
						</li>
						<?php endif; ?>
				</li>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				<?php if(Auth::user()->user_role == 1): ?>
					<li <?php if($page=="permission"): ?> class="nav-item active" <?php else: ?> class="nav-item" <?php endif; ?>>
						<a href="<?php echo e(route("permission")); ?>" class="collapsed" aria-expanded="false">
							<i class="fa fa-home"></i>
							<p>Permission</p>
						</a>
					</li>
				<?php endif; ?>
				<li class="nav-item">
					<a class="collapsed" href="<?php echo e(route('distributors.logout')); ?>" onclick="event.preventDefault();
                                 document.getElementById('logout-forms').submit();"><i class="fas fa-sign-out-alt" aria-hidden="true"></i>
						<p>Logout</p></a>
                    <form id="logout-forms" action="<?php echo e(route('distributors.logout')); ?>" method="GET" style="display: none;">
                        <?php echo csrf_field(); ?>
                    </form>
				</li>
			</ul>
		</div>
	</div>
</div>
<?php /**PATH /opt/lampp/htdocs/digital-post/resources/views/distributor/layouts/sidebar.blade.php ENDPATH**/ ?>