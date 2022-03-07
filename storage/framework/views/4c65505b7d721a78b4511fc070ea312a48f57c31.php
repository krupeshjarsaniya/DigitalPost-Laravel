 

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">
				
				<div class="container-fluid">
					<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
						<li class="nav-item dropdown hidden-caret">
							<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
								<div class="avatar-sm">
									<img src="<?php echo e(asset('public/admin/logo/user-image.jpg')); ?>" alt="..." class="avatar-img rounded-circle">
								</div>
							</a>
							<ul class="dropdown-menu dropdown-user animated fadeIn">
								<div class="dropdown-user-scroll scrollbar-outer">
									<li>
										<div class="user-box">
											<div class="avatar-lg"><img src="<?php echo e(asset('public/admin/logo/user-image.jpg')); ?>" alt="image profile" class="avatar-img rounded"></div>
											<div class="u-text">
												<h4> <?php if(!empty(Auth::user()->name)): ?>
													<?php echo e(Auth::user()->name); ?>

												</h4>
												<p class="text-muted"><?php echo e(Auth::user()->email); ?></p>
												<?php endif; ?>
											</div>
										</div>
									</li>
									<li>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="">Edit Profile</a>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault();
                                                     document.getElementById('logout-forms').submit();">Logout</a>
                                        <form id="logout-forms" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
	                                        <?php echo csrf_field(); ?>
	                                    </form>
									</li>
								</div>
							</ul>
						</li>
					</ul>
				</div>
			</nav>
			<!-- End Navbar -->
	 

<?php /**PATH /opt/lampp/htdocs/digital-post/resources/views/admin/layouts/header.blade.php ENDPATH**/ ?>