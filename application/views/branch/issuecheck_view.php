<!-- issuecheck -->

        <!-- Page Content -->
        <!-- <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1>Simple Sidebar</h1>
                <p>This template has a responsive menu toggling system. The menu will appear collapsed on smaller screens, and will appear non-collapsed on larger screens. When toggled using the button below, the menu will appear/disappear. On small screens, the page content will be pushed off canvas.</p>
                <p>Make sure to keep all page content within the <code>#page-content-wrapper</code>.</p>
                <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>
            </div>
        </div> -->
        <!-- /#page-content-wrapper -->

        <div id="page-content-wrapper"  class="animated fadeIn">
            <div class="container-fluid">
                <nav aria-label="breadcrumb" role="navigation">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">Home</li>
                    <li class="breadcrumb-item active" aria-current="page">Issue Check</li>
                  </ol>
                </nav>
                <?php
                    if($this->session->flashdata('message') != "" ){

                        echo $this->session->flashdata('message');
                    }
                ?>
                <div style="width: auto; overflow-x: auto;">
                    <table class="table table-sm table-striped nowrap" id="tableIssueCheck" style="font-size: 12px; width: 100%;">
                            <thead>
                                <tr class="bg-grey-dark text-light">
                                    <th class="text-center align-middle">Check #</th>
                                    <th hidden></th>
                                    <th class="text-center align-middle">Account #</th>
                                    <th class="text-center align-middle">Branch</th>
                                    <th class="text-center align-middle">Company</th>
                                    <th class="text-center align-middle">Payee</th>
                                    <th class="text-center align-middle">Amount</th>
                                    <th class="text-center align-middle">Check date</th>
                                    <th class="text-center align-middle">Created date</th>
                                    <th class="text-center align-middle">Status</th>
                                    <th class="text-center align-middle">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $btn = '';
                                $modal = '';
                                $count = 0;
                                foreach ($check as $object):

                                    $id= strtr(
                                        $this->encrypt->encode($object->check_id),
                                        array(
                                            '+' => '.',
                                            '=' => '-',
                                            '/' => '~'
                                        )
                                    );
                                    if($object->STATUS_ID == 3){
                                        $btn = '<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-status' . $count . '">Receive</a>';
                                         $modal .= 
                                        '<div class="modal fade" id="modal-status' . $count . '" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">
                                                    <div class="modal-header bg-grey-dark">
                                                        <h5 id="editItemNumberHeader" class="modal-title text-light">Receive Check # ' . $object->check_no . '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                            <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">                           
                                                        <form method="POST" enctype="multipart/form-data" action="' . base_url('branch/check-receive') . '" id="shipment_form">
                                                            <input type="hidden" value="' . $id . '" name="id">
                                                            <strong>Are your sure?</strong>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" value="Import" id="btn-file-submit">Yes</button>
                                                                <button type="submit" class="btn btn-danger" data-dismiss="modal" value="Import" id="btn-file-submit">No</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }elseif($object->STATUS_ID == 4){
                                        $btn = '<a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-status' . $count . '">Claim</a>';
                                         $modal .= 
                                        '<div class="modal fade" id="modal-status' . $count . '" tabuser="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">

                                                <div class="modal-content">
                                                    <div class="modal-header bg-grey-dark">
                                                        <h5 id="editItemNumberHeader" class="modal-title text-light">Claim Check # ' . $object->check_no . '</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                            <span aria-hidden="true"><i class="fa fa-times text-light"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">                           
                                                        <form method="POST" enctype="multipart/form-data" action="' . base_url('branch/check-claim') . '" id="shipment_form">
                                                            <input type="hidden" value="' . $id . '" name="id">
                                                            <strong>Are your sure?</strong>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" value="Import" id="btn-file-submit">Yes</button>
                                                                <button type="submit" class="btn btn-danger" data-dismiss="modal" value="Import" id="btn-file-submit">No</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                                    }

                                    $count++;
                                ?>
                                    <tr>
                                        <td><?=$object->check_no?></td>
                                        <td hidden></td>
                                        <td class="text-center"><?=$object->ACCOUNT_NUMBER?></td>
                                        <td class="text-left"><?=$object->BRANCH?></td>
                                        <td class="text-center"><?=$object->company_name?></td>
                                        <td class="text-right"><?=$object->party_name?></td>
                                        <td class="text-center"><?=$object->check_amt?></td>
                                        <td class="text-center"><?=date('Y-m-d', strtotime($object->check_date))?></td>
                                        <td class="text-center"><?=date('Y-m-d', strtotime($object->date_created))?></td>
                                        <td class="text-center"><?=$object->STATUS?></td>
                                        <td class="text-center"><?=$btn?></td>
                                    </tr>
                                <?php endforeach;?>                                
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?=$modal?>
        <!-- add check modal -->
        <script>
            $(document).ready( function () {
                $('#sidebarIssueCheck').css({
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