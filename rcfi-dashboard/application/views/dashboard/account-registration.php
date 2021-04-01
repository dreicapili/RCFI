<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

 
		<div class="main-panel"> 			 
			<div class="content"> 
				<div class="page-inner"> 
					<div class="page-header">
						<h4 class="page-title">Account Registration</h4>
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
                                    <h4 class="card-title" style="text-transform:uppercase">APPLICATION FORM</h4>
										<?php
										if($this->uri->segment('3') == 0){
											echo '
											<button id="btnSave" class="btn btn-primary btn-round ml-auto">
												<i class="fa fa-plus"></i>
												Save Registration
											</button>
											';
										}else{
											echo '
											<button id="btnSave" class="btn btn-warning btn-round ml-auto">
												<i class="fa fa-edit"></i>
												Update Account
											</button>
											';
										}
										?>

									</div>
								</div>
								<div class="card-body">
							
                                <div class="row">
								<div class="col-sm-2">
									<div class="form-group">
										<span>*Type of Membership</span>
										<select readonly class="form-control  form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
										onchange="id_set_membership_type(this.value)" name="id_set_membership_type" id="id_set_membership_type">
											<option value="">Select</option>
											<?php foreach($membership_type as $table_row) :?>		
											<option value="<?= $table_row->id_set_membership_type?>"><?= $table_row->type?></option>
											<?php endforeach ?>
										</select>			
									</div>
								</div>
								<div class="col-sm-2" id="fetch_mem_type_amount">
									<div class="form-group ">
										<span>*Amount</span>
										<input readonly type="text" name="membership_type_amount" id="membership_type_amount" class="form-control  form-control-sm" placeholder="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '')" required>
										<input readonly type="hidden" name="membership_type_commission" id="membership_type_commission" class="form-control  form-control-sm" placeholder="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '')" required>
										<input readonly type="hidden" name="membership_type_pairing" id="membership_type_pairing" class="form-control  form-control-sm" placeholder="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '')" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Reference Number</span>
										<input readonly type="text" name="reference_nos" id="reference_nos" class="form-control  form-control-sm"
										value="<?php echo isset($reference_nos) ? $reference_nos : '#'.$ref_code?>" placeholder="Reference number " required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>Self</span>
										<select class="form-control form-control-sm selectpicker" onchange="get_self_account()" data-show-subtext="true" data-live-search="true"
										 name="get_self_account" id="get_self_account">
											<option value="0">Select</option>
											<?php foreach($unique_registered_accounts as $table_row) :?>		
												<option value="<?= $table_row->id_registration?>"><?= $table_row->reference_nos?> - <?= $table_row->last_name?>, <?= $table_row->first_name?> <?= $table_row->middle_name?></option>
											<?php endforeach ?>
										</select>
										<input  type="hidden" name="current_account_count" id="current_account_count"  >
										<input  type="hidden" name="account_limit" id="account_limit"  >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Last Name</span>
										<input  type="text" name="last_name" id="last_name" class="form-control  form-control-sm" placeholder="Input last name" required
										value="<?php echo isset($last_name) ? $last_name : ''?>" onkeyup="this.value = this.value.toUpperCase();">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*First Name</span>
										<input  type="text" name="first_name" id="first_name"  class="form-control  form-control-sm" placeholder="Input first name"  required
										value="<?php echo isset($first_name) ? $first_name : ''?>" onkeyup="this.value = this.value.toUpperCase();">
									</div>
								</div>
                                <div class="col-sm-4">
									<div class="form-group">
										<span>*Middle Name</span>
										<input  type="tex" name="middle_name" id="middle_name"  class="form-control form-control-sm" placeholder="Input middle name" 
										value="<?php echo isset($middle_name) ? $middle_name : ''?>" onkeyup="this.value = this.value.toUpperCase();">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group ">
										<span>*Province</span>
										<div id="get_province_list">
												<select  class="form-control form-control-sm"
											onchange="select_city(this.value)" id="main_address_province" name="main_address_province" >
												<option value="">select region first</option>
												<?php foreach($get_province as $table_row) :?>
													<option value="<?= $table_row->id_main_address_province?>"><?= $table_row->provDesc?></option>
												<?php endforeach ?>
													</select>
											</div>
										</div>
									</div>
								<div class="col-sm-4">
									<div class="form-group ">
										<span>*City</span>
											<div id="get_city_list">
													<select class="form-control form-control-sm" id="main_address_city" onchange="select_barangay(this.value)" name="main_address_city" >
															<option value="">select province first</option>
													</select>
											</div>
									</div>
							</div>
							<div class="col-sm-4">
								<div class="form-group span">
									<span>*Barangay</span>
									<div id="get_barangay_list">
										<select class="form-control form-control-sm" id="main_address_barangay" name="main_address_barangay" >
											<option value="">select city first</option>
											<span id="select_barangay_result"></span>
										</select>
									</div>
								</div>
							</div>


								<div class="col-sm-4">
									<div class="form-group">
										<span>*Birthday</span>
										<input  type="date" name="bday" id="bday"  class="form-control form-control-sm" placeholder="Input middle name" 
										value="<?php echo isset($bday) ? $bday : ''?>">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>Birth Place</span>
										<input  type="text" name="bplace" id="bplace"  class="form-control form-control-sm" placeholder="Input birth place" 
										value="<?php echo isset($last_name) ? $last_name : ''?>" onkeyup="this.value = this.value.toUpperCase();">
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Gender</span>
										<select class="form-control form-control-sm" 
										 name="id_main_gender" id="id_main_gender">
											<option value="">Select</option>
											<?php foreach($get_gender as $table_row) :?>
												<option value="<?= $table_row->id_main_gender?>"><?= $table_row->gender?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Civil Status</span>
										<select class="form-control form-control-sm " 
										name="id_main_civil_status" id="id_main_civil_status">
											<option value="">Select</option>
											<?php foreach($get_civil_status as $table_row) :?>
												<option value="<?= $table_row->id_main_civil_status?>"><?= $table_row->civil_status?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>*Contact Number</span>
										<input  type="text"  name="contact" id="contact"  class="form-control form-control-sm ph_mobile_phone" placeholder="" 
										value="<?php echo isset($contact) ? $contact : ''?>" >
                                    </div>
                                </div>
								<div class="col-sm-4">
                                    <div class="form-group">
                                        <span>Email</span>
										<input  type="email" name="email" id="email"  class="form-control form-control-sm" placeholder="Enter email" 
										value="<?php echo isset($email) ? $email : ''?>" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>SSS/GSIS No.</span>
										<input  type="text" name="sss" id="sss"  class="form-control form-control-sm" placeholder="Enter sss/gsis nos" 
										value="<?php echo isset($sss) ? $sss : ''?>" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>TIN No</span>
										<input  type="text" name="tin" id="tin"  class="form-control form-control-sm" placeholder="Enter tin" 
										value="<?php echo isset($tin) ? $tin : ''?>" >
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>Occupation</span>
										<input  type="tex" name="occupation" id="occupation"  class="form-control form-control-sm" placeholder="Enter occupation" 
										value="<?php echo isset($occupation) ? $occupation : ''?>" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>Spouse Name (If any)</span>
										<input  type="text" name="spouse" id="spouse"  class="form-control form-control-sm" placeholder="Enter spouse" 
										value="<?php echo isset($spouse) ? $spouse : ''?>" onkeyup="this.value = this.value.toUpperCase();">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <span>Contact Number (Optional)</span>
										<input  type="text" name="spouse_contact" id="spouse_contact"  class="form-control form-control-sm ph_mobile_phone" placeholder="" 
										value="<?php echo isset($spouse_contact) ? $spouse_contact : ''?>" >
                                    </div>
                                </div>
							</div>
						</div>
                    </div>

					<?php if($this->uri->segment('3') == 0 && $ref_code != '1001'){?>					
                    <div class="row">
                        <div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="d-flex align-items-center">
										<h4 class="card-title" style="text-transform:uppercase">Structure Details / Sponsor Details</h4>
									</div>
								</div>
								<div class="card-body">
							
									<div class="row">

								<div class="col-sm-6">
									<div class="form-group">
										<span>*Sponsor Account #</span>
										<select class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
										onchange="id_acc_recruiter()" name="id_acc_recruiter" id="id_acc_recruiter">
											<option value="">Select</option>
											<?php foreach($registered_accounts as $table_row) :?>		
											<option value="<?= $table_row->id_registration?>"><?= $table_row->reference_nos?> - <?= $table_row->last_name?>, <?= $table_row->first_name?> <?= $table_row->middle_name?></option>
											<?php endforeach ?>
										</select>			
									</div>
								</div>
								<div class="col-md-1" id="div_left_sponsor">
									<div class="form-check">
										<span class="jrey-invi">Name</span><br>
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="left_sponsor" id="left_sponsor" required>
											<span class="form-check-sign"> LEFT</span>
										</label>
									</div>
								</div>
								<div class="col-md-1" id="div_right_sponsor">
									<div class="form-check">
										<span class="jrey-invi">Name</span><br> 
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="right_sponsor" id="right_sponsor" required>
											<span class="form-check-sign"> RIGHT</span>
										</label>
									</div>
								</div>
								<div class="col-sm-4" hidden>
									<div class="form-group">
										<span>*flag yes/no</span>
										<input readonly type="text" name="sponsor_flag" id="sponsor_flag" class="form-control  form-control-sm" placeholder="0" required>
									</div>
								</div>
								<div class="col-sm-4" hidden>
									<div class="form-group">
										<span>*ROW</span>
										<input readonly type="text" name="sponsor_row" id="sponsor_row" class="form-control  form-control-sm" placeholder="0" >
									</div>
								</div>
                                <div class="col-sm-12">
								</div>
                                <div class="col-sm-4">
									<div class="form-group" hidden>
										<span>*Last Name</span>
										<input readonly type="hidden" name="if_have_placement" id="if_have_placement" class="form-control  form-control-sm" placeholder="if_have_placement" required>
										<input readonly type="hidden" name="if_left_right_is_ok" id="if_left_right_is_ok" class="form-control  form-control-sm" placeholder="if_left_right_is_ok" required>
										<input readonly type="text" name="sponsor_last_name" id="sponsor_last_name" class="form-control  form-control-sm" placeholder="Input last name" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group" hidden>
										<span>*First Name</span>
										<input readonly type="text" name="sponsor_first_name" id="sponsor_first_name"  class="form-control  form-control-sm" placeholder="Input first name"  required>
									</div>
								</div>
                                <div class="col-sm-4">
									<div class="form-group" hidden>
										<span>*Middle Name</span>
										<input readonly type="tex" name="sponsor_middle_name" id="sponsor_middle_name"  class="form-control form-control-sm" placeholder="Input middle name" required>
									</div>
								</div>
							</div>

							<div class="row" id="div_for_placement">
								<div class="col-sm-6">
									<div class="form-group">
										<span>*Placement Account #</span>
										<!-- <select class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
										onchange="id_acc_recruiter()" name="id_acc_recruiter" id="id_acc_recruiter"> -->
										<select class="form-control  form-control-sm" onchange="id_acc_replacement()" name="id_acc_replacement" id="id_acc_replacement">
											<option value="">Select</option>
										</select>			
									</div>
								</div>

								<div class="col-md-1">
									<div class="form-check">
										<span class="jrey-invi">Name</span><br>
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="left_placement" id="left_placement" required>
											<span class="form-check-sign"> LEFT</span>
										</label>
									</div>
								</div>
								<div class="col-md-1">
									<div class="form-check">
										<span class="jrey-invi">Name</span><br> 
										<label class="form-check-label">
											<input class="form-check-input" type="checkbox" name="right_placement" id="right_placement" required>
											<span class="form-check-sign"> RIGHT</span>
										</label>
									</div>
								</div>		

								<div class="col-sm-12">
								</div>
								<div class="col-sm-4" hidden>
									<div class="form-group">
										<span>*Last Name</span>
										<input readonly type="text" name="replacement_last_name" id="replacement_last_name" class="form-control  form-control-sm" placeholder="Input last name" required>
									</div>
								</div>
								<div class="col-sm-4" hidden>
									<div class="form-group">
										<span>*First Name</span>
										<input readonly type="text" name="replacement_first_name" id="replacement_first_name"  class="form-control  form-control-sm" placeholder="Input first name"  required>
									</div>
								</div>
								<div class="col-sm-4" hidden>
									<div class="form-group">
										<span>*Middle Name</span>
										<input readonly type="tex" name="replacement_middle_name" id="replacement_middle_name"  class="form-control form-control-sm" placeholder="Input middle name" required>
									</div>
								</div>
							</div>

						</div>
					</div>
					<!-- PAIRING COMMISION							 -->
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title" style="text-transform:uppercase">List of account to receive pairing commission</div>
										<button id="btn_add_pairing" class="btn btn-primary btn-round ml-auto " >
											<i class="fa fa-add"></i>
											Add Account
										</button>
									</div>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table id="table_pairing" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th hidden>id</th>
													<th>Pic</th>
													<th>Account #</th>
													<th>Full Name</th>
												</tr>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- PAIRING COMMISION							 -->
					<?php }?>



					
				</div>
			</div>
		</div>


		<!-- ADD PERSON MODAL -->
		<div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog" role="document">									
                <div class="modal-content">
                    <div class="modal-header no-bd">
                        <h5 class="modal-title"> 
                            <span class="fw-mediumbold">
                            SELECT </span> 
                            <span class="fw-light">
                                ACCOUNT
                            </span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color:#202940">           
                        <div class="row" id="data_for_edit">
                            <div class="col-sm-12">

								<label>Select Account</label>
								
								<select class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
								name="add_account" id="add_account">
									<option value="">Select</option>
									<?php foreach($registered_accounts as $table_row) :?>		
									<option value="<?= $table_row->id_registration?>"><?= $table_row->reference_nos?> - <?= $table_row->last_name?>, <?= $table_row->first_name?> <?= $table_row->middle_name?></option>
									<?php endforeach ?>
								</select>	

                            </div>

                        </div>
                    </div>
                    <div class="modal-footer no-bd" style="background-color:#202940">
                        <button type="button" id="btn_add_pairing_account" class="btn btn-primary btn-sm">Add</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD PERSON MODAL -->



