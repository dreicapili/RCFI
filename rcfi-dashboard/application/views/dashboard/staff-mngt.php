<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>


		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Staff Management</h4>
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
								<a href="#">Staff Management</a>
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
										<h4 class="card-title">Staff List</h4>
										<button id="btnAdd" class="btn btn-primary btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Add Staff
										</button>
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
												<?php foreach($get_staff_list as $table_row) :?>
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
                        <p class="small">Fill out the form and click save to save the staff.</p>             
                        <div class="row" id="data_for_edit">
                            <div class="col-md-12" id="error_msg">
                            </div>                       
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>First Name</label>
                                    <input  type="text" name="first_name" id="first_name" class="form-control" placeholder="First name"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Middle Name</label>
                                    <input  type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle name"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Last Name</label>
                                    <input  type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name"   required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Email</label>
                                    <input  type="email" name="email" id="email" class="form-control" placeholder="Email"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Mobile Number</label>
                                    <input  type="text" name="contact" maxlength="11" id="contact" class="form-control" placeholder="Mobile number"   required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Address</label>
                                    <input  type="text" name="address" id="address" class="form-control" placeholder="Address" required>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Username</label>
                                    <input  type="text" name="username" id="username" class="form-control" placeholder="Username"   required>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group form-group-default">
                                    <label>Password</label>
                                    <input  type="password" name="password" id="password" class="form-control" placeholder="Password"   required>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="modal-footer no-bd">
                        <button type="button" id="btnssave" class="btn btn-primary">Save</button>
                        <button type="submit" id="btnupdate" class="btn btn-primary jrey-display-none">Update</button>
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
    $('#addRowModal').find('.modal-title').text('Add Staff');
    $('#btnssave').css("display","block");
    $('#btnupdate').css("display","none");

    $("#first_name").val('');
    $("#middle_name").val('');
    $("#last_name").val('');
    $("#email").val('');
    $("#contact").val('');
    $("#address").val('');
    $("#username").val('');
    $("#password").val('');
});


$('#btnssave').click(function(){
    var contact = $('#contact').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var accounts_id = $('#accounts_id').val();
    var first_name = $('#first_name').val();
    var middle_name = $('#middle_name').val();
    var last_name = $('#last_name').val();
    var username = $('#username').val();
    var password = $('#password').val();

    if(contact == '' || email=='' || accounts_id == '' || first_name=='' || middle_name==''|| last_name=='' || username=='' || password == ''){
        swal('Please fill up all the required fields','','error');
    }else{

        if(contact.length != 11){
            swal('Make sure mobile number is 11 digit','','error');
        }else{
            if(!isEmail(email)){
                swal('Email Address not valid','','error');
            }else{

                var type = 1;

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '<?php echo base_url()?>controller/add_staff',
                    data:{
                        accounts_id:accounts_id,
                        first_name:first_name,
                        middle_name:middle_name,
                        last_name:last_name,
                        email:email,
                        contact:contact,
                        address:address,
                        username:username,
                        password:password,
                        type:type
                        },
                    async: false,
                    dataType: 'text',
                    success: function(response){
                        if(response == 'true'){
                            location.reload();
                        }else if(response == 'false'){
                            $('#error_msg').html(
                                '<div class="alert alert-danger" role="alert">'+
                                    'Maybe account id,mobile number,email is already used by the other account.'+
                            ' </div>'
                            );
                        }
                    
                    },
                    error: function(){
                        swal('Something went wrong');
                    }
                });

            
            
            }
        }

    }


});

function getEdit(id){
	$('#addRowModal').modal('show');
	$('#addRowModal').find('.modal-title').text('Edit');
    $('#myForm').attr('action','<?php echo base_url() ?>/controller/edit_staff/');
    $('#btnssave').css("display","none");
    $('#btnupdate').css("display","block");

    $.ajax({
			type: 'ajax',
			method: 'post',
			url: '<?= base_url()?>controller/for_edit_staff_data',
			data:{
				id_user:id
			},
			// async: false,
			dataType: 'text',
			success: function(response){
				var data1 = JSON.parse(response);
				var i;
				for(i=0; i < data1.length; i++){
					$('#data_for_edit').html(
                        '<div class="col-md-12" id="error_msg">'+
                        '</div>'+                       
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>First Name</label>'+
                                '<input  type="hidden" name="id_user" id="id_user" class="form-control" placeholder="First name" value="'+data1[i].id_user+'"  required>'+
                                '<input  type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" value="'+data1[i].first_name+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Middle Name</label>'+
                                '<input  type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle name" value="'+data1[i].middle_name+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Last Name</label>'+
                                '<input  type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" value="'+data1[i].last_name+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Email</label>'+
                                '<input  type="email" name="email" id="email" class="form-control" placeholder="Email" value="'+data1[i].email+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Mobile Number</label>'+
                                '<input  type="text" name="contact" maxlength="11" id="contact" class="form-control" placeholder="Mobile number" value="'+data1[i].contact+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Address</label>'+
                                '<input  type="text" name="address" id="address" class="form-control" placeholder="Address" value="'+data1[i].address+'" required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Username</label>'+
                                '<input  type="text" name="username" id="username" class="form-control" placeholder="Username" value="'+data1[i].username+'"  required>'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-sm-4">'+
                            '<div class="form-group form-group-default">'+
                                '<label>Password</label>'+
                                '<input  type="password" name="password" id="password" class="form-control" placeholder="Password" required>'+
                            '</div>'+
                        '</div>'
					);
				}
			},
			error: function(){
				swal('Something went wrong');
			}
		});
}


</script>