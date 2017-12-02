<!-- history -->
        <div id="page-content-wrapper"  class="animated fadeIn">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
                  </ol>
                </nav>
                
                <div style="width: auto;">
                    <table class="table table-sm table-striped table-bordered nowrap" id="tableHistory" style="font-size: 16px; width: 100%;" cellpadding="0">
                            <thead>
                                <tr class="bg-grey-dark text-light">
                                    <th class="text-center align-middle">Check #</th>
                                    <th hidden></th>
                                    <th class="text-center align-middle">Account #</th>
                                    <th class="text-center align-middle">Branch</th>
                                    <th class="text-center align-middle">Supplier/Dealer</th>
                                    <th class="text-center align-middle">Amount</th>
                                    <th class="text-center align-middle">Currency</th>
                                    <th class="text-center align-middle">Date</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- <?php
                                foreach ($brochure as $object) {
                                    echo '<tr>';
                                    echo '<td>'.$object->BROCHURE_ID.'</td>';
                                    echo '<td class="text-center">'.$object->BROCHURE_NUMBER.'</td>';
                                    echo '<td class="text-left">'.$object->STATE.'</td>';
                                    echo '<td class="text-center">'.$object->NAME.'</td>';
                                    echo '<td class="text-right">'.$object->CATEGORYBROCHURE.'</td>';
                                    echo '<td class="text-center">'.$object->ITEM.'</td>';
                                    echo '<td class="text-center">'.$object->DATE_CREATED.'</td>';
                                    echo '<td class="text-center">'.$object->DATE_MODIFIED.'</td>';
                                    echo '</tr>';
                                    }
                                    ?>
                                </tr> -->

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
                <div class="modal-dialog modal-md">

                    <div class="modal-content">
                        <div class="modal-header bg-grey-dark">
                            <h3 id="editItemNumberHeader" class="modal-title text-light">Add Check</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">                            
                            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url();?>admin/shipment_process" id="shipment_form">
                                <div class="form-group">
                                    <label for="userfile">Add Excel File</label>
                                    <input class="form-control" id="my-file-selector" type="file" name="userfile" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                </div>
                        </div>
                                <div class="modal-footer">
                                    <!-- <input type="submit" class="btn btn-info btn-sm" value="Import" id="btn-file-submit"/> -->
                                    <button type="submit" class="btn btn-primary" value="Import" id="btn-file-submit">Import</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready( function () {
                    $('#sidebarHistory').css({
                        background: '#FFF'
                    });
                    $('#tableHistory').DataTable({
                        scrollY:        "450px",
                        scrollX:        true,
                        scrollCollapse: true,
                        paging:         true,
                        fixedHeader:    true,
                        responsive:     true
                    });
                } );
        </script>