<?php $this->load->view('dashboard/class/email_validate.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/ignore_special_characters.php')?>
<?php $this->load->view('dashboard/class/example.php')?>
<?php $this->load->view('dashboard/class/jquery-mask-min.php')?>


<script>

$("#btn_add_pairing").click(function(){
	$('#addRowModal').modal('show');
	$('#addRowModal').find('.modal-title').text('PAIRING COMMISION');
})

$("#btn_add_pairing_account").click(function(){
	var add_account = $("#add_account").val();

    if(add_account == ''){
        swal('Select account','','error');
    }else{

		$.ajax({
			type: 'ajax',
			method: 'post',
			url: '<?php echo base_url()?>controller/fetch_acc_primary_details',
			data:{
				id:add_account
				},
			// async: false,
			dataType: 'text',
			success: function(response){
				var data = JSON.parse(response);
				var img = '';
				if(data[0].pic == ''){
					img = 'default_pic.png';
				}else{
					img = data[0].pic;
				}
				$("#table_pairing").append(
					'<tr>'+
						'<td hidden>'+data[0].id_registration+'</td>'+
						'<td><img src="<?php echo base_url()?>public/uploads/dp/'+img+'" style="width:60px;height:60px;"></img></td>'+
						'<td>'+data[0].reference_nos+'</td>'+
						'<td>'+data[0].name+'</td>'+
						
						'<td><button id="delete_payment" class="btn btn-danger btn-sm" ><i class="fa fa-trash"></i></button></td>'+
					'<tr>'
				);
			},
			error: function(){
				swal('Something went wrong');
			}
		});

		$("#add_account").val('');
		// $('.filter-option-inner-inner').text('Select');

		$('#addRowModal').modal('hide');
		
    }
})

