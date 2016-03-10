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
<div class="modal fade" id="NewService" tabindex="-1" role="dialog" 
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
                    New Service
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                
                <form class="form-horizontal" role="form">
                <input type="hidden" id="nid">
                  <div class="form-group">
                    <label  class="col-sm-2 control-label"
                              for="name">Service Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" 
                        id="name" placeholder=""/>

                    </div>
                  </div>
                 
                
                </form>
                
                
                
                
                
                
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Close
                </button>
                <button type="button" class="btn btn-primary">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

