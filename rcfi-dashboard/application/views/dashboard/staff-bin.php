<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>


		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Staff Bin</h4>
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
								<a href="#">Staff Bin</a>
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
										<h4 class="card-title">Staff Bin List</h4>
		
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="multi-filter-select" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Name</th>
													<th>Email</th>
													<th>Contact</th>
													<th>Address</th>
													<th>Option</th>
												</tr>
											</thead>
											<tbody id="table_tbody_for_append">
												<?php foreach($get_staff_bin_list as $table_row) :?>
												<tr>
													<td><?= $table_row->last_name?>,<?= $table_row->middle_name?> <?= $table_row->first_name?></td>
													<td><?= $table_row->email?></td>
													<td><?= $table_row->contact?></td>
													<td><?= $table_row->address?></td>
													<td>
														<div class="btn-group">
                                                            <button class="btn btn-primary btn-sm" onclick="getEdit('<?= $table_row ->id_user ?>')"><i class="fa fa-edit"></i></button>
                                                            <button class="btn btn-danger btn-sm" onclick="getDelete('<?= $table_row ->id_user ?>','<?= base_url()?>/controller/delete_staff')"><i class="fa fa-trash"></i></button>
                                                        </div>
													</td>
												</tr>
												<?php endforeach ?>
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

<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/delete.php')?>
<?php $this->load->view('dashboard/class/email_validate')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>