//REMOVE DETAILS
$('#table_pairing').on("click","#delete_payment",function(){
	$(this).closest("tr").remove();
});


//BY DEFAULT
$("#div_for_placement").hide();

//LEFT AND RIGHT SETTNGS
$('#left_sponsor').change(function(){
	if($('input[name="left_sponsor"]').is(':checked')){
		$("#right_sponsor").prop("checked", false);
		//PLACEMENT
		$("#left_placement").prop("checked", false);
		$("#right_placement").prop("checked", false);
		//CLEAR PLACEMENT ACCOUNT
		$("#id_acc_replacement").val('');
	}
});

$('#right_sponsor').change(function(){
	if($('input[name="right_sponsor"]').is(':checked')){
		$("#left_sponsor").prop("checked", false);
		//PLACEMENT
		$("#left_placement").prop("checked", false);
		$("#right_placement").prop("checked", false);
		//CLEAR PLACEMENT ACCOUNT
		$("#id_acc_replacement").val('');
	}
});

$('#left_placement').change(function(){
	if($('input[name="left_placement"]').is(':checked')){
		$("#right_placement").prop("checked", false);
		//SPONSOR
		$("#left_sponsor").prop("checked", false);
		$("#right_sponsor").prop("checked", false);
	}
});

$('#right_placement').change(function(){
	if($('input[name="right_placement"]').is(':checked')){
		$("#left_placement").prop("checked", false);
		//SPONSOR
		$("#left_sponsor").prop("checked", false);
		$("#right_sponsor").prop("checked", false);
	}
});
//LEFT AND RIGHT SETTNGS



