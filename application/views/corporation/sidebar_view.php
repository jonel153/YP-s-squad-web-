        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav text-dark">
                <!--profile-->
                <li class="align-middle text-center">
                    <img class="img-fluid tiles img-thumbnail rounded-circle" src="<?php echo base_url();?>assets/img/avatar.png" alt="Card image cap" style="height: 100px; width: auto; margin-top: 15px;">
                </li>

                <li class="mt-3 text-center">
                    <h4><?=$name?></h4>
                    <!-- <h5 class="lead">Web Designer</h5> -->
                </li>
                <li id="sidebarHome">
                    <a href="<?php echo base_url();?>corporation">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo base_url();?>assets/img/home.png" style="height: 2em; width: auto;">
                            </div>
                            <div class="col">Home</div>
                        </div>
                    </a>
                </li>
                <li id="sidebarIssueCheck">
                    <a href="<?php echo base_url();?>corporation/issue_check">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo base_url();?>assets/img/check.png" style="height: 2em; width: auto;">
                            </div>
                            <div class="col">Issue Check</div>
                        </div>
                    </a>
                </li>

                <li id="sidebarThirdParty">
                    <a href="<?php echo base_url();?>corporation/third-party">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo base_url();?>assets/img/thirdparty.png" style="height: 2em; width: auto;">
                            </div>
                            <div class="col">3rd party</div>
                        </div>
                    </a>
                </li>

                <li id="sidebarHistory">
                    <a href="<?php echo base_url();?>corporation/history">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo base_url();?>assets/img/report.png" style="height: 2em; width: auto;">
                            </div>
                            <div class="col">History</div>
                        </div>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>corporation/logout">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo base_url();?>assets/img/logout.png" style="height: 2em; width: auto;">
                            </div>
                            <div class="col">Logout</div>
                        </div>
                    </a>
                </li>
<!--                 <li>
                    <a href="#">Services</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li> -->
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

            <!-- Menu Toggle Script -->
        <script>
        // $("#menu-toggle").click(function(e) {
        //     e.preventDefault();
        //     $("#wrapper").toggleClass("toggled");
        // });

        $(document).ready(function() {
            $('#menu-toggle').on('click load', function(){
                $('#wrapper').toggleClass('toggled');
            });   
        });
        </script>