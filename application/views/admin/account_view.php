        <div id="page-content-wrapper"  class="animated fadeIn">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Third Party List</li>
                  </ol>
                </nav>

                <div style="width: auto; overflow-x: auto;" class="">
                    <?php
                        if($this->session->flashdata('message') != "" ){

                            echo $this->session->flashdata('message');
                        }
                    ?>
                    <table class="table table-sm table-striped nowrap table-responsive" id="tableIssueCheck" style="font-size: 12px; width: 100%;">
                            <thead>
                                <tr class="bg-grey-dark text-light">
                                    <th class="text-center align-middle">Account</th>
                                    <th class="text-center align-middle">Company</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                foreach ($account as $object) {
                                    echo '<tr>';
                                    echo '<td class="text-center">'.$object->ACCOUNT_NUMBER.'</td>';
                                    echo '<td class="text-center">'.$object->company_name.'</td>';
                                    echo '<td class="text-center"></td>';
                                    echo '</tr>';
                                    }
                                    ?>
                            </tbody>
                    </table>
                </div>

                <div class="col-lg-12" id="fab-add">
                    <a href="" data-toggle="modal" data-target="#modal-upload" class="btn btn-primary btn-lg rounded-circle"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>

        <!-- add t-party modal -->
        <div class="modal fade" id="modal-upload" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">

                <div class="modal-content">
                    <div class="modal-header bg-grey-dark">
                        <h3 id="editItemNumberHeader" class="modal-title text-light">Add account</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/add-account">

                            <div class="form-group">
                                <label>Corporation:</label>
                                <select class="form-control" name="company_name">
                                    <option value="">Select..</option>
                                    <?php
                                    foreach ($company as $object)
                                    {
                                      echo '<option value="'.$object->company_id.'">'.$object->company_name.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- NAME -->
                            <div class="form-group">
                                <label>Account:</label>
                                <input class="form-control" type="text" name="account">
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
            $(document).ready( function () {
                $('#sidebarAccount').css({
                    background: '#FFF'
                });
                $('#tableIssueCheck').DataTable({
                    scrollY:        "450px",
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         true,
                    fixedHeader:    true,
                    responsive:     true
                });
            });
        </script>
