<div class="row">
  <div class="col-md-4">
    <div class="card card-dark bg-primary-gradient">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
        <h2 class="mb-2"> <?= $cutoff_summary_overall['number_of_account']?></h2>
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
        <h2 class="mb-2"><?= $cutoff_summary_overall['paid_account']?></h2>
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
        <h2 class="mb-2"><?= $cutoff_summary_overall['accounts_to_be_paid']?></h2>
        <p class="uppercase">Account's to be Paid</p>
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
        <h2 class="mb-2">₱ <?= number_format($cutoff_summary_overall['weekly_cutoff'] - $_SESSION['cutoff_flushout_overall'],2)?></h2>
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
        <h2 class="mb-2">₱ <?= number_format($_SESSION['cutoff_flushout_paid'],2)?></h2>
        <p class="uppercase">Paid</p>
        <p class="sub-p">Total nang nabayadan na</p>
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
        <h2 class="mb-2">₱ <?= number_format($cutoff_summary_overall['weekly_cutoff'] - $_SESSION['cutoff_flushout_paid'],2)?></h2>
        <p class="uppercase">Pending</p>
        <p class="sub-p">Total nang babayadan pa lang</p>
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
        <h2 class="mb-2">₱ <?= number_format($_SESSION['cutoff_flushout_overall'],2)?></h2>
        <p class="uppercase">Flushout</p>
        <p class="sub-p">Total nang lahat nang flushout sa current cutoff</p>
        <div class="pull-in sparkline-fix chart-as-background">
          <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
        </div>
      </div>
    </div>
  </div>
 
</div>