//ADDRESS MANAGEMENT
function select_city(id_main_address_city){
	var main_address_province = $("#main_address_province").val();

	$.ajax({
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/select_city',
		data:{
			id:main_address_province
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			var data = JSON.parse(response);
			var i;
			$("#main_address_city").html('');
			$("#main_address_city").append('<option value="">Select</option>');
			for(i=0; i<data.length; i++){
				$("#main_address_city").append('<option value="'+data[i].id_main_address_city+'">'+data[i].citymunDesc+'</option>');	
			}

			$("#main_address_city").val(id_main_address_city);
		},
		error: function(){
			swal('Something went wrong');
		}
	});
}

function select_barangay(main_address_city,id_main_address_barangay){
	
	$.ajax({
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/select_barangay',
		data:{
			id:main_address_city
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			var data = JSON.parse(response);
			var i;
				$("#main_address_barangay").html('');
				$("#main_address_barangay").append('<option value="">Select</option>');
			for(i=0; i<data.length; i++){
				$("#main_address_barangay").append('<option value="'+data[i].id_main_address_barangay+'">'+data[i].brgyDesc+'</option>');
			}
			$("#main_address_barangay").val(id_main_address_barangay);
		},
		error: function(){
			swal('Something went wrong');
		}
	});
}
//ADDRESS MANAGEMENT

function id_set_membership_type(id){
	$.ajax({
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/get_membership_type_value_by_id',
		data:{
			id:id
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			// console.log(response);
			var data = JSON.parse(response);
			
			$("#membership_type_amount").val(parseFloat(data[0].membership_type_amount).toFixed(2));
			$("#membership_type_commission").val(parseFloat(data[0].membership_type_commission).toFixed(2));
			$("#membership_type_pairing").val(parseFloat(data[0].membership_type_pairing).toFixed(2));
			// $("#table_type_pairing").text(parseFloat(data[0].membership_type_pairing).toFixed(2));
			$("#account_limit").val(data[0].account_limit);

		},
		error: function(){
			swal('Something went wrong');
		}
	});
}


