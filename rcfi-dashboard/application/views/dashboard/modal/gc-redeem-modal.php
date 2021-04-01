<!-- Modal Cutoff Details -->
<div class="modal fade" id="addRowModal_redeem" tabindex="-1" role="dialog" aria-hidden="true"  data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
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
      <div class="modal-body" style="background-color:#202940">

      <form method="POST" action="<?= base_url()?>/controller/redeem_gc/<?= $this->uri->segment('3')?>">
        <div class="col-sm-12">
            <span>*SELECT REQUESTOR</span>
            <div id="get_province_list">
              <select  class="form-control form-control-sm selectpicker" data-show-subtext="true" data-live-search="true"
              onchange="select_city(this.value)" id="gc_requestor" name="gc_requestor">
                  <option value="">select region first</option>
                  <?php foreach($query_gc as $table_row) :?>
                  <option value="<?= $table_row->id_registration?>"><?= $table_row->name?></option>
                  <?php endforeach ?>
              </select>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <span>NUMBER OF GC</span>
            <input  type="number" name="gc" id="gc" class="form-control" placeholder="Number of GC" required
            value="<?php echo isset($last_name) ? $last_name : ''?>" onkeyup="this.value = this.value.toUpperCase();">
        </div>
      
              
      <div class="col-sm-12 mt-3">
        <button class="btn btn-primary btn-block">Redeem Now</button>
      </div>

      </form>

    </div>
  </div>
</div>