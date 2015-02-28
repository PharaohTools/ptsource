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
                <!--
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                -->
                <a href="/index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
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
            $act = '/index.php?control=BuildConfigure&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">

                <!--

                <h3><a class="lg-anchor text-light" href="#">Build Configure <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>

                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>">
                        Pipeline Summary for <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>-</a>
                </h5>

                -->

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Settings</h3>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>Default Settings</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-name" class="col-sm-2 control-label text-left">Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-name" id="project-name" placeholder="Project Name" value="<?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left">Project Slug</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-slug" id="project-slug" placeholder="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-description" class="col-sm-2 control-label text-left">Description</label>
                        <div class="col-sm-10">
                            <textarea id="project-description" name="project-description" class="form-control"><?php echo $pageVars["data"]["pipeline"]["project-description"] ; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>Module Settings</h4>
                        </div>
                    </div>

                    <?php

                    foreach ($pageVars["data"]["settings"] as $one_config_slug => $one_conf_tails) {
                        echo '<div class="form-group">' ;
                        echo '  <label for="config_'.$one_config_slug.'" class="col-sm-2 control-label text-left">'.$one_config_slug.':</label>' ;
                        foreach ( $one_conf_tails["settings"] as $fieldSlug => $fieldInfo) {
                            echo '  <div class="col-sm-12">' ;

                            switch ($fieldInfo["type"]) {

                                case "boolean" :

                                    if ( (isset($pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug])) &&
                                        $pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug] == "on" ) {
                                        $onoff = "on" ; }
                                    else if ( (isset($pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug])) &&
                                        $pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug] != "on" ) {
                                        $onoff = "off" ; }
                                    else {
                                        $onoff = (is_null($onoff))
                                            ? $fieldInfo["default"]
                                            : $onoff ; }
                                    if ($onoff === "on") { $onoff = 'checked="checked"' ;}
                                    else {$onoff = "" ;}
                                    echo '  <div class="col-sm-12">' ;
                                    echo '      <label for="settings['.$one_config_slug.']['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>' ;
                                    echo '      <input name="settings['.$one_config_slug.']['.$fieldSlug.']" id="settings['.$one_config_slug.']['.$fieldSlug.']" type="checkbox" '.$onoff.' />' ;
                                    echo '  </div>' ;
                                    break ;
                                case "text" :
                                    if (isset($pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug])) {
                                        $val = $pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug];  }
                                    if (!isset($val)) {
                                        $val = $one_conf_tails["default"] ; }
                                    echo '  <div class="col-sm-12">' ;
                                    echo '      <label for="settings['.$one_config_slug.']['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>' ;
                                    echo '      <input name="settings['.$one_config_slug.']['.$fieldSlug.']" id="settings['.
                                        $one_config_slug.']['.$fieldSlug.']" type="text" class="form-control" value="'.
                                        $val.'" placeholder="'.$one_conf_tails["label"].'" />' ;
                                    echo '  </div>' ;
                                    break ;
                                case "textarea" :
                                    if (isset($pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug])) {
                                        $val = $pageVars["data"]["pipeline"]["settings"][$one_config_slug][$fieldSlug];  }
                                    if (!isset($val)) {
                                        $val = $one_conf_tails["default"] ; }
                                    echo '  <div class="col-sm-12">' ;
                                    echo '      <label for="settings['.$one_config_slug.']['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>' ;
                                    echo '      <textarea name="settings['.$one_config_slug.']['.$fieldSlug.']" id="settings['.
                                        $one_config_slug.']['.$fieldSlug.']" type="text" class="form-control" placeholder="'.
                                        $one_conf_tails["label"].'" >'.$val.'</textarea>' ;
                                    echo '  </div>' ;
                                    break ; }
                            echo '  </div>';}
                        echo '</div>'; } ?>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Steps</h3>
                        </div>
                    </div>

                    <ul class="form-group ui-sortable" id="sortableSteps">

                    <?php $plugins = $pageVars["data"]["plugin"]; $buildconf = $plugins['data'][$plugin]['buildconf'];
                        foreach ($pageVars["data"]["pipeline"]["steps"] as $hash => $one_build_step) {
                            echo '<li class="form-group ui-state-default ui-sortable-handle" id="step'.$hash.'">' ;
                            echo '  <div class="col-sm-2">' ;
                            echo '    <span class="ui-icon ui-icon-arrowthick-2-n-s"></span>' ;
                            echo '  </div>';
                            echo '  <div class="col-sm-10">' ;
                            echo '   <div class="col-sm-12">' ;
                            echo '    <label for="steps['.$hash.'][data]" class="control-label text-left">'.$one_build_step["title"].'</label>' ;
                            echo '      <p><strong>Hash: </strong>'.$hash.'</p>';
                            echo '      <p><strong>Module: </strong>'.$one_build_step["module"].'</p>';
                            echo '      <p><strong>Step Type: </strong>'.$one_build_step["steptype"].'</p>';
                            echo '      <input type="hidden" id="steps['.$hash.'][module]" name="steps['.$hash.'][module]" value="'.$one_build_step["module"].'" />';
                            echo '      <input type="hidden" id="steps['.$hash.'][steptype]" name="steps['.$hash.'][steptype]" value="'.$one_build_step["steptype"].'" />';
                            if ($one_build_step["module"] == "Plugin") { 
                                $buildconf = $plugins['data'][$one_build_step["steptype"]]['buildconf'];
                                foreach ($buildconf as $data ) {
                                    echo '      <label for="'.$data['name'].'">'.$data['name'].'</label>'; 
                                    if ($data['type'] == 'text') {
                                        echo '      <input id="steps['.$hash.']['.$data['name'].']" name="steps['.$hash.']['.$data['name'].']" value="'.$one_build_step[$data['name']].'" class="form-control" />'; 
                                    }
                                    if ($data['type'] == 'textarea') {
                                        echo '      <textarea id="steps['.$hash.']['.$data['name'].']" name="steps['.$hash.']['.$data['name'].']" class="form-control" />'.$one_build_step[$data['name']].'</textarea>'; 
                                    }
                                }
                            }
                            else {
                                echo '      <textarea id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" value="'.$one_build_step["data"].'" class="form-control">'.$one_build_step["data"].'</textarea>';
                            }
                            echo '  </div>';
                            echo '   <div class="col-sm-12">'  ;
                            echo '  <a class="btn btn-warning" onclick="deleteStepField('.hash.')">Delete Step</a>' ;

                            echo '  </div>';
                            echo '  </div>';
                            echo '</li>'; } ?>

                    </ul> <!-- sortable end -->

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <h5>Add New Step</h5>
                            <div class="selectorWrap" id="new_step_module_selector_wrap">
                                <select name="new_step_module_selector" id="new_step_module_selector" onchange="changeModule(this)">
                                    <option value="nomoduleselected" selected="selected">-- Select Module --</option>
                                    <?php
                                        $dataplugin['Plugin'] = $pageVars["data"]["plugin"]["data"];
                                        $pageVars["data"]["fields"] = array_merge($pageVars["data"]["fields"],$dataplugin );
                                        foreach ($pageVars["data"]["fields"] as $builderName => $builderBits) {
                                            echo '  <option value="'.strtolower($builderName).'">'.$builderName.'</option>'; }
                                    ?>
                                </select>
                            </div>
                            <div class="selectorWrap" id="new_step_type_selector_wrap">
                            </div>
                            <div class="buttonWrap" id="new_step_button_wrap">
                            </div>
                            <div class="selectorWrap" id="new_step_wrap">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                        </div>
                    </div>

                    <?php

                    if ($pageVars["route"]["action"] == "new") {
                        echo '<input type="hidden" name="creation" id="creation" value="yes" />' ; }

                    ?>

                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />

                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- container -->



<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" href="/Assets/BuildConfigure/css/buildconfigure.css">
<script type="text/javascript">
    steps = <?php echo json_encode($pageVars["data"]["fields"]) ; ?> ;
</script>
<script type="text/javascript" src="/Assets/BuildConfigure/js/buildconfigure.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#sortableSteps" ).sortable();
        $( "#sortableSteps" ).disableSelection();
    });
</script>