//SELECTION OF SPONSOR ACCOUNT
function id_acc_recruiter(){
	var id_acc_recruiter = $("#id_acc_recruiter").val();
	$('html,body').animate({scrollTop: document.body.scrollHeight},"slow");

	//REMOVE THE CHECK OF ALL CHECKBOX
	$("#left_sponsor").prop("checked", false);
	$("#right_sponsor").prop("checked", false);
	$("#left_placement").prop("checked", false);
	$("#right_placement").prop("checked", false);

	$.ajax({//AJAX TO GET SPONSOR ACCOUNT DETAILS
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/fetch_registered_account_by_id',
		data:{
			id:id_acc_recruiter
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			// console.log(response);
			var data = JSON.parse(response);
			$("#sponsor_last_name").val(data[0].last_name);
			$("#sponsor_first_name").val(data[0].first_name);
			$("#sponsor_middle_name").val(data[0].middle_name);
			$("#sponsor_row").val(data[0].row);
			$("#if_have_placement").val(data[0].if_have_placement); //COUNT(a.id_acc_recruiter) //NUMBER OF RECRUITS

			//IF if_left_right_is_ok = 0
			//THEN ENABLE THE LEFT AND RIGHT IN SPONSOR, ELSE DISABLED
			var if_left_right_is_ok = data[0].if_left_right_is_ok; // SUM(id_position)

			var if_have_placement = data[0].if_have_placement;

			// alert(if_have_placement+' | '+if_left_right_is_ok);

			//CHECK LEFT IF AVAILABLE TO CHOOSE
			if(data[0].check_replacement_left != null || data[0].check_recruiter_left != null){ //IF NULL MEANING AVAILABLE PA
				$("#left_sponsor").attr("disabled",true);
			}else{
				$("#left_sponsor").attr("disabled",false);
			}

			//CHECK RIGHT IF AVAILABLE TO CHOOSE
			if(data[0].check_replacement_right != null || data[0].check_recruiter_right != null){ //IF NULL MEANING AVAILABLE PA
				$("#right_sponsor").attr("disabled",true);
			}else{
				$("#right_sponsor").attr("disabled",false);
			}

			if(if_have_placement < 0){//IF WALA PANG RECRUIT //MAS MABABA OR EQUAL KAY 0
				// $("#div_for_placement").hide();
				$("#div_left_sponsor").show();
				$("#div_right_sponsor").show();
				$("#sponsor_flag").val(0);//MEANING REPLACEMENT IS NOT AVAILABLE
			}else{
				$("#div_for_placement").show();
				// if(if_left_right_is_ok != '' || if_left_right_is_ok != '0'){//IF = 0 || '', THEN ENABLE NA UNG PLACEMENT
				if(if_have_placement <=1 ){//IF = 1 || '', THEN ENABLE NA UNG PLACEMENT
					$("#div_left_sponsor").show();
					$("#div_right_sponsor").show();

					// //CHECK LEFT IF AVAILABLE TO CHOOSE
					// if(data[0].check_left != null){ //IF NULL MEANING AVAILABLE PA
					// 	$("#left_sponsor").attr("disabled",true);
					// }else{
					// 	$("#left_sponsor").attr("disabled",false);
					// }

					// //CHECK RIGHT IF AVAILABLE TO CHOOSE
					// if(data[0].check_right != null){ //IF NULL MEANING AVAILABLE PA
					// 	$("#right_sponsor").attr("disabled",true);
					// }else{
					// 	$("#right_sponsor").attr("disabled",false);
					// }
					

					$("#sponsor_flag").val(0);//MEANING REPLACEMENT IS NOT AVAILABLE
				}else{
					if(if_left_right_is_ok == 1){//COUNT OF LEFT AND RIGHT IF 1 = HIDE
						// $("#div_left_sponsor").hide();
						// $("#div_right_sponsor").hide();
						$("#sponsor_flag").val(1);//REPLACEMENT IS AVAILABLE
					}else{
						$("#div_left_sponsor").show();
						$("#div_right_sponsor").show();
						$("#sponsor_flag").val(0);
					}


				}
			}

			$.ajax({//ANOTHER AJAX THAT WILL GET CHOICES FOR REPLACEMENT
				type: 'ajax',
				method: 'post',
				url: '<?php echo base_url()?>controller/fetch_reg_account_for_replacement',
				data:{
					id_acc_recruiter:id_acc_recruiter,
					dt:data[0].dt
					},
				// async: false,
				dataType: 'text',
				success: function(data){
				
					var data1 = JSON.parse(data);
					alert(data1.length);
					var i;
					$("#id_acc_replacement").html('');
					$("#id_acc_replacement").append('<option value="">Select</option>');
					for(i=0;i<data1.length;i++){//APPEND OPTION TO REPLACEMENT

						// CREATE DO WHILE HERE
						// TO GET DOWNLOINE ACCOUNT
						$("#id_acc_replacement").append('<option value="'+data1[i].id_registration+'">'+data1[i].reference_nos+'</option>');	
					}
				},
				error: function(){
					swal('Something went wrong');
				}
			});//ANOTHER AJAX THAT WILL GET CHOICES FOR REPLACEMENT

		},
		error: function(){
			swal('Something went wrong');
		}
	});//AJAX TO GET SPONSOR ACCOUNT DETAILS
	
}
//SELECTION OF SPONSOR ACCOUNT


