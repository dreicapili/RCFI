<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

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
								<a href="<?= base_url()?>controller/account_management">FLUSH-OUT</a>
							</li>
						</ul>
					</div>


					<div class="row">
						

						<div class="col-md-3">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title uppercase">FILTER'S</h4>
                  </div>
                </div>
                <div class="card-body">
                  <div class="">
                      <label>ACCOUNT</label>
                      <select name="id_main" id="id_main" class="form-control form-control-sm">
                      <option value="">All</option>
                      <?php foreach($registered_accounts as $table_row) :?>		
											  <option value="<?= $table_row->id_registration?>"><?= $table_row->reference_nos?> - <?= $table_row->last_name?>, <?= $table_row->first_name?> <?= $table_row->middle_name?></option>
											<?php endforeach ?>
                      </select>
                  </div>
                  <div class="mt-3">
                      <label>FROM</label>
                      <input  type="date" id="date_from" name="date_from"  class="form-control form-control-sm"
                      value="<?= date('Y-m-d')?>">
                  </div>
                  <div class="mt-3">
                      <label>TO</label>
                      <input  type="date" id="date_to" name="date_to"  class="form-control form-control-sm"
                      value="<?= date('Y-m-d')?>">
                  </div>
                  <button class="btn btn-primary btn-block mt-3" id="btn_flushout"><i class="fa fa-search"></i> Search</button>
                </div>
              </div>
            </div>

						<div class="col-md-9">
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
                      <h4 class="card-title uppercase">Flusout Summary</h4>
											<button id="btn_update" class="btn btn-primary ml-auto btn-md jrey-display-none">
                         <i class="fa fa-edit"></i> Update Payment
                      </button>
										</div>
									</div>
									<div class="card-body">
										<?php $this->load->view('dashboard/tables/flushout-main-table.php')?>

									</div>
								</div>
							</div>
							<div id="summary" class=" tab-pane fade"><br>
								<?php $this->load->view('dashboard/includes/flushout-box-summary.php')?>
							</div>
						</div>
						</div>


						</div>
					</div>

				</div>
			</div>


    <!-- Modal Cutoff Details -->
    <div class="modal fade" id="addRowModal_cutoff" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
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
                    <div class="modal-body" >
                       
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover" >
                                <thead>
                                    <tr>
                                        <th>Account</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="table_tbody_for_append3">
                                   
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- <div class="modal-footer no-bd" style="background-color:#202940">
                        <button type="submit" id="btn_get_past_data"  class="btn btn-primary btn-sm">GET DATA</button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
                    </div> -->
                </div>
            </div>
        </div>

		

<?php $this->load->view('dashboard/template/preloading.php')?>
<?php $this->load->view('dashboard/template/footer.php')?>
<?php $this->load->view('dashboard/class/money_format.php')?>

<script>

//PRELOADING
$(document).ready(function(){
  $('body').addClass('loaded');
  $('h1').css('color','#222222');	
});





$('#btnfilter').click(function(){
  $('#addRowModal').modal('show');
  $('#addRowModal').find('.modal-title').text('FILTER');
  // $('#myForm').attr('action','<?php echo base_url() ?>customer/add_customer');
});

$("#btn_flushout").click(function(){
  var date_from = $("#date_from").val();
  var date_to = $("#date_to").val();
  var id_main = $("#id_main").val();
  
  if(date_from == '' || date_to == ''){
    swal("Select date first!",'','error');
  }else{
    $.ajax({
      type: 'ajax',
      method: 'post',
      url: '<?php echo base_url()?>controller/flushout_data',
      data:{
        date_from:date_from,
        date_to:date_to,
        id_main:id_main
        },
      // async: false,
      dataType: 'text',
      beforeSend: function(){
        $('body').removeClass('loaded');
        $('body').addClass('load');
      },
      complete:function(data){
        $('body').removeClass('load');
        $('body').addClass('loaded');
        $('h1').css('color','#222222');	
      },
      success: function(response){
        var data = JSON.parse(response);
        var i = 0;
        var number_of_account = 0;
        var total_of_flushout = 0;
        // alert(data[0].pairing_count);
       
        if(data.length == 0){
          swal("No Flush-out Found","","info");
        }
        $("#table_tbody_for_append").html('');
        for(i=0;i<data.length;i++){
          if(parseInt(data[i].pairing_count) > data[i].setting){
            number_of_account = number_of_account + 1;
            total_of_flushout = total_of_flushout + parseFloat(data[i].flushout_money);
            // alert(data[i].membership_type_pairing);
            $("#table_tbody_for_append").append(
              '<tr>'+
                '<td>'+ data[i].name +'</td>'+
                // '<td>'+ data[0].gift_check +'</td>'+
                '<td>'+ data[i].pairing_count +' - (₱'+ formatCurrency((data[i].pairing_money - data[i].gc) + (data[i].gc * data[i].membership_type_pairing)) +')</td>'+
                '<td>'+ data[i].flushout +' - (₱'+ formatCurrency(data[i].flushout_money) +')</td>'+
              '<tr>'
            );
          }
        }
        $("#number_of_account").text(number_of_account);
        $("#total_of_flushout").text("₱ "+formatCurrency(total_of_flushout));
        // swal(response,'','success')
      },
      error: function(){
        swal('Something went wrong');
      }
    });
  }

})

</script>


