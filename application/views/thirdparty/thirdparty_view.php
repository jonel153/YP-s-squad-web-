<!-- thirdparty -->
        <div id="page-content-wrapper"  class="animated fadeIn">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Third-Party</li>
                  </ol>
                </nav>
                
                <div style="width: auto;">
                    <table class="table table-sm table-striped nowrap" id="tableThirdParty" style="font-size: 12px; width: 100%;">
                            <thead>
                                <tr class="bg-grey-dark text-light">
                                    <th class="text-center align-middle">Corporation</th>
                                    <th hidden></th>
                                    <th class="text-center align-middle">Number</th>
                                    <th class="text-center align-middle">Email</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                    <?php
                                    foreach ($company as $row_company):
                                        $id= strtr(
                                            $this->encrypt->encode($row_company->company_id),
                                            array(
                                                '+' => '.',
                                                '=' => '-',
                                                '/' => '~'
                                            )
                                        );
                                    ?>
                                    <tr>
                                        <td class="text-center"><?=$row_company->company_name?></td>
                                        <td hidden></td>
                                        <td class="text-center"><?=$row_company->company_number?></td>
                                        <td class="text-center"><?=$row_company->company_email?></td>
                                        <td class="text-center"><a href="#" class="btn btn-info btn-sm">View</a></td>
                                    </tr>
                                    <?php endforeach;?>
                                

                                <!-- <tr>
                                    <td class="text-center">CHK-001</td>
                                    <td hidden></td>
                                    <td class="text-center">ACC-001</td>
                                    <td class="text-center">Quezon City</td>
                                    <td class="text-center">Chowking</td>
                                    <td class="text-center">P 10,000.00</td>
                                    <td class="text-center">Peso</td>
                                    <td class="text-center">November 2017</td>
                                    <td class="text-center">
                                        <button class="btn btn-secondary btn-sm">Cancel</button>
                                    </td>
                                </tr> -->
                            </tbody>
                    </table>
                </div>
                
                <div class="col-lg-12" id="fab-add">
                    <a href="" data-toggle="modal" data-target="#modal-upload" class="btn btn-primary btn-lg rounded-circle"><span class="fa fa-plus"></span></a>
                </div>
            </div>
        </div>

        <!-- add check modal -->
        <div class="modal fade" id="modal-upload" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">

                    <div class="modal-content">
                        <div class="modal-header bg-grey-dark">
                            <label id="editItemNumberHeader" class="modal-title text-light">Add Corporation</label>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">                            
                            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/add-corporation" id="add-corporation">
                                <div class="form-group">
                                    <label>Corporation Name:</label>
                                    <input type="text" class="form-control" name="corporation">
                                </div>

                                <div class="form-group">
                                    <label>Type:</label>
                                    <select class="form-control" name="type">
                                        <option value="">Select...</option>
                                        <?php
                                        foreach ($type as $row):
                                            $encode_id= strtr(
                                                $this->encrypt->encode($row->type_id),
                                                array(
                                                    '+' => '.',
                                                    '=' => '-',
                                                    '/' => '~'
                                                )
                                            );
                                        ?>
                                        <option value="<?=$encode_id?>"><?=$row->type_name?></option>
                                        <?php endforeach;?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Address:</label>
                                    <input type="text" class="form-control" name="address">
                                </div>

                                <div class="form-group">
                                    <label>Number: </label>
                                    <input type="text" class="form-control" name="pnum">
                                </div>

                                <div class="form-group">
                                    <label>Email: </label>
                                    <input type="text" class="form-control" name="email">
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready( function () {
                    $('#sidebarThirdParty').css({
                        background: '#FFF'
                    });
                    $('#tableThirdParty').DataTable({
                        scrollY:        "450px",
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         true,
                        fixedHeader:    true,
                        responsive:     true
                    });
                } );
        </script>