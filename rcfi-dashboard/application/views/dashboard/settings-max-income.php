<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>


		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Max Income Settings</h4>
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
								<a href="#">Max Income Type</a>
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
								<div class="card-body">
									<div class="table-responsive">
										<table id="multi-filter-select" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Max Income</th>
													<th>Option</th>
												</tr>
											</thead>
											<tbody id="table_tbody_for_append">
												<tr>
													<td>₱ <?= number_format(15000,2)?></td>
													<td>
														<div class="btn-group">
                                                            <button disabled class="btn btn-warning btn-sm" onclick="getDelete('<?= base_url()?>/controller/delete_membership_type')"><i class="fa fa-edit"></i></button>
                                                            <button disabled class="btn btn-danger btn-sm" onclick="getDelete('<?= base_url()?>/controller/delete_membership_type')"><i class="fa fa-trash"></i></button>
                                                        </div>
													</td>
												</tr>
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
                            <div class="col-md-12" id="error_msg">
                            </div>                       
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Code</label>
                                    <input  type="hidden" name="id_set_membership_type" id="id_set_membership_type" class="form-control" placeholder="Input code"   required>
                                    <input  type="text" name="code" id="code" class="form-control" placeholder="Input code"   required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Membership Type</label>
                                    <input  type="text" name="type" id="type" class="form-control" placeholder="Input type"   required>
                                </div>
                            </div>
							<div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Amount (Package Price)</label>
                                    <input  type="text" name="amount" id="amount" class="form-control" placeholder="0.00"   required
									oninput="this.value = this.value.replace(/[^0-9.]/g, &quot;&quot;); this.value = this.value.replace(/(\..*)\./g, &quot;$1&quot;)">
                                </div>
                            </div>
							<div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Commission (Amount to get for every successfull referel)</label>
                                    <input  type="text" name="commission" id="commission" class="form-control" placeholder="0.00"   required
									oninput="this.value = this.value.replace(/[^0-9.]/g, &quot;&quot;); this.value = this.value.replace(/(\..*)\./g, &quot;$1&quot;)">
                                </div>
                            </div>
							<div class="col-sm-12">
                                <div class="form-group form-group-default">
                                    <label>Pairing Amount (Amount to get for every pairing)</label>
                                    <input  type="text" name="pairing" id="pairing" class="form-control" placeholder="0.00"   required
									oninput="this.value = this.value.replace(/[^0-9.]/g, &quot;&quot;); this.value = this.value.replace(/(\..*)\./g, &quot;$1&quot;)">
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
<?php $this->load->view('dashboard/class/delete.php')?>
<?php $this->load->view('dashboard/class/email_validate')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>


<script>
$('#btnAdd').click(function(){
    $('#addRowModal').modal('show');
    $('#addRowModal').find('.modal-title').text('Add Membership Type');
    $('#myForm').attr('action','<?php echo base_url() ?>/controller/save_membership_type');

});


</script>