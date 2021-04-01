<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

		<div id="loader-wrapper">
				<div id="loader"></div>
		
				<div class="loader-section section-left"></div>
				<div class="loader-section section-right"></div>
		
		</div>

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">HOME</h4>
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
								<a href="<?= base_url()?>controller/account_management">ACCOUNT MANAGEMENT</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#">GIFT CHECK</a>
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

						<div class="col-md-12">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#home" id="btn_current_data">DETAILED</a>
								</li>
								<li class="nav-item">
									<a  class="nav-link" data-toggle="tab" href="#summary" id="btn_past_data">SUMMARY</a>
								</li>
							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<div id="home" class=" tab-pane active" ><br>
									<div class="card">
										<div class="card-header">
											<div class="d-flex align-items-center">
												<h4 class="card-title ">Data fetch between: 
                        <span class="text text-warning"><?=  date("(l)  F j, Y", strtotime($get_tuesday))?> - <?=  date("(l)  F j, Y", strtotime($get_monday))?></span></h4>
                        
												<button id="btn_redeem" class="btn btn-warning ml-auto btn-md">
													<i class="fa fa-gift"></i> Redeem GC
                        </button>
                        
											</div>
										</div>
										<div class="card-body">
											<?php $this->load->view('dashboard/tables/gift-check-main-tables.php')?>

										</div>
									</div>
								</div>
								<div id="summary" class=" tab-pane fade"><br>
									<?php $this->load->view('dashboard/includes/gc-box-summary.php')?>
								</div>
							</div>
						</div>


						</div>
					</div>

				</div>
			</div>


	

    <!-- Modal Cut off -->
    <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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



<!-- MODAL -->
<?php $this->load->view('dashboard/template/preloading.php')?>
<?php $this->load->view('dashboard/modal/gc-account-summary-modal.php')?>
<?php $this->load->view('dashboard/modal/gc-redeem-modal.php')?>

		
<!-- FOOTER -->
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/money_format.php')?>

<script>

//PRELOADING
$(document).ready(function(){
  $('body').addClass('loaded');
  $('h1').css('color','#222222');	
});

$("#btn_redeem").click(function(){
  $('#addRowModal_redeem').modal('show');
  $('#addRowModal_redeem').find('.modal-title').text('REDEEM GC');
})


function get_cutoff_details_by_account(id_main){
    $('#addRowModal_cutoff').modal('show');
    $('#addRowModal_cutoff').find('.modal-title').text('GIFT CHECK DETAILS');

    $.ajax({
			type: 'ajax',
			method: 'post',
			url: '<?php echo base_url()?>controller/report_gc_by_account',
			data:{
				id_main:id_main,
				date_from:'<?= $get_tuesday?>',
				date_to:'<?= $get_monday?>'
				},
			// async: false,
			dataType: 'text',
			success: function(response){
				var data = JSON.parse(response);
				var i;
				$("#table_tbody_for_append3").html('');
				 moment();
				for(i=0; i<data.length; i++){
					$("#table_tbody_for_append3").append(
							'<tr>'+
									'<td>'+data[i].account+'</td>'+
									'<td>'+ moment(data[i].dt).format('MMMM Do YYYY, h:mm:ss a')+'</td>'+
									'<td>1</td>'+
									'<td>'+data[i].pay_status+'</td>'+
							'</tr>'
					);
				}
			},
			error: function(){
				swal('Something went wrong');
			}
    });
    
}


$(function(){

	
	$("#btn_redeem").click(function(){

			$.ajax({
				type: 'ajax',
				method: 'post',
				url: '<?php echo base_url()?>controller/cutoff_update_payment_multiple',
				data:{
					data_payment:data_payment,
					date_from_:'<?= $get_tuesday?>',
					date_to_:'<?= $get_monday?>'
					},
				// async: false,
				dataType: 'text',
				beforeSend: function(){
					// Show image container
					$('body').removeClass('loaded');
					$('body').addClass('load');

				},
				success: function(response){
					swal(response,'','success')
				},
				complete:function(data){
					// Hide image container
					$('body').removeClass('load');
					$('body').addClass('loaded');
					$('h1').css('color','#222222');	
					$("#btn_update").css('display','none');
					$("#chk_select_all").prop('checked',false);
					$(".togglePay").text('Paid');
				},
				error: function(){
					swal('Something went wrong');
				}
      });
      
	})

	$('#btnfilter').click(function(){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('SELECT CUTOFF');
		// $('#myForm').attr('action','<?php echo base_url() ?>customer/add_customer');
	});
    

	$("#btn_get_past_data").click(function(){
			var datepicker = $("#datepicker").val();
			if(datepicker == ''){
					swal('Please select date','','error');
			}else{
					window.location.href="<?= base_url()?>/controller/giftcheck/"+datepicker;
			}
			
	})

});


</script>


