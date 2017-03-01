<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form hvr-bounce-in">
                        <input type="text" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-dashboard"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw hvr-bounce-in"></i> Configure PTSource
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-group hvr-bounce-in"></i> User Manager
                    </a>
                </li>
				<li>
                    <a href="/index.php?control=UserManager&action=show" class=" active hvr-bounce-in">
                        <i class="fa fa-suitcase hvr-bounce-in"></i> Module Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9">
                    <div class="well well-lg">

<!--            <h2 class="text-uppercase text-light"><a href="/">PTSource - Pharaoh Tools </a></h2>-->
            <div class="row clearfix no-margin">

                <div class="form-group">

                    <?php

                    $message_suffixes = array("installed", "disabled", "enabled") ;
                    foreach ($message_suffixes as $message_suffix ) {
                        if ($pageVars["data"]["webAction"]["$message_suffix-status"] == true ) {

                            if ($message_suffix == "installed") {
                                $ms2 = "install" ;
                                $modName = $pageVars["integration-{$ms2}"] ; }
                            else if (in_array($message_suffix, array("disabled", "enabled"))) {
                                $ms2 = substr($message_suffix, 0, strlen($message_suffix)-1) ;
                                $modName = $pageVars["integration-{$ms2}"] ; }
                            var_dump($pageVars) ;
                            ?>

                            <div class="col-sm-12 btn btn-success">
                                Successfully <?php echo ucfirst($message_suffix) ; ?> Integration : <?php echo ucfirst($modName) ; ?>
                            </div>

                        <?php
                        } }
                    ?>


                </div>

                <h3>Application Integration Manager</h3>

                <div class="form-group">
                    <div class="col-sm-12">
                        <hr />
                        <div class="col-sm-12">
                            <h3> Enabled Integrations: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                        </div>
                        <?php

                        if (count($pageVars["data"]["enabled_integrations"]) > 0) {
                            ?>

                            <div class="col-sm-12">

                            <?php
                            $oddeven = "Odd" ;
                            foreach ($pageVars["data"]["enabled_integrations"] as $instIntegrationInfo) {
                                $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;
                                ?>

                                <div class="btn btn-primary integrationEntry integrationEntry<?php echo $oddeven ; ?>">
                                  <div class="fullWidth">
                                    <p class="integrationListText">
                                        <strong>
                                            <?php echo $instIntegrationInfo["name"] ; ?>
                                        </strong>
                                    </p>
                                    <span>
                                        <img src="<?php echo $instIntegrationInfo["image"] ; ?>"
                                             alt="<?php echo $instIntegrationInfo["name"] ; ?>"
                                             class="integration_logo" />
                                    </span>
                                    <p>
                                        <?php

                                            if (strlen($instIntegrationInfo["description"]) < 60) {
                                                $desc = $instIntegrationInfo["description"] ;
                                            } else {
                                                $desc = substr($instIntegrationInfo["description"], 0, 60) ;
                                                $desc = $desc . '...' ;
                                            }
                                            echo $desc ;

                                        ?>
                                    </p>
                                  </div>
                                  <div class="fullWidth">
                                    <a class="btn btn-success text-center" href="<?php echo $instIntegrationInfo["manage_link"] ; ?>">
                                        Manage
                                    </a>
                                  </div>
                                </div>
                            <?php
                            }
                            ?>

                            </div>

                        <?php
                        }
                        else {
                        ?>
                            <div class="col-sm-12" style="height: 40px;">
                                <p>No Enabled integrations found</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">
                        <hr />
                        <div class="col-sm-12">
                            <h3> Installed Integrations: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                        </div>
                        <?php

                        if (count($pageVars["data"]["installed_integrations"]) > 0) {
                            ?>

                            <div class="col-sm-12">

                            <?php
                            $oddeven = "Odd" ;
                            foreach ($pageVars["data"]["installed_integrations"] as $instIntegrationInfo) {
                                $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;
                                ?>

                                <div class="btn btn-primary integrationEntry integrationEntry<?php echo $oddeven ; ?>">
                                  <div class="fullWidth">
                                    <p class="integrationListText">
                                        <strong>
                                            <?php echo $instIntegrationInfo["name"] ; ?>
                                        </strong>
                                    </p>
                                    <span>
                                        <img src="<?php echo $instIntegrationInfo["image"] ; ?>"
                                             alt="<?php echo $instIntegrationInfo["name"] ; ?>"
                                             class="integration_logo" />
                                    </span>
                                    <p>
                                        <?php

                                            if (strlen($instIntegrationInfo["description"]) < 60) {
                                                $desc = $instIntegrationInfo["description"] ;
                                            } else {
                                                $desc = substr($instIntegrationInfo["description"], 0, 60) ;
                                                $desc = $desc . '...' ;
                                            }
                                            echo $desc ;

                                        ?>
                                    </p>
                                  </div>
                                  <div class="fullWidth">
                                    <a class="btn btn-success text-center" href="<?php echo $instIntegrationInfo["manage_link"] ; ?>">
                                        Manage
                                    </a>
                                  </div>
                                </div>
                            <?php
                            }
                            ?>

                            </div>

                        <?php
                        }
                        else {
                        ?>
                            <div class="col-sm-12" style="height: 40px;">
                                <p>No Enabled integrations found</p>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>


<!--                </div>-->

                <div class="form-group">

                    <div class="col-sm-12">
                        <hr />
                        <div class="col-sm-12">
                            <h3>Available Integrations: <i style="font-size: 18px;" class="fa fa-chevron-down"></i> <a class="text-center" href="/index.php?control=Integrations&action=webcacheupdate">Update Cache</a></h3>
                        </div>

                        <div class="col-sm-12">

                            <?php

                            $oddeven = "Odd" ;

                            foreach ($pageVars["data"]["available_integrations"] as $modSlug => $one_available_integration) {
                                //echo '<div class="form-group ui-state-default ui-sortable-handle integrationEntry" id="step'.$modSlug.'">' ;

                                $oddeven = ($oddeven === "Odd") ? "Even" : "Odd" ;
                                ?>

                                <div class="btn btn-warning integrationEntry integrationEntry<?php echo $oddeven ; ?>" id="step<?php echo $modSlug ; ?>">
                                    <div class="col-sm-12">
                                        <p><strong><?php echo $one_available_integration["name"] ; ?> </strong></p>
                                        <p><?php echo $one_available_integration["description"] ; ?></p>
                                    </div>
                                    <div class="col-sm-12">
                                        <a class="btn btn-success text-center" href="/index.php?control=Integrations&action=webinstall&source=defaultrepo&modname=<?php echo $modSlug ; ?>">
                                            Manage
                                        </a>
                                    </div>
                                </div>

                                <?php

                            } ?>

                            <br style="clear: both;" />

                        </div>

                    </div>

                </div>

            </div>
            <hr />
            <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

        </div>

</div><!-- container -->

<link rel="stylesheet" href="/Assets/Modules/Integrations/css/integrations.css">
