<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
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
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                ?>
                <li>
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class=" hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i> Pipeline Home
                    </a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                ?>
                <li>
                    <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-sign-in fa-fw hvr-bounce-in"></i> Run Now
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
<div class="col-lg-9">
                    <div class="well well-lg">

        <?php
        $act = '/index.php?control=BuildConfigure&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>
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
                    <hr>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>Module Settings</h4>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="project-slug" class="col-sm-1 control-label"></label>
                        <div class="col-sm-10">
                    

                    <?php

                    foreach ($pageVars["data"]["settings"] as $one_config_slug => $one_conf_tails) {
                        echo '<div class="form-group confSettingsSlideySection" id="slidey'.$one_config_slug.'">' ;
                        echo '  <div class="col-sm-12">' ;
                        echo '    <label for="config_'.$one_config_slug.'" class="control-label text-left">'.$one_config_slug.':</label>' ;
                        echo '    <i class="fa fa-1x fa-toggle-off" id="slideyToggleIcon'.$one_config_slug.'"' ;
                        echo ' onclick="toggleConfSetting(this, \'slidey'.$one_config_slug.'\')"></i>' ;
                        echo '    <a class="btn-info" id="slideyToggleIcon'.$one_config_slug.'"' ;
                        echo ' onclick="hideConfSetting(\'slidey'.$one_config_slug.'\')"></a>' ;
                        echo '  </div>' ;
                        echo '  <div class="col-sm-12 sliderFields">' ;
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
                                    echo '      <input name="settings['.$one_config_slug.']['.$fieldSlug.']" id="settings['.$one_config_slg.']['.$fieldSlug.']" type="checkbox" '.$onoff.' />' ;
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
                        echo '  </div>';
                        echo '</div>'; } ?>
                    </div>
                    <label for="project-slug" class="col-sm-1 control-label"></label>
                </div>

                               <hr>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Steps</h3>
                        </div>
                    </div>

                    <ul class="form-group ui-sortable" id="sortableSteps">

                    <?php
                        foreach ($pageVars["data"]["pipeline"]["steps"] as $hash => $one_build_step) {
                            echo '<li class="form-group  bg-primary " id="step'.$hash.'">' ;
                            echo '  <div class=" col-sm-2 hvr-grow">' ;
                            echo '    <span class="fa fa-arrows-v fa-1x"></span>' ;
                            echo '  </div><h3>'.$one_build_step["module"].'</h3>';
                            echo '  <div class="col-sm-10">' ;
                            echo '   <div class="form-group col-sm-12">' ;
                            echo '    <!--<label for="steps['.$hash.'][data]" class="control-label text-left">'.$one_build_step["title"].'</label>' ;
                            echo '      <p><strong>Hash: </strong>'.$hash.'</p>';
                            echo '      <p><strong>Module: </strong>'.$one_build_step["module"].'</p>';
                            echo '      <p><strong>Step Type: </strong>'.$one_build_step["steptype"].'</p>-->';
                            echo '      <input type="hidden" id="steps['.$hash.'][module]" name="steps['.$hash.'][module]" value="'.$one_build_step["module"].'" />';
                            echo '      <input type="hidden" id="steps['.$hash.'][steptype]" name="steps['.$hash.'][steptype]" value="'.$one_build_step["steptype"].'" />';
							echo '  	<div>' ;
                            echo ' 		<label for="'.$one_build_step["steptype"].'" class="col-sm-2 control-label text-left">'.$one_build_step["steptype"].'</label>';	
                            echo '		<div class="col-sm-10">';		
                            if ($one_build_step["module"] == "ConditionalStepRunner" || $one_build_step["module"] == "Plugin") {
                                foreach ($pageVars['data']['builders'][$one_build_step["module"]]['fields'][$one_build_step["steptype"]] as $data ) {
                                	echo '      <label for="'.$data['name'].'">'.$data['name'].'</label>'; 
									$action = "";
									if (isset($data['action'])) { $action = $data['action'].'="'.$data['funName'].'(\''.$hash.'\')"'; }
            
                                    if ($data['type'] == 'text' || $data['type'] == 'time' || $data['type'] == 'number') {
                                        echo '      <input id="steps['.$hash.']['.$data['slug'].']" name="steps['.$hash.']['.$data['slug'].']" value="'.$one_build_step[$data['slug']].'" class="form-control" type="'.$data['type'].'" />'; 
                                    }
                                    if ($data['type'] == 'password') {
                                        echo '      <input id="steps['.$hash.']['.$data['slug'].']" name="steps['.$hash.']['.$data['slug'].']" class="form-control" type="password" class="form-control"/>'; 
                                    }
                                    if ($data['type'] == 'textarea') {
                                        echo '      <textarea id="steps['.$hash.']['.$data['slug'].']" name="steps['.$hash.']['.$data['slug'].']" class="form-control">'.$one_build_step[$data['slug']].'</textarea>'; 
                                    }
									if ($data["type"] == "dropdown") {
						            	echo '<select id="steps['.$hash.']['.$data['slug'].']" name="steps['.$hash.']['.$data['slug'].']" '.$action.' class="form-control">';
						            	foreach ($data['data'] as $key => $value) {
						            		$selected = ($one_build_step[$data['slug']] == $key)? 'selected' : '';
											echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
										} 
										echo '</select>';
						            }
									if ($data["type"] == "radio" || $data["type"] == "checkbox") {
						            	foreach ($data['data'] as $key => $value) {
						            		$selected = ($one_build_step[$data['slug']] == $key)? 'checked="checked"' : '';
											echo ' <input type="'.$data["type"].'" name="steps['.$hash.']['.$data["slug"].']" value="'.$key.'" '.$selected.' class="form-control">'.$value;
										}
						            }
									if ($data["type"] == "div") {
						            	echo '<div id="'.$data["id"].$hash.'"></div>';
						            }
						            if (isset($data["funName"]))
										echo '<script> 
												$(document).ready(function() {
													window.onload = CONDaysOfWeekDays(\''.$hash.'\');  
												});
											</script>';
                                }
                            }
                            else {
                                echo '      <textarea id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" class="form-control">'.$one_build_step["data"].'</textarea>';
                            }
                            echo '  </div>';
                            echo '  </div>';
                            echo '  </div>';
							echo '  <div class="form-group">' ;
                            echo ' 		<label for="delete" class="col-sm-2 control-label text-left"></label>';	
                            echo '   <div class="col-sm-10">'  ;
                            echo '  <a class="btn btn-info" onclick="deleteStepField(\''.$hash.'\')">Delete Step</a>' ;
                            echo '  </div>';
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
                                        foreach ($pageVars["data"]["stepFields"] as $builderName => $builderBits) {
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
<link rel="stylesheet" type="text/css" href="/index.php?control=AssetLoader&action=show&module=BuildConfigure&type=css&asset=buildconfigure.css">
<script type="text/javascript">
	savedSteps = <?php echo json_encode($pageVars["data"]["pipeline"]["steps"]) ; ?> ;
    steps = <?php echo json_encode($pageVars["data"]["fields"]) ; ?> ;
</script>
<script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=BuildConfigure&type=js&asset=buildconfigure.js"></script>
<script type="text/javascript">

    $(function() {
        $( "#sortableSteps" ).sortable();
        $( "#sortableSteps" ).disableSelection();
    });
</script>
