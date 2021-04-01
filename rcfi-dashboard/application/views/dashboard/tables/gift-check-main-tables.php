<div class="table-responsive">
  <table id="multi-filter-select2" class="display table table-striped table-hover" >
    <thead>
      <tr>
        <th>Account</th>
        <th>Total GC</th>
        <th>Paid GC</th>
        <th>Unpaid GC</th>
      </tr>
    </thead>
    <tbody id="table_tbody_for_append1">
      <?php
      $_SESSION['cutoff_flushout_overall'] = 0;
      $_SESSION['cutoff_flushout_paid'] = 0;
      if(isset($query_gc)){?>
        <?php foreach($query_gc as $table_row) :?>
        <tr>
          <td><?= $table_row->name?></td>
          <td><button onclick="get_cutoff_details_by_account(<?= $table_row->id_registration?>)" class="btn btn-primary" style="width:140px"> <?= $table_row->gc_count?> - GC</button></td>
          <td><?= $table_row->paid_gc?></td>
          <td><?= $table_row->unpaid_gc?></td>
        </tr>
        <?php endforeach ?>
      <?php } ?>
    </tbody>
  </table>
</div>