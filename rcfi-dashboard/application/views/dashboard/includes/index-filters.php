<form method="POST" action="<?= base_url()?>/user/">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="d-flex align-items-center">
            <h4 class="card-title">REPORTS & ANALYTICS</h4>
            <button id="btnAdd" class="btn btn-primary ml-auto">
              <i class="fa fa-search"></i>
              FETCH DATA
            </button>
          </div>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-2" table_tbody_for_append3>
              <div class="form-group no-padding">
                <span>FROM</span>
                <input type="date" name="date_from" id="date_from" class="form-control "
                value="<?php echo isset($report['date_from']) ? $report['date_from'] : date("Y-m-d") ?>"  required>
              </div>
            </div>
            <div class="col-sm-2" table_tbody_for_append3>
              <div class="form-group no-padding">
                <span>TO</span>
                <input type="date" name="date_to" id="date_to" class="form-control" 
                value="<?php echo isset($report['date_to']) ? $report['date_to'] : date("Y-m-d") ?>" required>
              </div>
            </div>
            <div class="col-sm-2" table_tbody_for_append3>
              <div class="form-group no-padding">
                <span>TYPE</span>
                <select name="report_type" id="report_type" class="form-control form-control-sm selectpicker" 
                data-show-subtext="true" data-live-search="true" required>
                  <option value="">Select</option>
                  <?php foreach($get_report_type as $table_row) :?>		
                    <option value="<?= $table_row->setting?>"><?= $table_row->setting?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-sm-2" table_tbody_for_append3>
              <div class="form-group no-padding">
                <span>REPORT</span>
                <select name="report" id="report" class="form-control form-control-sm selectpicker" 
                data-show-subtext="true" data-live-search="true">
                  <option value="">All</option>
                  <?php foreach($get_report as $table_row) :?>		
                    <option value="<?= $table_row->setting?>"><?= $table_row->setting?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
            <div class="col-sm-4" table_tbody_for_append3>
              <div class="form-group no-padding">
                <span>ACCOUNT</span>
                <select name="account" id="account" class="form-control form-control-sm selectpicker"
                data-show-subtext="true" data-live-search="true">
                  <option value="">All</option>
                  <?php foreach($registered_accounts as $table_row) :?>		
                    <option value="<?= $table_row->id_registration?>"><?= $table_row->reference_nos?> - <?= $table_row->last_name?>, <?= $table_row->first_name?> <?= $table_row->middle_name?></option>
                  <?php endforeach ?>
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>