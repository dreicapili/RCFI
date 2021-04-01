	
	<body data-background-color="dark">
	<div class="wrapper">
		<div class="main-header">
			<!-- Logo Header -->
			<div class="logo-header" data-background-color="dark2">
				
				<a href="<?= base_url()?>user/" class="logo">
					<!-- <img src="<?= base_url()?>public/assets/img/logo.svg" alt="navbar brand" class="navbar-brand"> -->
                    <h3 class="navbar-brand card-title mt-1" style="font-size: 15px;">RCFI MARKETING </h3>
				</a>
				<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon">
						<i class="icon-menu"></i>
					</span>
				</button>
				<button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
				<div class="nav-toggle">
					<button class="btn btn-toggle toggle-sidebar">
						<i class="icon-menu"></i>
					</button> 
				</div>
			</div>
			<!-- End Logo Header -->

			<!-- Navbar Header -->
			<nav class="navbar navbar-header navbar-expand-lg" data-background-color="dark">
				
		
			</nav>
			<!-- End Navbar -->
		</div>


		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2" data-background-color="dark2">
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<div class="user">
						<div class="avatar-sm float-left mr-2">
							<?php
							if($_SESSION['picture'] == ''){
								$_SESSION['picture'] = 'courage-logo.jpg';
							}
							?>
							<img src="<?= base_url()?>public/uploads/dp/<?= $_SESSION['picture']?>" alt="..." class="avatar-img rounded-circle">
						</div>
						<div class="info">
							<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
								<span>
								<?= $_SESSION['last_name']?>, <?= $_SESSION['first_name']?> <?= $_SESSION['middle_name']?>
                                    <span class="user-level">Administrator</span>
									
									<span class="caret"></span>
								</span>
							</a>
							<div class="clearfix"></div>

							<div class="collapse in" id="collapseExample">
								<ul class="nav">
									<li>
										<a href="<?= base_url()?>user/profile">
											<span class="link-collapse">My Profile</span>
										</a>
									</li>
									<li>
										<a href="<?= base_url()?>login/logout">
											<span class="link-collapse">Logout</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<ul class="nav nav-primary">
			
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Components</h4>
						</li>
						<li class="nav-item">
							<a href="<?= base_url()?>controller/account_management">
								<i class="fas fa-users"></i>
								<p>Account Management</p>
								<!-- <span class="badge badge-success">4</span> -->
							</a>
						</li>
						<?php
							if($_SESSION['type'] == 0){
								?>
								<li class="nav-item">
									<a href="<?= base_url()?>controller/cutoff/<?= date('Y-m-d')?>">
										<i class="fas fa-money-bill"></i>
										<p>Cut-off</p>
										<!-- <span class="badge badge-success">4</span> -->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url()?>controller/giftcheck/<?= date('Y-m-d')?>">
										<i class="fas fa-money-bill"></i>
										<p>Gift Check</p>
										<!-- <span class="badge badge-success">4</span> -->
									</a>
								</li>
								<li class="nav-item">
									<a href="<?= base_url()?>controller/flushout/">
										<i class="fas fa-money-bill"></i>
										<p>Flush-Out</p>
										<!-- <span class="badge badge-success">4</span> -->
									</a>
								</li>
								
								<li class="nav-item" hidden>
									<a data-toggle="collapse" href="#sidebar_settings">
										<i class="fas fa-cogs"></i>
										<p>Settings</p>
										<span class="caret"></span>
									</a>
									<div class="collapse" id="sidebar_settings" hidden>
										<ul class="nav nav-collapse">
											<li hidden>
												<a  href="<?= base_url()?>controller/max_income">
													<span class="sub-item">Max Income</span>
												</a>
											</li>
											<li hidden>
												<a  href="<?= base_url()?>controller/membership_type">
													<span class="sub-item">Membership Type</span>
												</a>
											</li>
											<!-- <li>
												<a  href="controller/staff_mngt">
													<span class="sub-item">Staff Management</span>
												</a>
											</li> -->
										</ul>
									</div>
								</li>
								<?php
							}
						?>
						
						<?php
							if($_SESSION['type'] == 0){
								?>
								<li class="nav-item" hidden>
									<a data-toggle="collapse" href="#sidebar_bin">
										<i class="fas fa-trash"></i>
										<p>Recycle Bin</p>
										<span class="caret"></span>
									</a>
									<div class="collapse" id="sidebar_bin">
										<ul class="nav nav-collapse">
											<li hidden>
												<a  href="#">
													<span class="sub-item">Membership Type</span>
												</a>
											</li>
											<li hidden>
												<a  href="<?= base_url()?>controller/staff_bin">
													<span class="sub-item">Staff</span>
												</a>
											</li>
										</ul>
									</div>
								</li>
								<?php
							}
						?>
						<li class="nav-item">
							<a href="<?= base_url()?>user/">
								<i class="fas fa-chart-bar"></i>
								<p>Reports & Analytics</p>
								<!-- <span class="badge badge-success">4</span> -->
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url()?>reports/getTopEarners">
								<i class="fas fa-chart-bar"></i>
								<p>Top Earners</p>
								<!-- <span class="badge badge-success">4</span> -->
							</a>
						</li>
						<li class="nav-item">
							<a href="<?= base_url()?>giftcheck/print_check">
								<i class="fas fa-chart-bar"></i>
								<p>Print Check</p>
								<!-- <span class="badge badge-success">4</span> -->
							</a>
						</li>


					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->