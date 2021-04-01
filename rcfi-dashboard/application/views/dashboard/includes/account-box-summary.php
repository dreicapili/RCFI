<div class="row">
  <div class="col-md-4">
    <div class="card card-dark bg-primary-gradient">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-right"><i class="fas fa-money-bill"></i></div>
        <h2 class="mb-2">₱ <?= number_format($weekly_income,2)?></h2>
        <p>Weekly Income</p>
        <div class="pull-in sparkline-fix chart-as-background">
          <div id="lineChart"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card card-dark bg-primary-gradient">
      <div class="card-body pb-0">
        <div class="h1 fw-bold float-right"><i class="fas fa-gift"></i></div>
        <h2 class="mb-2"><?= $gift_check?></h2>
        <p>Gift Check</p>
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
        <h2 class="mb-2">₱ <?= number_format($monthly_income,2)?></h2>
        <p>Monthly Income</p>
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
        <h2 class="mb-2">₱ <?= number_format($overall_income - $flushout_total_of_flushout,2)?></h2>
        <p>Overall Income</p>
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
        <h2 class="mb-2">₱ <?= number_format($flushout_total_of_flushout,2)?></h2>
        <p>Flushout</p>
        <div class="pull-in sparkline-fix chart-as-background">
          <div id="lineChart2"><canvas width="327" height="70" style="display: inline-block; width: 327px; height: 70px; vertical-align: top;"></canvas></div>
        </div>
      </div>
    </div>
  </div>
</div>