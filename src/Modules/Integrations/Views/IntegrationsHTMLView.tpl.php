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
                                $modName = $pageVars["module-{$ms2}"] ; }
                            else if (in_array($message_suffix, array("disabled", "enabled"))) {
                                $ms2 = substr($message_suffix, 0, strlen($message_suffix)-1) ;
                                $modName = $pageVars["module-{$ms2}"] ; }
                            var_dump($pageVars) ;
                            ?>

                            <div class="col-sm-12 btn btn-success">
                                Successfully <?php echo ucfirst($message_suffix) ; ?> Module : <?php echo ucfirst($modName) ; ?>
                            </div>

                        <?php
                        } }
                    ?>


                </div>

                <h3>Module and Extension Manager</h3>

                <div class="form-group">

                    <form class="form-horizontal custom-form" action="<?php echo '/index.php?control=Integrations&action=webaction' ; ?>" method="POST">

                        <div class="col-sm-3">
                            <label for="project-name" class="control-label text-left">Git Repository</label>
                        </div>

                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="module-source" id="module-source" placeholder="Git Repository"  />
                        </div>

                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-success">Download Module</button>
                        </div>

                    </form>

                </div>

                    <div class="form-group">

                        <div class="col-sm-12">
                            <hr />
                            <div class="col-sm-12">
                                <h3>Available Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i> <a class="text-center" href="/index.php?control=Integrations&action=webcacheupdate">Update Cache</a></h3>
                            </div>

                            <div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">

                                <div class="form-group ui-sortable moduleList" id="sortableSteps">

                                    <?php

                                    $oddeven = "Odd" ;

                                    foreach ($pageVars["data"]["available_modules"] as $modSlug => $one_available_module) {
                                        //echo '<div class="form-group ui-state-default ui-sortable-handle moduleEntry" id="step'.$modSlug.'">' ;

                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;

                                        echo ' <div class="col-sm-12 moduleEntry moduleEntry'.$oddeven.'" id="step'.$modSlug.'">' ;
                                        echo '  <div class="col-sm-8">' ;
                                        echo '   <p><strong>'.$one_available_module["name"].' </strong></p>';
                                        echo '   <p>'.$one_available_module["description"].'</p>';
                                        echo '   <p><strong>Dependencies: </strong>'.implode(", ", $one_available_module["dependencies"]).'</p>';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][module]" name="steps['.$modSlug.'][module]" value="'.$one_available_module["module"].'" />';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][steptype]" name="steps['.$modSlug.'][steptype]" value="'.$one_available_module["steptype"].'" />';
                                        echo '  </div>';
                                        echo '  <div class="col-sm-4">'  ;
                                        echo '   <div class="col-sm-12 ">' ;
                                        echo '    <a class="btn btn-success text-center" href="/index.php?control=Integrations&action=webinstall&source=defaultrepo&modname='.$modSlug.'">Download</a>' ;
                                        echo '   </div>';
                                        echo '   <div class="col-sm-12">' ;
                                        echo '    <a class="btn btn-success text-center" href="/index.php?control=Integrations&action=webinstall&source=defaultrepo&modname='.$modSlug.'&dependencies=true">Download Dependencies</a>' ;
                                        echo '   </div>';
                                        echo '  </div>';
                                        echo ' </div>';
                                        // echo '</div>';
                                    } ?>

                                    <br style="clear: both;" />

                                </div> <!-- sortable end -->

                            </div>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-12">
                            <hr />
                            <div class="col-sm-12">
                                <h3> Enabled Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                            </div>
                                <?php

                                if (count($pageVars["data"]["installed_modules"]) > 0) {
                                    echo '<div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">' ;
                                    $oddeven = "Odd" ;
                                    foreach ($pageVars["data"]["installed_modules"] as $instModuleInfo) {
                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;
                                        echo '<div class="col-sm-12 moduleEntry moduleEntry'.$oddeven.'">';
                                        echo '  <div class="col-sm-8">';
                                        echo '    <p class="moduleListText"><strong>'.$instModuleInfo["command"].'</strong></p>';
                                        echo '    <p>'.$instModuleInfo["name"]."</p>";
                                        echo '  </div>';
                                        echo '  <div class="col-sm-4">';
                                        echo '    <a class="btn btn-success text-center" href="/index.php?control=Integrations&action=webaction&uninstall='.$instModuleInfo["command"].'">Uninstall</a>';
                                        echo '    <a class="btn btn-warning text-center" href="/index.php?control=Integrations&action=webaction&module-disable='.$instModuleInfo["command"].'">Disable</a>';
                                        echo '  </div>';
                                        echo '</div>'; } }
                                else {
                                    echo '<div class="col-sm-12" style="height: 40px;">' ;
                                    echo '<p>No Enabled modules found</p>' ; }
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <hr />
                            <div class="col-sm-12">
                                <h3> Disabled Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                            </div>

                                <?php

                                if (count($pageVars["data"]["disabled_modules"]) > 0) {
                                    echo '<div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">' ;
                                    $oddeven = "Odd" ;
                                    foreach ($pageVars["data"]["disabled_modules"] as $instModuleInfo) {
                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;
                                        echo '<div class="col-sm-12 moduleEntry moduleEntry'.$oddeven.'">';
                                        echo '  <div class="col-sm-8">';
                                        echo '    <p class="moduleListText"><strong>'.$instModuleInfo.'</strong></p>';
                                        echo '  </div>';
                                        echo '  <div class="col-sm-4">';
                                        echo '    <a class="btn btn-success text-center" href="/index.php?control=Integrations&action=webaction&uninstall='.$instModuleInfo.'">Uninstall</a>';
                                        echo '    <a class="btn btn-info text-center" href="/index.php?control=Integrations&action=webaction&module-enable='.$instModuleInfo.'">Enable</a>';
                                        echo '  </div>';
                                        echo '</div>'; } }
                                else {
                                    echo '<div class="col-sm-12" style="height: 40px;">' ;
                                    echo '<p>No Disabled modules found</p>' ; }
                                ?>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <hr />
                            <div class="col-sm-12">
                                <h3> Incompatible Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                            </div>
                            <?php
                                if (count($pageVars["data"]["incompatible_modules"]) > 0) {
                                    echo '<div class="col-sm-12" style="height: 50px; overflow-y: scroll; resize:both;">' ;
                                    $oddeven = "Odd" ;
                                    foreach ($pageVars["data"]["incompatible_modules"] as $compatModuleInfo) {
                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;
                                        echo '<div class="col-sm-12 moduleEntry moduleEntry'.$oddeven.'">';
                                        echo '  <div class="col-sm-8">';
                                        echo '    <p class="moduleListText"><strong>'.$compatModuleInfo["command"].'</strong> - '.$compatModuleInfo["name"]."</p>";
                                        echo '  </div>';
                                        echo '</div>'; } }
                                else {
                                    echo '<div class="col-sm-12" style="height: 40px;">' ;
                                    echo '<p>No Incompatible modules found</p>' ; }
                            ?>
                            </div>
                        </div>

                    </div>

                <!--
                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                    </div>

                </form>
                -->
            </div>
            <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

        </div>

</div><!-- container -->

<link rel="stylesheet" href="/Assets/Modules/Integrations/css/modulemanager.css">
