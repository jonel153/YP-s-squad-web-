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
                                    <th class="text-center align-middle">Company Name</th>
                                    <th class="text-center align-middle">3rd party</th>
                                    <th class="text-center align-middle">Email</th>
                                    <th class="text-center align-middle">Contact #</th>
                                    <th class="text-center align-middle">Name</th>
                                    <th class="text-center align-middle">Date Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                 <?php
                                foreach ($thirdparty as $object) {
                                    echo '<tr>';
                                    echo '<td class="text-center">'.$object->company_name.'</td>';
                                    echo '<td class="text-center">'.$object->party_name.'</td>';
                                    echo '<td class="text-center">'.$object->party_email.'</td>';
                                    echo '<td class="text-center">'.$object->party_number.'</td>';
                                    echo '<td class="text-center">'.$object->party_name.'</td>';
                                    echo '<td class="text-center">'.$object->date_created.'</td>';
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
                        <h3 id="editItemNumberHeader" class="modal-title text-light">Add Third Party</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/function_add_thirdparty">

                            <div class="form-group">
                                <label>Company:</label>
                                <select class="form-control" name="company_name">
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
                                <label>Name:</label>
                                <input class="form-control" type="text" name="thirdparty_name">
                            </div>

                            <!-- EMAIL ADDRESS -->
                            <div class="form-group">
                                <label>Email Address:</label>
                                <input class="form-control" type="text" name="thirdparty_email">
                            </div>

                            <!-- CONTANCT NUMBER -->
                            <div class="form-group">
                                <label>Contact Number:</label>
                                <input class="form-control" type="text" name="thirdparty_contactnumber">
                            </div>

                            <!-- PASSWORD -->
                            <div class="form-group">
                                <label>Password:</label>
                                <input class="form-control" type="password" name="thirdparty_password">
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
                $('#sidebarThirdPartyRyan').css({
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
