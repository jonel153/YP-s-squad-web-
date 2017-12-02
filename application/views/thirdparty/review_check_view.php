
        <div id="page-content-wrapper"  class="animated fadeIn">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Issue Check</li>
                  </ol>
                </nav>
                
                <div class="table-responsive" style="overflow-x: auto;">
                    <table class="table table-sm table-striped nowrap" id="tableIssueCheck" style="font-size: 12px; width: 100%;">
                        <?=$excel_data?>
                    </table>
                </div>
                <br>
                <div class="pull-right">
                    <a href="" data-toggle="modal" data-target="#modal-upload" class="btn btn-info btn-sm">Confirm</a>
                    <a href="<?=base_url('admin/issue-check')?>" class="btn btn-danger btn-sm">Cancel</a>
                </div>
                <div class="col-lg-12" id="fab-add">
                    <a href="" data-toggle="modal" data-target="#modal-upload" class="btn btn-primary btn-lg rounded-circle"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>
        <?php echo $account;?>
        <!-- add check modal -->
        <div class="modal fade" id="modal-upload" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header bg-grey-dark">
                        <h3 id="editItemNumberHeader" class="modal-title text-light">Confirm Check</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/confirm" id="shipment_form">
                            <input type="hidden" name="file_path" value="<?=$file?>">
                            <input type="hidden" name="account" value="<?=$account?>">
                            <input type="hidden" name="company" value="<?=$company?>">
                            <label>Are you sure?</label>
                            <div class="modal-footer">
                                <!-- <input type="submit" class="btn btn-info btn-sm" value="Import" id="btn-file-submit"/> -->
                                <button type="submit" class="btn btn-primary" value="Import" id="btn-file-submit">Yes</button>
                                <button type="submit" class="btn btn-danger" data-dismiss="modal" value="Import" id="btn-file-submit">No</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready( function () {
                    $('#sidebarIssueCheck').css({
                        background: '#FFF'
                    });
                    $('#tableIssueCheck').DataTable({
                    
                    });
                } );
        </script>