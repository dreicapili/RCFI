<?php $this->load->view('dashboard/template/header.php')?>
<?php $this->load->view('dashboard/template/sidebar.php')?>

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					
					<!-- FILTERS -->
					<?php $this->load->view('dashboard/includes/index-filters.php')?>





					<div class="row">
						<div class="col-md-12">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs" role="tablist">

								<?php
								if(isset($report['report'])){
									if($report['report'] != ''){//MEANS SELECT ALL REPORT
										echo '<li class="nav-item">
														<a class="nav-link active" data-toggle="tab" href="#'.$report['report'].'" id="btn_current_data">'.$report['report'].'</a>
													</li>';
									}else{
										foreach($get_report as $table_row){
											if($table_row->setting == 'Gift Check'){
												$active = 'active';
											}else{
												$active = '';
											}
											echo '<li class="nav-item">
												<a class="nav-link '.$active.'" data-toggle="tab" href="#'.$table_row->setting.'" id="btn_current_data">'.$table_row->setting.'</a>
											</li>';
										}
									}
								}
								?>
								

							</ul>

							<!-- Tab panes -->
							<div class="tab-content">
								<?php
								$string = '';
								if(isset($report['report'])){

									if($report['report_type'] == 'Detail'){
										if($report['report'] != ''){ //MEANS SELECT ALL REPORT

											echo '
											<div id="'.$report['report'].'" class=" tab-pane active" ><br>
												<div class="card">
													<div class="card-header">
														<div class="d-flex align-items-center">
															<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
															<h4 class="text text-success ml-auto">'.$report['report'].'</h4>
														</div>
													</div>
													<div class="card-body">
		
														<div class="table-responsive">
														<table id="multi-filter-select2" class="display table table-striped table-hover" >
														'?>
														<?php
		
														if($report['report'] == 'Gift Check'){
															echo '
															<thead>
																<tr>
																	<th>Account</th>
																	<th>GC</th>
																	<th>Paid GC</th>
																	<th>Unpaid GC</th>
																</tr>
															</thead>
															<tbody>
																'.$report['report_tbody'].'
															</tbody>
															';
														}else if($report['report'] == 'Cutoff'){
															echo '
															<thead>
																<tr>
																	<th>Account</th>
																	<th>Income</th>
																	<th>Status</th>
																</tr>
															</thead>
															<tbody>
																'.$report['report_tbody'].'
															</tbody>
															';
														}
		
														?><?php
														echo '
														</table>
													</div>
												</div>
											</div>
											';
	
										}else{
											foreach($get_report as $table_row){
												if($table_row->setting == 'Gift Check'){
													echo '
													<div id="'.$table_row->setting.'" class=" tab-pane active" ><br>
														<div class="card">
															<div class="card-header">
																<div class="d-flex align-items-center">
																	<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
																	<h4 class="text text-success ml-auto">'.$table_row->setting.'</h4>
																</div>
															</div>
															<div class="card-body">
				
																<div class="table-responsive">
																	<table id="multi-filter-select2" class="display table table-striped table-hover" >
																	<thead>
																		<tr>
																			<th>Account</th>
																			<th>GC</th>
																			<th>Paid GC</th>
																			<th>Unpaid GC</th>
																		</tr>
																	</thead>
																	<tbody>
																		'.$report['report_all_gc'].'
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													';
												}else if($table_row->setting == 'Flushout'){
													echo '
													<div id="'.$table_row->setting.'" class=" tab-pane" ><br>
														<div class="card">
															<div class="card-header">
																<div class="d-flex align-items-center">
																	<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
																	<h4 class="text text-success ml-auto">'.$table_row->setting.'</h4>
																</div>
															</div>
															<div class="card-body">
				
																<div class="table-responsive">
																	<table id="multi-filter-select2" class="display table table-striped table-hover" >
																	<thead>
																		<tr>
																			<th>Account</th>
																			<th>Pairing</th>
																			<th>Flushout</th>
																		</tr>
																	</thead>
																	<tbody>
																		'.$report['report_all_flushout'].'
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													';
												}else if($table_row->setting == 'Cutoff'){
													echo '
													<div id="'.$table_row->setting.'" class=" tab-pane" ><br>
														<div class="card">
															<div class="card-header">
																<div class="d-flex align-items-center">
																	<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
																	<h4 class="text text-success ml-auto">'.$table_row->setting.'</h4>
																</div>
															</div>
															<div class="card-body">
				
																<div class="table-responsive">
																	<table id="multi-filter-select2" class="display table table-striped table-hover" >
																	<thead>
																		<tr>
																			<th>Account</th>
																			<th>Income</th>
																			<th>Status</th>
																		</tr>
																	</thead>
																	<tbody>
																		'.$report['report_all_cutoff'].'
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													';
												}else if($table_row->setting == 'Genealogy'){
													echo '
													<div id="'.$table_row->setting.'" class=" tab-pane" ><br>
														<div class="card">
															<div class="card-header">
																<div class="d-flex align-items-center">
																	<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
																	<h4 class="text text-success ml-auto">'.$table_row->setting.'</h4>
																</div>
															</div>
															<div class="card-body">
				
																<div class="table-responsive">
																	<table id="multi-filter-select2" class="display table table-striped table-hover" >
																	<thead>
																		<tr>
																			<th>Recruit</th>
																			<th>Sponsor</th>
																			<th>Replacement</th>
																			<th>Position</th>
																			<th>Date/Time</th>
																		</tr>
																	</thead>
																	<tbody>
																		'.$report['report_genealogy'].'
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													';
												}else if($table_row->setting == 'Left/Right'){
													echo '
													<div id="'.$table_row->setting.'" class=" tab-pane" ><br>
														<div class="card">
															<div class="card-header">
																<div class="d-flex align-items-center">
																	<h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
																	<h4 class="text text-success ml-auto">'.$table_row->setting.'</h4>
																</div>
															</div>
															<div class="card-body">
				
																<div class="table-responsive">
																	<table id="multi-filter-select2" class="display table table-striped table-hover" >
																	<thead>
																		<tr>
																			<th>Account</th>
																			<th>Left</th>
																			<th>Right</th>
																		</tr>
																	</thead>
																	<tbody>
																		'.$report['report_left_right'].'
																	</tbody>
																	</table>
																</div>
															</div>
														</div>
													</div>
													';
												}
											}//END OF FOREACH NI DETAIL, ALL REPORT
										}
									}else{//SUMMARY ----------------------------------------------------------------------------------------------------------------------
										if($report['report'] != ''){ //MEANS SELECT SPECIFIC REPORT

										}else{
											$this->load->view('dashboard/includes/index-report-summary.php');
										}
									}
								}
								?>
								
								
							
							</div>
						</div>




					</div>
				</div>
			</div>

		<!-- CUTOFF MODAL -->
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
										<table id="multi-filter-select11" class="display table table-striped table-hover" >
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

	//PREVENT PRE LOADING TO LOAD


	$(document).ready(function(){
		$('body').addClass('loaded');
		$('h1').css('color','#222222');	
	});

	$("#report_type").val('<?php echo isset($report['report_type']) ? $report['report_type'] :''?>');
	$("#report").val('<?php echo isset($report['report']) ? $report['report'] : ''?>');
	$("#account").val('<?php echo isset($report['account']) ? $report['account'] : ''?>');

	function get_cutoff_details_by_account(id_main){
    $('#addRowModal_cutoff').modal('show');
		$('#addRowModal_cutoff').find('.modal-title').text('PAYOUT DETAILS');
		
		var date_from = $("#date_from").val();
		var date_to = $("#date_to").val();

    $.ajax({
			type: 'ajax',
			method: 'post',
			url: '<?php echo base_url()?>controller/report_income_account_list',
			data:{
				id_main:id_main,
				date_from: date_from,
				date_to: date_to
				},
			// async: false,
			dataType: 'text',
			success: function(response){
				// console.log(response);
				var data = JSON.parse(response);
				var i;
				$("#table_tbody_for_append3").html('');
				 moment();
				for(i=0; i<data.length; i++){
					$("#table_tbody_for_append3").append(
							'<tr>'+
									'<td>'+data[i].account+'</td>'+
									'<td>'+ moment(data[i].dt).format('MMMM Do YYYY, h:mm:ss a')+'</td>'+
									'<td>'+data[i].type+'</td>'+
									'<td>'+formatCurrency(data[i].cash)+'</td>'+
							'</tr>'
					);
				}
			},
			error: function(){
				swal('Something went wrong');
			}
    });
    
}

</script>


