<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>


		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Payout Date List</h4>
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
								<a href="#">Payout Date List</a>
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
										<h4 class="card-title">List of Payout Date's</h4>
										<button id="btnAdd" class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											New Payout
										</button>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="multi-filter-select" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Pay Period</th>
													<th>To</th>
													<th>Transaction Number</th>
													<th>Total</th>
													<th>Created By</th>
													<th>Option</th>
												</tr>
											</thead>
											<tbody id="table_tbody_for_append">
												
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
			<div class="modal-dialog modal-lg" role="document">									
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
                        <p class="small">PAYROLL PERIOD</p>             
                        <div class="row" id="data_for_edit">
                            <div class="col-md-12" id="error_msg">
                            </div>                       
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>FROM</label>
                                    <input  type="date" name="date_from" id="date_from" class="form-control" placeholder="First name"   required>
                                    <input  type="hidden" name="id_payroll_head" id="id_payroll_head" class="form-control" placeholder="First name"   required>
                                    <input  type="hidden" name="created_by" id="created_by" value="<?= $_SESSION['id_user'] ?>" class="form-control" placeholder="First name"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>TO</label>
                                    <input  type="date" name="date_to" id="date_to" class="form-control" placeholder="Middle name"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>TRANSACTION NUMBER</label>
                                    <input readonly type="text" name="reference_number" id="reference_number" class="form-control" placeholder="Last name"   required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <p class="small">Encode By: <?= $_SESSION['last_name']?>, <?= $_SESSION['first_name']?> <?= $_SESSION['middle_name']?></p> 
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer no-bd">
                        <button type="submit" id="btnSaveEdit" class="btn btn-primary">Save</button>
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
    $('#addRowModal').find('.modal-title').text('New Payroll');
    $('#myForm').attr('action','<?php echo base_url() ?>controller/save_payroll_head');
    $('#btnSaveEdit').css("display","block");

    var reference_number = '<?=  'PR-'.date("ymdhis");?>';
    $('#reference_number').val(reference_number);

});

function getEdit(id_payroll_head){
    $('#addRowModal').modal('show');
    $('#addRowModal').find('.modal-title').text('Edit employee');
    $('#myForm').attr('action','<?php echo base_url() ?>/controller/edit_payroll_head');
    $("#btnSaveEdit").text("Update");
    
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: '<?= base_url()?>controller/for_edit_payroll_head_data',
        data:{
            id_payroll_head:id_payroll_head
        },
        // async: false,
        dataType: 'text',
        success: function(response){
            var data1 = JSON.parse(response);
            var i;
            for(i=0; i < data1.length; i++){
                $("#date_from").val(data1[i].date_from);
                $("#id_payroll_head").val(data1[i].id_payroll_head);
                $("#created_by").val(data1[i].created_by);
                $("#date_to").val(data1[i].date_to);
                $("#reference_number").val(data1[i].reference_number);
            }
        },
        error: function(){
            swal('Something went wrong');
        }
    });   
};
</script>

