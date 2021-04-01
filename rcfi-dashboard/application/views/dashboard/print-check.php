<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

 
		<div class="main-panel"> 			 
			<div class="content"> 
				<div class="page-inner"> 
					<div class="page-header">
						<h4 class="page-title">Cheque Generation</h4>
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
								<a href="<?= base_url()?>controller/account_management">Account Management</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li> 
							<li class="nav-item">
								<a href="#">Account Registration</a>
							</li>
						</ul>
					</div>

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


					<div class="row">

									
						<div class="col-md-12" id="div_max_account_warning">

						</div>
					

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title" style="text-transform:uppercase">FILL OUT ALL THE REQUIRED FIELDS</h4>
                      <button id="btnSave" class="btn btn-primary btn-round ml-auto">
												<i class="fa fa-print"></i>
												Generate Check
											</button>
									</div>
								</div>
								<div class="card-body">
							
                <div class="row">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <span>* Check Date</span>
                      <input  type="date" name="first_name" id="first_name"  class="form-control  form-control-sm" placeholder="Input first name">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <span>* Pay to the order of </span>
                      <input  type="text" name="middle_name" id="middle_name"  class="form-control form-control-sm" placeholder="Input middle name">
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group ">
                      <span>* Amount</span>
                      <input  type="number" name="middle_name" id="middle_name"  class="form-control form-control-sm" placeholder="Input middle name">
                    </div>
                  </div>
								  <div class="col-sm-4">
                    <div class="form-group ">
                      <span>* Pesos</span>
                      <input  type="number" name="middle_name" id="middle_name"  class="form-control form-control-sm" placeholder="Input middle name">
                    </div>
                  </div>
                  <div class="col-sm-4" hidden>
                    <div class="form-group ">
                      <span>* Signature</span>
                      <input  type="number" name="middle_name" id="middle_name"  class="form-control form-control-sm" placeholder="Input middle name">
                    </div>
                  </div>
                 
                </div>
              </div>
            </div>
          </div>




<?php $this->load->view('dashboard/class/email_validate.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>
<?php $this->load->view('dashboard/class/example.php')?>
<?php $this->load->view('dashboard/class/jquery-mask-min.php')?>


<script>


</script>