//SELECTION OF REPLACEMENT ACCOUNT
function id_acc_replacement(){
	var id_acc_replacement = $("#id_acc_replacement").val();

	$.ajax({//AJAX TO GET REPLACEMENT ACCOUNT DETAILS
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/fetch_registered_account_by_id',
		data:{
			id:id_acc_replacement
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			// console.log(response);
			var data = JSON.parse(response);
			$("#replacement_last_name").val(data[0].last_name);
			$("#replacement_first_name").val(data[0].first_name);
			$("#replacement_middle_name").val(data[0].middle_name);

			// IF if_left_right_is_ok = 0
			// THEN ENABLE THE LEFT AND RIGHT IN SPONSOR, ELSE DISABLED
			// var if_left_right_is_ok = data[0].if_left_right_is_ok; // SUM(id_position)
			//CHECK LEFT IF AVAILABLE TO CHOOSE
			if(data[0].check_replacement_left != null || data[0].check_recruiter_left != null){ //IF NULL MEANING AVAILABLE PA
				$("#left_placement").attr("disabled",true);
			}else{
				$("#left_placement").attr("disabled",false);
			}

			//CHECK RIGHT IF AVAILABLE TO CHOOSE
			if(data[0].check_replacement_right != null || data[0].check_recruiter_right != null){ //IF NULL MEANING AVAILABLE PA
				$("#right_placement").attr("disabled",true);
			}else{
				$("#right_placement").attr("disabled",false);
			}
			

		},
		error: function(){
			swal('Something went wrong');
		}
	});//AJAX TO GET SPONSOR ACCOUNT DETAILS
	
}
//SELECTION OF REPLACEMENT ACCOUNT


//GET PERSONAL ACCOUNT
function get_self_account(){
	var get_self_account = $("#get_self_account").val();

	if(get_self_account == '0'){
		location.reload();
	}

	$.ajax({//AJAX TO GET REPLACEMENT ACCOUNT DETAILS
		type: 'ajax',
		method: 'post',
		url: '<?php echo base_url()?>controller/get_self_account',
		data:{
			id:get_self_account
			},
		// async: false,
		dataType: 'text',
		success: function(response){
			var data = JSON.parse(response);

			//
			var current_account_count = data[0].current_account_count;
			var account_limit = data[0].account_limit;
			if(current_account_count >= account_limit){
				swal('This account reached the limit of 7 acc per account','','error');
				$("#div_max_account_warning").html(
					'<div class="alert alert-danger" role="alert">'+
						'This account reached the limit of 7 acc per account'+
					'</div>'
				);
			}else{
				$("#last_name").val(data[0].last_name);
				$("#first_name").val(data[0].first_name);
				$("#middle_name").val(data[0].middle_name);
				// $("#main_address_province").val(data[0].id_main_address_province);
				// $("#main_address_city").val(data[0].id_main_address_city);
				// $("#main_address_barangay").val(data[0].id_main_address_barangay);
				$("#bday").val(data[0].bday);
				$("#bplace").val(data[0].bplace);
				$("#id_main_gender").val(data[0].id_main_gender);
				$("#id_main_civil_status").val(data[0].id_main_civil_status);
				$("#contact").val(data[0].contact);
				$("#email").val(data[0].email);
				$("#sss").val(data[0].sss);
				$("#tin").val(data[0].tin);
				$("#occupation").val(data[0].occupation);
				$("#spouse").val(data[0].spouse);
				$("#spouse_contact").val(data[0].spouse_contact);
				
				$("#main_address_province").val(data[0].id_main_address_province);
				select_city(data[0].id_main_address_city);
				select_barangay(data[0].id_main_address_city,data[0].id_main_address_barangay);

			
				$("#last_name").attr('disabled',true);
				$("#first_name").attr('disabled',true);
				$("#middle_name").attr('disabled',true);
				$("#main_address_province").attr('disabled',true);
				$("#main_address_city").attr('disabled',true);
				$("#main_address_barangay").attr('disabled',true);
				$("#bday").attr('disabled',true);
				$("#bplace").attr('disabled',true);
				$("#id_main_gender").attr('disabled',true);
				$("#id_main_civil_status").attr('disabled',true);
				$("#contact").attr('disabled',true);
				$("#email").attr('disabled',true);
				$("#sss").attr('disabled',true);
				$("#tin").attr('disabled',true);
				$("#occupation").attr('disabled',true);
				$("#spouse").attr('disabled',true);
				$("#spouse_contact").attr('disabled',true);

			}

			$("#current_account_count").val(data[0].current_account_count);
			$("#account_limit").val(data[0].account_limit);

		},
		error: function(){
			swal('Something went wrong');
		}
	});//AJAX TO GET SPONSOR ACCOUNT DETAILS
	
}
//GET PERSONAL ACCOUNT



