<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Home</h4>
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
								<a href="#">View Account</a>
							</li>
						</ul>
					</div>

					<div class="row">

						<div class="col-md-12">
							<div class="alert alert-primary" role="alert">
								<span class="uppercase">Cutoff Period:</span> <a href="#" title="Click me to change cutoff" id="btnfilter">
								<?=  date("(l)  F j, Y", strtotime($get_friday))?></a>
								<!-- <button id="btnfilter" class="btn btn-warning ml-auto">
									Filter
								</button> -->
							</div>
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
					</div>

				

					<div class="row">

						<div class="col-md-3">
							<div class="card card-profile">
								<div class="card-header" style="background-image: url('<?= base_url()?>public/assets/img/blogpost.jpg')">
									<div class="profile-picture">
										<div class="avatar avatar-xl" >

										<th><img id="btn_update_dp" src="<?= base_url()?>public/uploads/dp/<?php echo empty($pic) ? 'default_pic.png' : $pic ?>" style="border-radius:50%" width="100" height="100" alt=""></th>

										</div>
									</div>
								</div>
								<div class="card-body">
									<div class="user-profile text-center">
										<div class="name"><?= $reference_nos?></div>
										<div class="job"><?= $name?></div>
										<div class="social-media">

										
										</div>
										<div class="view-profile">
											<a href="#" id="btnAdd" class="btn btn-secondary btn-block">View Full Profile</a>
										</div>
									</div>
								</div>
								<div class="card-footer">
									<div class="row user-stats text-center">
										<div class="col">
											<div class="h1"><?= $leftRight['left']?></div>
											<div class="title">Left</div>
										</div>
										<div class="col">
											<div class="h1"><?= $leftRight['right']?> </div>
											<div class="title">Right</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-md-9">
						<!-- Nav tabs -->
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#home">Account Genealogy</a>
							</li>
							<li class="nav-item">
								<a  class="nav-link" data-toggle="tab" href="#menu1">Income</a>
							</li>
							<li class="nav-item">
								<a  class="nav-link" data-toggle="tab" href="#account_summary">Account Summary</a>
							</li>
						</ul>

						<!-- Tab panes -->
						<div class="tab-content">
							<div id="home" class=" tab-pane active" ><br>
								<?php $this->load->view('dashboard/tables/account-genealogy-table.php')?>
							</div>
							<div id="menu1" class=" tab-pane fade"><br>
								<?php $this->load->view('dashboard/tables/account-income-table.php')?>
							</div>
							<div id="account_summary" class=" tab-pane fade"><br>
							<?php $this->load->view('dashboard/includes/account-box-summary.php')?>
							</div>
						</div>
						</div>


						</div>
					</div>

				</div>
			</div>



		<form method="POST" id="myForm"  action="<?= base_url()?>/controller/update_account/<?= $this->uri->segment('3')?>">
        <!-- Modal -->
        <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
						<div class="modal-body" style="background-color:#202940">
							<p class="small">Fill out the form and click save to save the company details.</p>
							<div class="row">

							<div class="col-sm-4">
									<div class="form-group">
										<span>*Type of Membership</span>
										<input readonly type="text" class="form-control  form-control-sm" placeholder="0.00" 
										value="<?= $type?>" >	
										<input type="hidden" name="id_main" id="id_main" class="form-control  form-control-sm" placeholder="0.00" 
										value="<?= $id_main?>" >		
									</div>
								</div>
								<div class="col-sm-4" id="fetch_mem_type_amount">
									<div class="form-group ">
										<span>*Amount</span>
										<input readonly type="text" class="form-control  form-control-sm" placeholder="0.00" 
										value="<?= $cash?>" required>
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Reference Number</span>
										<input readonly type="text" class="form-control  form-control-sm"
										value="<?php echo isset($reference_nos) ? $reference_nos : '#'.$ref_code?>" placeholder="Reference number ">
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
                                            <select  class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
											onchange="select_city(this.value)" id="main_address_province" name="main_address_province">
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
                                            <select class="form-control form-control-sm" id="main_address_city" onchange="select_barangay(this.value)" name="main_address_city">
                                                <option value="">select province first</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group span">
                                        <span>*Barangay</span>
                                        <div id="get_barangay_list">
                                            <select class="form-control form-control-sm" id="main_address_barangay" name="main_address_barangay">
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
										value="<?php echo isset($bday) ? $bday : ''?>" >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>Birth Place</span>
										<input  type="text" name="bplace" id="bplace"  class="form-control form-control-sm" placeholder="Input birth place"
										value="<?php echo isset($last_name) ? $last_name : ''?>" >
									</div>
								</div>
								<div class="col-sm-4">
									<div class="form-group">
										<span>*Gender</span>
										<select class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
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
										<select class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
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
										<input  type="text" name="spouse_contact" id="spouse_contact"  class="form-control form-control-sm" placeholder=""
										value="<?php echo isset($spouse_contact) ? $spouse_contact : ''?>" >
                                    </div>
                                </div>
		
							</div>
						</div>
						<div class="modal-footer no-bd" style="background-color:#202940">
							<button type="submit" id="btnSaveEdit" class="btn btn-primary btn-sm">Save Changes</button>
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</form>


		<form method="POST" id="myForm" enctype="multipart/form-data" action="<?= base_url()?>/controller/add_profile_picture/<?= $this->uri->segment('3')?>">
        <!-- Modal -->
        <div class="modal fade" id="addRowModal_update_dp" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
						<div class="modal-body" style="background-color:#202940">
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group form-group-default">
										<label>Account DP</label>
										<input type="file" name="files[]" class="form-control form-control-sm" accept="image/*"  />
										<input type="hidden" class="form-control form-control-sm" id="picture" name="picture"> 
										<input type="hidden" name="id_main" id="id_main" class="form-control  form-control-sm" placeholder="0.00" 
											value="<?= $id_main?>" >	
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer no-bd" style="background-color:#202940">
							<button type="submit"  class="btn btn-primary btn-sm">Save Changes</button>
							<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
		</form>



		<!-- Modal Cut off -->
		<div class="modal fade" id="addRowModal_filter" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
          <div class="modal-body" style="background-color:#202940">
              <div class="row">
                  <div class="col-sm-12">
                      <div class="form-group form-group-default">
                          <label>Select Date</label>
                          <input  type="date" id="datepicker" name="datepicker"  class="form-control form-control-sm">
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer no-bd" style="background-color:#202940">
              <button type="submit" id="btn_get_past_data"  class="btn btn-primary btn-sm">GET DATA</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>

		
