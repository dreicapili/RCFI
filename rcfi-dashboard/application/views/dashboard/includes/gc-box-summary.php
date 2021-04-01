<div class="row">
  <div class="col-md-6">
    <div class="card card-dark bg-primary-gradient">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-right"><i class="fas fa-users"></i></div>
        <h2 class="mb-2"> <?= $number_of_account?></h2>
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
        <h2 class="mb-2"> <?= $number_of_gc ?></h2>
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
        <h2 class="mb-2"><?= $paid_gc ?></h2>
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
        <h2 class="mb-2"><?= $unpaid_gc ?></h2>
        <p class="uppercase">Unpaid Gift Check</p>
        <p class="sub-p">Bilang nang hindi pa nabibigyan nang Gift Check</p>
        <div class="pull-in sparkline-fix chart-as-background">
          <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
        </div>
      </div>
    </div>
  </div>
 
</div>