<!-- Modal -->
<style type="text\css">
.modal-body .form-horizontal .col-sm-2,
.modal-body .form-horizontal .col-sm-10 {
    width: 100%
}

.modal-body .form-horizontal .control-label {
    text-align: left;
}
.modal-body .form-horizontal .col-sm-offset-2 {
    margin-left: 15px;
}
</style>
<div class="modal fade" id="Setting" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" 
                   data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    
                </h4>
                <span id='response'></span>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form class="form-horizontal" id="form_setting" action="<?php echo base_url();?>revenues_03/save_setting" method="POST">
<fieldset>

<!-- Form Name -->


<input type="hidden" name='id' id='id'>
<input type="hidden" name='reporttype' id='reporttype'>
<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="sumIds">Sum ID</label>
  <div class="col-md-6">
    <div class="input-group">
      <span class="input-group-addon">SUM(,)</span>
      <input id="sumIds" name="sumIds" class="form-control" placeholder="" type="text">
    </div>
    
  </div>
</div>

<!-- Prepended text-->
<div class="form-group">
  <label class="col-md-4 control-label" for="divisorId">Divisor Id</label>
  <div class="col-md-4">
    <div class="input-group">
      <span class="input-group-addon">/</span>
      <input id="divisorId" name="divisorId" class="form-control" placeholder="" type="text">
    </div>
    
  </div>
</div>

<!-- Select Basic -->
<div class="form-group">
  <label class="col-md-4 control-label" for="ctype">Formula Type</label>
  <div class="col-md-4">
    <select id="ctype" name="ctype" class="form-control">
      
    </select>
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="depth">Depth</label>  
  <div class="col-md-2">
  <input id="depth" name="depth" type="number" placeholder="" class="form-control input-md">
    
  </div>
</div>

</fieldset>
</form>

                
                
                
                
                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary" id="btn-save">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

