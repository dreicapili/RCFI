<div class="table-responsive">
  <table id="multi-filter-select2" class="display table table-striped table-hover" >
    <thead>
      <tr>
        <th hidden>Id main</th>
        <th>
        <div class="form-check">
              <label class="form-check-label">
                <input  class="form-check-input" id="chk_select_all" type="checkbox" value="">
                <span class="form-check-sign">  Status (Paid/Not Paid)</span>
              </label>
            </div>

        </th>
        <th>Reference #</th>
        <th>Name</th>
        <th>Account Flushout</th>
        <th>Account Income</th>
        
      </tr>
    </thead>
    <tbody id="table_tbody_for_append1">
      <?php
      $_SESSION['cutoff_flushout_overall'] = 0;
      $_SESSION['cutoff_flushout_paid'] = 0;
      if(isset($query_weekly_income_list)){?>
        <?php foreach($query_weekly_income_list as $table_row) :?>

        <?php
        $flushout = '';
        $flushout_money = '';
        $query2 = $this->db->query("CALL flushout_by_account($table_row->id_main,'$get_tuesday','$get_monday')");
        mysqli_next_result($this->db->conn_id);
        // die($this->db->last_query());
        if($query2->num_rows() > 0){
          foreach($query2->result() as $row2){
            $flushout = $row2->flushout;
            $flushout_money = $row2->flushout_money;
          }
        }
        ?>
        <tr>
          <td hidden><?= $table_row->id_main?></td>
          <td>
            <?php if($table_row->pay_status == 1){
                $checked = 'checked';
                $check_text = 'Paid';
            }else{
                $checked = '';
                $check_text = 'No Payment';
            }
            ?>

            <div class="form-check">
              <label class="form-check-label">
                <input <?= $checked?> name="chk_pay<?= $table_row->id_main?>" onclick="chk_pay(<?= $table_row->id_main?>)" class="form-check-input" type="checkbox" value="">
                <span class="form-check-sign togglePay" id="chk_pay<?= $table_row->id_main?>"><?= $check_text?></span>
              </label>
            </div>
          </td>
          <td><?= $table_row->reference_nos?></td>
          <td><a target="_blank" href="<?= base_url()?>controller/view_account/<?= $table_row->id_main?>/<?= $get_friday?>"><?= $table_row->name?></a></td>
          
          <td>
          <?php
          
           if(empty($row2->pairing_count)){
            $row2->pairing_count = 0;
           }
           if($row2->pairing_count > $row2->setting){
             echo $flushout .' - ('.number_format($flushout_money,2).')';
             $tots_weekly_income = $table_row->weekly_income - $flushout_money;
             $_SESSION['cutoff_flushout_overall'] = $_SESSION['cutoff_flushout_overall'] + $flushout_money;
             $_SESSION['cutoff_flushout_paid'] = ($_SESSION['cutoff_flushout_paid'] + $tots_weekly_income) - $flushout_money;
             
            // $tots_weekly_income = $table_row->weekly_income;
           }else{
             echo 'N/A';
             $tots_weekly_income = $table_row->weekly_income;
           }
          ?>
          </td>
          <td><button onclick="get_cutoff_details_by_account(<?= $table_row->id_main?>)" class="btn btn-primary" style="width:140px"> ₱ <?= number_format($tots_weekly_income,2)?> </button></td>
        </tr>
        <?php endforeach ?>
      <?php } ?>
    </tbody>
  </table>
</div>