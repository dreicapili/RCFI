<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>
 

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Account Management</h4>
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
								<a href="#">Account Management</a>
							</li>
						</ul>
					</div>
					<div class="row">

									
					
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
						

						<div class="col-md-12">
							<div class="alert alert-warning ?>" role="alert">
								To delete account, Go to the last record and click Remove button. (Last in, First Out)
							</div>
						</div>
					

						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
                                    <div class="d-flex align-items-center">
										<h4 class="card-title">List of Management</h4>
										<a href="<?= base_url()?>controller/account_registration/0" id="btnAdd" class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add New
										</a>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="multi-filter-select" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Reference Code</th>
													<th>Name</th>
													<th>Membership Type</th>
													<td>Contact</td>
													<th>Options</th>
												</tr> 
											</thead>
											<tbody>
												<?php
												$count = 0;
												foreach($registration_list as $table_row){
												$count = $count + 1; ?>
												<tr>
													<th><?= $table_row->reference_nos?></th>
													<th><?= $table_row->last_name?>,<?= $table_row->first_name?> <?= $table_row->middle_name?></th>
													<th><?= $table_row->type?> (<?= number_format($table_row->cash,2)?>)</th>
													<th><?= $table_row->contact?></th>
                                                    
													<td>
															<div class="btn-group">
																	<a href="<?= base_url()?>controller/view_account/<?= $table_row->id_registration?>/<?= date("Y-m-d")?>" class="btn  btn-warning btn-sm" ><i class="fa fa-eye"></i> View Account</a>
																	<!-- <a href="controller/account_registration/" class="btn  btn-primary btn-sm" ><i class="fa fa-edit"></i> Edit</a> -->
																	<?php
																	if(count($registration_list) == $count && count($registration_list) != 1){//BEC. OUR DELETE IS LAST IN FIRST OUT
																		?>
																			<button  onclick="getBan(<?= $table_row->id_registration?>)" class="btn  btn-danger btn-sm" ><i class="fa fa-ban"></i> Remove</button>
																		<?php
																	}
																	?>
																
															</div>
													</td>
												</tr>
												<?php } ?>
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

		<!-- Modal -->
		<form method="POST" id="myForm">
			<div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog" role="document">									
					<div class="modal-content">
							<div class="modal-header no-bd">
									<h5 class="modal-title">
											<span class="fw-mediumbold">
											New</span> 
											<span class="fw-light">
													Row
											</span>
									</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
									</button>
							</div>
							<div class="modal-body">          
								<div class="row" id="data_for_edit">      
									<div class="col-sm-12">
										<h3 id="account_name">df</h3>
										</div>            
											<div class="col-sm-12">
													<div class="form-group form-group-default">
															<label>Remarks (Optional)</label>
															<input  type="hidden" name="id_registration" id="id_registration" class="form-control" placeholder="Input code"   >
															<textarea name="remarks"  class="form-control"  id="remarks" cols="30" rows="3" placeholder="Write something here..." ></textarea>
													</div>
											</div>
											<div class="col-md-12">
											<p class="uppercase">*Note</p>
											<p>- Account will be remove in the system</p>
											<p>- Transaction's created for this account will be remove also</p>
											<p>- All money related in this account will be remove also.</p>
											</div>
									</div>
								</div>
								<div class="modal-footer no-bd">
										<button onclick="return confirm('Are you sure you want to remove this account?')" type="submit" id="btnssaveupdate" class="btn btn-primary">Save</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
								</div>
							</div>
					</div>
        </div>
			</form>


<?php $this->load->view('dashboard/template/preloading.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>

<script>
	
//PRELOADING
$(document).ready(function(){
  $('body').addClass('loaded');
  $('h1').css('color','#222222');	
});
																	

function getBan(id_registration){
	$('#addRowModal').modal('show');
	$('#addRowModal').find('.modal-title').text('Do you want to remove this account?');
	$('#myForm').attr('action','<?php echo base_url() ?>/controller/ban_account');

	$.ajax({
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url() ?>/controller/get_account_to_ban',
		data: {id_registration: id_registration},
		async: false,
		dataType: 'text',
		success: function(data){ 
			console.log(data);
			var data = JSON.parse(data);
			$("#account_name").text(data[0].name);
			$("#id_registration").val(data[0].id_registration);
		},
		error: function(){
			swal('Could not edit data');
		}
	});

}


</script>


		
	