$("#btnSave").click(function(){
	var get_self_account = $("#get_self_account").val();
	var id_set_membership_type = $("#id_set_membership_type").val();
	var membership_type_amount = $("#membership_type_amount").val();
	var membership_type_commission = $("#membership_type_commission").val();
	var membership_type_pairing = $("#membership_type_pairing").val();
	var reference_nos = $("#reference_nos").val();
	var last_name = $("#last_name").val();
	var first_name = $("#first_name").val();
	var middle_name = $("#middle_name").val();
	var id_main_address_province = $("#main_address_province").val();
	var id_main_address_city = $("#main_address_city").val();
	var id_main_address_barangay = $("#main_address_barangay").val();
	var bday = $("#bday").val();
	var bplace = $("#bplace").val();
	var id_main_gender = $("#id_main_gender").val();
	var id_main_civil_status = $("#id_main_civil_status").val();
	var contact = $("#contact").val();
	var email = $("#email").val();
	var sss = $("#sss").val();
	var tin = $("#tin").val();
	var occupation = $("#occupation").val();
	var spouse = $("#spouse").val();
	var spouse_contact = $("#spouse_contact").val();
	var id_acc_recruiter = $("#id_acc_recruiter").val();
	var id_acc_replacement = $("#id_acc_replacement").val();
	var sponsor_flag = $("#sponsor_flag").val();
	var if_have_placement = $("#if_have_placement").val();
	var sponsor_row = $("#sponsor_row").val();

	var current_account_count = $("#current_account_count").val();
	var account_limit = $("#account_limit").val();
	var last_id = '';


	//GET ALL ACCOUNT IN PAIRING TABLE
	var table_data = [];
    $('#table_pairing tr').each(function(row,tr){
        if($(tr).find('td:eq(0)').text() == ''){
        }else{
            var sub = {
            'id' : $(tr).find('td:eq(0)').text(),
            };
        } 
        table_data.push(sub);
    });
    table_data = table_data.filter(function(e){return e}); 
    var data_pairing = {'data_table' : table_data}
	//GET ALL ACCOUNT IN PAIRING TABLE


	if(current_account_count >= account_limit){
		$xxx = $("#id_set_membership_type").val();
		if($xxx != ''){
			swal('This account reached the limit of 7 acc per account','','error');
			$("#div_max_account_warning").html(
				'<div class="alert alert-danger" role="alert">'+
					'This account reached the limit of 7 acc per account'+
				'</div>'
			);
		}else{
			swal('Choose membership type first','','error');
		}
	}else{

		var id_main_position;

		// alert(sponsor_flag+' sponsor_flag');

		if(sponsor_flag == '0'){//FOR SPONSOR ACCOUNT

			//IF ONE IS SELECTED
			if($('input[name="left_sponsor"]').is(':checked')){
				//0 = LEFT
				id_main_position = 0;
			}else{
				//0 = RIGHT
				id_main_position = 1;
			}

			//IF NO POSITION IS SELECTED
			if($('input[name="left_sponsor"]').is(':checked') == false && $('input[name="right_sponsor"]').is(':checked') == false){
				//0 = LEFT
				id_main_position = 2;
			}

		}else if(sponsor_flag == '1'){//FOR REPLACEMENT ACCOUNT

			//IF ONE IS SELECTED
			if($('input[name="left_placement"]').is(':checked')){
				//0 = LEFT
				id_main_position = 0;
			}else{
				//0 = RIGHT
				id_main_position = 1;
			}

			//IF NO POSITION IS SELECTED
			if($('input[name="left_placement"]').is(':checked') == false && $('input[name="right_placement"]').is(':checked') == false){
				//0 = LEFT
				id_main_position = 3;
			}

		}

		if($('input[name="left_sponsor"]').is(':checked') == false && $('input[name="right_sponsor"]').is(':checked') == false &&
		$('input[name="left_placement"]').is(':checked') == false && $('input[name="right_placement"]').is(':checked') == false){
				//0 = LEFT
				id_main_position = 4;
		}


		if($('input[name="left_placement"]').is(':checked') == true || $('input[name="right_placement"]').is(':checked') == true){
			//0 = LEFT
			//IF ONE IS SELECTED
			if(id_acc_replacement == ''){//CHECK FOR REPLACEMENT ACCOUNT
				swal("Please select replacement account #","","error");
				return false;
			}else{
				if($('input[name="left_placement"]').is(':checked')){
				//0 = LEFT
				id_main_position = 0;
				}else{
					//0 = RIGHT
					id_main_position = 1;
				}
			}
		}


		if(id_set_membership_type == '' || last_name == '' || first_name == ''|| middle_name == '' || bday == '' ||
		id_main_gender == '' || id_main_civil_status == '' || contact == ''){//DATA VALIDATION
			swal("Please complete all the required fields in the application form","","error");
		}else{//BINARY SYSTEM VALIDATION

			if(contact.length != 15){
				swal("Mobile number should be 11 digits","","error");	
			}else{
				
				if(id_acc_recruiter == ''){//CHECK FOR SPONSOR ACCOUNT
					swal("Please select sponsor account #","","error");
				}else if(sponsor_flag == '1' && id_acc_replacement == ''){//CHECK FOR REPLACEMENT ACCOUNT
					swal("Please select replacement account #","","error");
				}else{//TRANSFER OF DATA TO CONTROLLER FOR SAVING
					if((id_main_position == '2' || id_main_position == '4') && (if_have_placement == 0 || if_have_placement == '')){
						swal("Select sponsor account if left or right","","error");
					}else if(id_main_position == '4'  && if_have_placement == 1 ){
						swal("Select sponsor or replacement account if left or right","","error");
					}else if(id_main_position == '4'  && if_have_placement == 3 ){
						swal("Select  replacement account if left or right","","error");
					}else if(id_main_position == '2' && if_have_placement == 1 ){
						swal("Please select replacement account","","error");
					}else if(id_main_position == '3'){
						swal("Select replacement's account if left or right","","error");
					}else{ 

						if(<?= $ref_code?> != '1001'){
						// alert(id_acc_recruiter+' | '+id_acc_replacement+' | '+ id_main_position);
						if(id_acc_recruiter  != '' && id_acc_replacement != ''){
							if(id_main_position == '4'){//IF ALL CHECKBOX IS UNCHECKED
								swal("Please check sponsor/replacement left and right","","error");
								return false;
							}
						}
					
						if(id_acc_replacement != ''){
							if(id_main_position == '3' || id_main_position == '4'){//IF ALL CHECKBOX IS UNCHECKED
								swal("Please check replacement left and right","","error");
								return false;
							}
						}
						
						//--------------------------------------------------------------
						}
						

						var is_replacement_blank = '';// VALUE MUST BE 1/0 : IF 1 TRUE
						var is_there_pairing = '';// VALUE MUST BE 1/0 : IF 1 TRUE

						if(id_acc_replacement == ''){// CHECK IF THERE IS A REPLACEMENT
							is_replacement_blank = 0;
							// alert("is_replacement_blank: 0");
							if(
								($('input[name="left_sponsor"]').is(':checked') && $("#right_sponsor").is('[disabled]')) ||
								($('input[name="right_sponsor"]').is(':checked') && $("#left_sponsor").is('[disabled]')) 
							){
								is_there_pairing = 1;
								// alert("is_there_pairing: 1");
							}else{
								is_there_pairing = 0;
								// alert("is_there_pairing: 0");
							}
						}else{
							is_replacement_blank = 1;
							// alert("is_replacement_blank: 1");
							if(
								($('input[name="left_placement"]').is(':checked') && $("#right_placement").is('[disabled]')) ||
								($('input[name="right_placement"]').is(':checked') && $("#left_placement").is('[disabled]')) 
							){
								is_there_pairing = 1;
								// alert("is_there_pairing: 1");
							}else{
								is_there_pairing = 0;
								// alert("is_there_pairing: 0");
							}
						}
					
						swal({
						title: "Are you sure?",
						text: "You want to save this account?",
						icon: "warning",
						buttons: [
							'No, cancel it!',
							'Yes, I am sure!'
						],
						successMode: true,
						}).then(function(isConfirm) {
						if (isConfirm) {

							var check_transaction = <?= $this->uri->segment('3')?>;
							if(check_transaction == 0){//SAVE
								
								// var url = 'controller/register_account'; BEFORE ALTERNATIVE
								var url = '<?php echo base_url()?>controller/register_account_alternative';

								swal('Account was Created Successfully',"","success");
								var title = 'Account was Created Successfully';
							}else{//UPDATE
								var url = '<?php echo base_url()?>controller/update_account/<?= $this->uri->segment('3')?>';
								swal('Account was Updated Successfully',"","success");
								var title = 'Account was Updated Successfully';
							}
							
							let p = new Promise((resolve,reject) => {
								$.ajax({
									type: 'ajax',
									method: 'post',
									url: url,
									data:{
										id_main:get_self_account,
										id_set_membership_type:id_set_membership_type,
										membership_type_amount:membership_type_amount,
										membership_type_commission:membership_type_commission,
										membership_type_pairing:membership_type_pairing,
										reference_nos:reference_nos,
										last_name:last_name,
										first_name:first_name,
										middle_name:middle_name,
										id_main_address_province:id_main_address_province,
										id_main_address_city:id_main_address_city,
										id_main_address_barangay:id_main_address_barangay,
										bday:bday,
										bplace:bplace,
										id_main_gender:id_main_gender,
										id_main_civil_status:id_main_civil_status,
										contact:contact,
										email:email,
										sss:sss,
										tin:tin,
										occupation:occupation,
										spouse:spouse,
										spouse_contact:spouse_contact,
										id_acc_recruiter:id_acc_recruiter,
										id_acc_replacement:id_acc_replacement,
										id_main_position:id_main_position,
										row:sponsor_row,
										is_replacement_blank:is_replacement_blank,
										is_there_pairing:is_there_pairing,
										data_pairing:data_pairing
										},
									// async: false,
									dataType: 'text',
									success: function(response){
										//window.location.href="controller/account_management";
										last_id = response;
										resolve(last_id);
									
									},
									error: function(){
										swal('Something went wrong');
									}
								});
							})



							swal({
							title: title,
							text: '',
							icon: 'success'
							}).then(function() {
								//RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
								
								p.then((response) =>{
									window.location.href="<?= base_url()?>controller/view_account/"+response+"/<?= date("Y-m-d")?>";
								})
								// setTimeout(function(){
								// 
								// }, 800);
								
							});
							
						} else {
							swal("Cancelled", "", "error");
						}
						})
					}
				}//TRANSFER OF DATA TO CONTROLLER FOR SAVING
			}//END OF CONTACT NUMBER VALIDATION

		}//BINARY SYSTEM VALIDATION
	}


	
})


</script>
