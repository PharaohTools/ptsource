<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active">
                    Menu
                    <span class="pull-right" id="slide-submenu"> <i class="fa fa-times"></i> </span>
                </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
            </div>
        </div>

        <?php
            $act = '/index.php?control=ModuleManager&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">

                <h3>Module and Extension Manager</h3>

                    <div class="form-group">

                        <div class="col-sm-2">
                            <label for="project-name" class="control-label text-left">Git Repository</label>
                        </div>
                        <form class="form-horizontal custom-form" action="<?php echo '/index.php?control=ModuleManager&action=save' ; ?>" method="POST">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="new-module-repository" id="new-module-repository" placeholder="Git Repository" value="<?php echo $pageVars["data"]["new-module"]["project-name"] ; ?>" />
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Download Module</button>
                                        <input type="hidden" name="" id="item" value="" />
                                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                                </div>
                            </div>
                        </form>

                        <div class="form-group">
                            <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-12">

                            <h3>Available Modules</h3>

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
                                        echo '   <div class="col-sm-12">' ;
                                        echo '    <a class="btn btn-success text-center" onclick="deleteStepField(hash)">Download</a>' ;
                                        echo '   </div>';
                                        echo '   <div class="col-sm-12">' ;
                                        echo '    <a class="btn btn-success text-center" onclick="deleteStepField(hash)">Download Dependencies</a>' ;
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
                                <h3> Installed Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                                <hr />
                                <div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">
                                <?php
                                    foreach ($pageVars["data"]["installed_modules"] as $instModuleInfo) {
                                        echo '<div class="col-sm-6">';
                                        echo '  <p class="moduleListText"><strong>'.$instModuleInfo["command"].'</strong> - '.$instModuleInfo["name"]."</p>";
                                        echo '</div>'; }
                                ?>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <h3> Incompatible Modules: <i style="font-size: 18px;" class="fa fa-chevron-down"></i></h3>
                                <hr />
                                <div class="col-sm-12" style="height: 50px; overflow-y: scroll; resize:both;">
                                <?php
                                    if (count($pageVars["data"]["incompatible_modules"]) > 0) {
                                        foreach ($pageVars["data"]["incompatible_modules"] as $compatModuleInfo) {
                                            echo '<div class="col-sm-6">';
                                            echo '  <p class="moduleListText"><strong>'.$compatModuleInfo["command"].'</strong> - '.$compatModuleInfo["name"]."</p>";
                                            echo '</div>'; } }
                                    else {
                                        echo '<p>No incompatible modules found</p>' ; }
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
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- container -->

<link rel="stylesheet" href="/Assets/ModuleManager/css/modulemanager.css">