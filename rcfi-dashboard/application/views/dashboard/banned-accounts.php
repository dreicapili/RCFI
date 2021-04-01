<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>
 

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Banned Accounts</h4>
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
								<a href="#">Banned Accounts</a>
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
										<h4 class="card-title">List of Banned Accounts</h4>
										
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
													<td>Remarks</td>
													<th>Options</th>
												</tr> 
											</thead>
											<tbody>
												<?php foreach($get_banned_accounts as $table_row): ?>
												<tr>
													<th><?= $table_row->reference_nos?></th>
													<th><?= $table_row->last_name?>,<?= $table_row->first_name?> <?= $table_row->middle_name?></th>
													<th><?= $table_row->type?> (<?= number_format($table_row->cash,2)?>)</th>
													<th><?= $table_row->remarks?></th>
                                                    
                                                    <td>
                                                        <div class="btn-group">
                                                            <button onclick="getUnBan(<?= $table_row->id_registration?>)" class="btn  btn-danger btn-sm" ><i class="fa fa-ban"></i> Remove Ban</button>
                                                        </div>
                                                    </td>
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
                                    <label>Remarks</label>
									<input  type="hidden" name="id_registration" id="id_registration" class="form-control" placeholder="Input code"   required>
                                   <textarea name="remarks"  class="form-control"  id="remarks" cols="30" rows="5" placeholder="Write something here..." required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer no-bd">
                        <button type="submit" id="btnssaveupdate" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        </form>



<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>

<script>

function getUnBan(id){

swal({
  title: "Are you sure?",
  text: "Remove Ban for this account?",
  icon: "warning",
  buttons: [
	'No, cancel it!',
	'Yes, I am sure!'
  ],
  dangerMode: true,
}).then(function(isConfirm) {
  if (isConfirm) {

	$.ajax({
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url() ?>/controller/unban_account',
		data: {id: id},
		async: false,
		dataType: 'text',
		success: function(data){
			
		},
		error: function(){
			swal('Could not edit data');
		}
	});

	swal({
	  title: 'Unban Successfully!',
	  text: 'Candidates are successfully shortlisted!',
	  icon: 'success'
	}).then(function() {
		//RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
		location.reload();
	});
  } else {
	swal("Cancelled", "", "error");
  }
})
};


</script>


		
	