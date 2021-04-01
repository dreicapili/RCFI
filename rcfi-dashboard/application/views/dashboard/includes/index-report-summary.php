<?php

foreach($get_report as $table_row){
  if($table_row->setting == 'Gift Check'){
    echo '
    <div id="'. $table_row->setting.'" class=" tab-pane active" ><br>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
            <h4 class="text text-success ml-auto">'. $table_row->setting.'</h4>
          </div>
        </div>
        <div class="card-body">

        <div class="row">
          <div class="col-md-6">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                <h2 class="mb-2">'.$report['number_of_account'].'</h2>
                <p class="uppercase">Number of Account</p>
                <p class="sub-p">Count of Account na may Gift Check</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
                <h2 class="mb-2"> '.$report['number_of_gc'].'</h2>
                <p class="uppercase">Weekly Gift Check</p>
                <p class="sub-p">Total nang Gift Check</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
                <h2 class="mb-2">'.$report['paid_gc'].'</h2>
                <p class="uppercase">Paid Gift Check</p>
                <p class="sub-p">Bilang nang nabigyan na nang Gift Check</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
                <h2 class="mb-2">'.$report['unpaid_gc'].'</h2>
                <p class="uppercase">Unpaid Gift Check</p>
                <p class="sub-p">Bilang nang hindi pa nabibigyan nang Gift Check</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
        </div>



        </div>
      </div>
    </div>
    ';
  }//END OF IF

  if($table_row->setting == 'Flushout'){
    $flushout_number_of_account = 0;
    $flushout_total_of_flushout = 0;
    if(isset($report['flushout'])){
      foreach($report['flushout'] as $row_flushout){
        if($row_flushout->pairing_count > $row_flushout->setting){
          $flushout_number_of_account = $flushout_number_of_account + 1;
          $flushout_total_of_flushout =  $flushout_total_of_flushout + $row_flushout->flushout_money;
        }
      }
    }


    echo '
    <div id="'. $table_row->setting.'" class=" tab-pane " ><br>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
            <h4 class="text text-success ml-auto">'. $table_row->setting.'</h4>
          </div>
        </div>
        <div class="card-body">

          <div class="row">
            <div class="col-md-6">
              <div class="card card-dark bg-primary-gradient">
                <div class="card-body pb-0">
                  <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                  <h2 class="mb-2">'.$flushout_number_of_account.'</h2>
                  <p class="uppercase">Number of Account</p>
                  <p class="sub-p">Count nang account na may Flushout</p>
                  <div class="pull-in sparkline-fix chart-as-background">
                    <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card card-dark bg-primary-gradient">
                <div class="card-body pb-0">
                  <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                  <h2 class="mb-2">₱ '.number_format($flushout_total_of_flushout).'</h2>
                  <p>Total Flushout</p>
                  <p class="sub-p">Total nang flushout between date two range</p>
                  <div class="pull-in sparkline-fix chart-as-background">
                    <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                  </div>
                </div>
              </div>
            </div>
          </div>



        </div>
      </div>
    </div>
    ';
  }//END OF IF

  if($table_row->setting == 'Cutoff'){
    echo '
    <div id="'. $table_row->setting.'" class=" tab-pane" ><br>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
            <h4 class="text text-success ml-auto">'. $table_row->setting.'</h4>
          </div>
        </div>
        <div class="card-body">



        <div class="row">
          <div class="col-md-4">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                <h2 class="mb-2"> '.$report['cutoff_summary_overall']['number_of_account'].'</h2>
                <p class="uppercase">Number of Account</p>
                <p class="sub-p">Count of Account na babayadan</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                <h2 class="mb-2">'.$report['cutoff_summary_overall']['paid_account'].'</h2>
                <p>Paid Account</p>
                <p class="sub-p">Count of nabayadan nang account</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
                <h2 class="mb-2">'.$report['cutoff_summary_overall']['accounts_to_be_paid'].'</h2>
                <p class="uppercase">Accounts to be Paid</p>
                <p class="sub-p">Count of account na babayadan pa lang</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
                <h2 class="mb-2">₱ '.number_format($report['cutoff_summary_overall']['weekly_cutoff'] - $flushout_total_of_flushout,2).'</h2>
                <p class="uppercase">Weekly Cut-off</p>
                <p class="sub-p">Total nang cutoff</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card card-dark bg-primary-gradient">
              <div class="card-body pb-0">
                <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
                <h2 class="mb-2">₱ '.number_format($flushout_total_of_flushout,2).'</h2>
                <p class="uppercase">Flushout</p>
                <p class="sub-p">Total nang lahat nang flushout sa current cutoff</p>
                <div class="pull-in sparkline-fix chart-as-background">
                  <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
                </div>
              </div>
            </div>
          </div>
        
        </div>



        </div>
      </div>
    </div>
    ';
  }//END OF IF

  if($table_row->setting == 'Genealogy'){

    echo '
    <div id="'. $table_row->setting.'" class=" tab-pane " ><br>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
            <h4 class="text text-success ml-auto">'. $table_row->setting.'</h4>
          </div>
        </div>
        <div class="card-body">

        Not Available



        </div>
      </div>
    </div>
    ';
  }//END OF IF

  if($table_row->setting == 'Left/Right'){

    echo '
    <div id="'. $table_row->setting.'" class=" tab-pane " ><br>
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">Data Fetch Between <span class="text text-warning">'.date(" F j, Y", strtotime($report['date_from'])).' - '.date("F j, Y", strtotime($report['date_to'])).'</span></h4>
            <h4 class="text text-success ml-auto">'. $table_row->setting.'</h4>
          </div>
        </div>
        <div class="card-body">

        Not Available



        </div>
      </div>
    </div>
    ';
  }//END OF IF


}//END OF FOREACH NI DETAIL, ALL REPORT
?>

