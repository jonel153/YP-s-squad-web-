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
                
               
            </div>
        </div>

        <!-- add check modal -->
       
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