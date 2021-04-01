<div class="card">
  <div class="card-header">
    <div class="d-flex align-items-center">
      <h4 class="card-title">LIST OF INCOME</h4>
      <h4 class="text-warning ml-auto">₱ <?= number_format($weekly_income,2)?></h4>

    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="multi-filter-select" class="display table table-striped table-hover" >
        <thead>
          <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="table_tbody_for_append">
          <?php if(isset($query_weekly_income_list)){?>
            <?php foreach($query_weekly_income_list as $table_row) :?>
            <tr>
              <td><?= $table_row->dt?></td>
              <td><?= $table_row->type?></td>
              <td><?= number_format( $table_row->cash,2)?></td>
            </tr>
            <?php endforeach ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>