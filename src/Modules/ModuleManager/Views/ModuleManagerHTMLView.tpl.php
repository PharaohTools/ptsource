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
                <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-search"></i> Pipeline Home
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> All Pipelines
                </a>
                <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Delete
                </a>
                <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
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

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <label for="project-name" class="col-sm-2 control-label text-left">Git Repository</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="new-module-repository" id="new-module-repository" placeholder="Git Repository" value="<?php echo $pageVars["data"]["new-module"]["project-name"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">

                        <div class="col-sm-12">

                            <h3>Available Modules</h3>

                            <ul class="form-group ui-sortable moduleList" id="sortableSteps">

                                <?php

                                foreach ($pageVars["data"]["available_modules"] as $modSlug => $one_available_module) {
                                    echo '<li class="form-group ui-state-default ui-sortable-handle moduleEntry" id="step'.$modSlug.'">' ;
                                    echo ' <div class="col-sm-12">' ;
                                    echo '  <div class="col-sm-10">' ;
                                    echo '   <p><strong>'.$one_available_module["name"].'</strong></p>';
                                    echo '   <p>'.$one_available_module["description"].'</p>';
                                    echo '   <input type="hidden" id="steps['.$modSlug.'][module]" name="steps['.$modSlug.'][module]" value="'.$one_available_module["module"].'" />';
                                    echo '   <input type="hidden" id="steps['.$modSlug.'][steptype]" name="steps['.$modSlug.'][steptype]" value="'.$one_available_module["steptype"].'" />';
                                    echo '  </div>';
                                    echo '  <div class="col-sm-2">'  ;
                                    echo '   <a class="btn btn-success" onclick="deleteStepField(hash)">Add </a>' ;
                                    echo '  </div>';
                                    echo ' </div>';
                                    echo '</li>'; } ?>

                            </ul> <!-- sortable end -->

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-6">
                            <h3> Installed Modules: <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
                            <hr />
                            <?php
                                foreach ($pageVars["data"]["installed_modules"] as $instModuleInfo) {
                                    if ($instModuleInfo["hidden"] != true) {
                                        echo '<p class="moduleListText"><strong>'.$instModuleInfo["command"].'</strong> - '.$instModuleInfo["name"]."</p>"; } }
                            ?>
                        </div>


                        <div class="col-sm-6">
                            <h3> Incompatible Modules: <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
                            <hr />
                            <?php
                                foreach ($pageVars["data"]["incompatible_modules"] as $compatModuleInfo) {
                                    if ($compatModuleInfo["hidden"] != true) {
                                        echo '<p class="moduleListText"><strong>'.$compatModuleInfo["command"].'</strong> - '.$compatModuleInfo["name"]."</p>"; } }
                            ?>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                    </div>

                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- container -->

<link rel="stylesheet" href="/Assets/ModuleManager/css/modulemanager.css">