<?php $this->load->view('dashboard/template/preloading.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>

<script>



//PRELOADING
$(document).ready(function(){
  $('body').addClass('loaded');
  $('h1').css('color','#222222');	
});

<?php  
if($this->session->userdata('acctg_msg')){
?>
	swal('New account was registered successfullly','','success');
<?php
unset($_SESSION['acctg_msg']);	
unset($_SESSION['acctg_msg_type']);	
}
?>

$(function(){

	$('#btnAdd').click(function(){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Update Account');
		// $('#myForm').attr('action','<?php echo base_url() ?>customer/add_customer');
	});

	$('#btn_update_dp').click(function(){
		$('#addRowModal_update_dp').modal('show');
		$('#addRowModal_update_dp').find('.modal-title').text('Update Account Picture');
		// $('#myForm').attr('action','<?php echo base_url() ?>customer/add_customer');
	});

});

$('#btnfilter').click(function(){
	$('#addRowModal_filter').modal('show');
	$('#addRowModal_filter').find('.modal-title').text('SELECT CUTOFF');
	// $('#myForm').attr('action','<?php echo base_url() ?>customer/add_customer');
});

$("#btn_get_past_data").click(function(){
	var datepicker = $("#datepicker").val();
	if(datepicker == ''){
			swal('Please select date','','error');
	}else{
			window.location.href="<?= base_url()?>/controller/view_account/<?= $this->uri->segment('3')?>/"+datepicker;
	}
})

//VALUE OF COMBO BOX
$("#main_address_province").val('<?= $id_main_address_province?>');
$("#id_main_gender").val('<?= $id_main_gender?>');
$("#id_main_civil_status").val('<?= $id_main_civil_status?>');
select_city();
select_barangay(<?= $id_main_address_city?>);

//ADDRESS MANAGEMENT
function select_city(){
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
			$("#main_address_city").val(<?php echo isset($id_main_address_city) ?$id_main_address_city : ''?>);
		},
		error: function(){
			swal('Something went wrong');
		}
	});
}

function select_barangay(main_address_city){
	
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
			$("#main_address_barangay").val(<?php echo isset($id_main_address_barangay) ?$id_main_address_barangay : ''?>);

		},
		error: function(){
			swal('Something went wrong');
		}
	});
}
//ADDRESS MANAGEMENT

</script>


