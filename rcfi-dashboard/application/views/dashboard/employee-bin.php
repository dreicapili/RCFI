<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>


		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Employee Bin</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">List of Employee Bin</a>
							</li>
						</ul>
					</div>
					<div class="row">

									
						<div class="col-md-12">
						<?php 
						if($this->session->userdata('acctg_msg')){
						?>
							<div class="alert alert-<?php echo $_SESSION['acctg_msg_type'] ?>" role="alert">
								<?php echo $_SESSION['acctg_msg'] ?>
							</div>
						<?php
						unset($_SESSION['acctg_msg']);	
						unset($_SESSION['acctg_msg_type']);	
						}
						?>
						</div>
					

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
                                    <div class="d-flex align-items-center">
										<h4 class="card-title">List of Employee Bin</h4>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="multi-filter-select" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Employee</th>
													<th>Contact</th>
													<th>Email</th>
													<td>Rate</td>
												</tr>
											</thead>
											<tbody>
												<?php foreach($get_deleted_employee_list as $table_row): ?>
												<tr>
													<th><?= $table_row->last_name?>,<?= $table_row->first_name?> <?= $table_row->middle_name?></th>
													<th><?= $table_row->contact?></th>
													<th><?= $table_row->email?></th>
                                                    <th>₱ <?= number_format($table_row->rate,2)?></th>

												</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



<?php $this->load->view('dashboard/template/aside.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/delete.php')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>
<?php $this->load->view('dashboard/class/example.php')?>
<?php $this->load->view('dashboard/class/jquery-mask-min.php')?>



		
	