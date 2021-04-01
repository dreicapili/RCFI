<div class="card">
  <div class="card-header">
    <div class="d-flex align-items-center">
      <h4 class="card-title">ACCOUNTS GENEALOGY</h4>
      <h4 class="text-warning ml-auto">₱ <?= number_format($weekly_income,2)?></h4>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="multi-filter-select" class="display table table-striped table-hover" >
        <thead>
          <tr>
            <th>Recruit</th>
            <th>Sponsor</th>
            <th>Replacement</th>
            <th>Position</th>
            <th>Date/Time</th>
          </tr>
        </thead>
        <tbody id="table_tbody_for_append">
          <?php if(isset($query_account_genealogy)){?>
            <?php foreach($query_account_genealogy as $table_row) :?>
            <tr>
              <td><?= $table_row->recruit_name?></td>
              <td><?= $table_row->sponsor?></td>
              <td><?= $table_row->replacement?></td>
              <td><?= $table_row->position?></td>
              <td> <?= $table_row->dt?></td>
      
            </tr>
            <?php endforeach ?>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>