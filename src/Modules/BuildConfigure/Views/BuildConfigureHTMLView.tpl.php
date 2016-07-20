
<script type="text/javascript" src="/Assets/Modules/BuildConfigure/js/buildconfigure.js"></script>
<script type="text/javascript" src="/Assets/Modules/BuildConfigure/js/buildconfigure_settings.js"></script>
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
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i> Pipeline Home
                    </a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                ?>
                <li>
                    <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
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
<!--            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>-->

            <?php echo $this->renderLogs() ; ?>

            <script type="text/javascript">
                build_settings_fieldsets = [] ;
            </script>

            <div class="row clearfix no-margin">

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

                        <div class="col-sm-12">
                            <div class="col-sm-12">
                                <span class="scroll-mods-top-inner" onclick="modsUp()">
                                    <i class="fa fa-2x fa-arrow-circle-up"></i>
                                </span>
                            </div>
                            <div class="col-sm-12 settingsScroller resizable">
                                <div class="slideysWrapper">


                        <?php


                        foreach ($pageVars["data"]["settings"] as $one_config_slug => $one_conf_tails) {
                            echo '<div class="form-group confSettingsSlideySection" id="slidey'.$one_config_slug.'">'."\n" ;
                            echo '  <div class="col-sm-12">'."\n" ;
                            echo '    <label for="config_'.$one_config_slug.'" class="control-label text-left">'.$one_config_slug.':</label>'."\n" ;
                            echo '    <i class="fa fa-1x fa-toggle-off hvr-grow" id="slideyToggleIcon'.$one_config_slug.'"'."\n" ;
                            echo ' onclick="toggleConfSetting(this, \'slidey'.$one_config_slug.'\')"></i>'."\n" ;
                            echo '    <a class="btn-info" id="slideyToggleIcon'.$one_config_slug.'"'."\n" ;
                            echo ' onclick="hideConfSetting(\'slidey'.$one_config_slug.'\')"></a>'."\n" ;
                            echo '  </div>'."\n" ;
                            echo '  <div class="col-sm-12 sliderFields">'."\n" ;

                            foreach ( $one_conf_tails["settings"] as $fieldSlug => $fieldInfo) {

                                if ($fieldSlug=="fieldsets") {

                                    foreach ( $fieldInfo as $singleFieldSlug => $singleFieldInfo) {

                                    displaySingleFieldSet($one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $pageVars["data"]["pipeline"]["settings"], $singleFieldSlug) ;

                                    ?>
                                        <div class="btn btn-success" onclick='displayBuildConfigureSettingsFieldset("<?php echo $one_config_slug ; ?>", "<?php echo $singleFieldSlug ; ?>")'>
                                            Add Fieldset: <strong><?php echo "$one_config_slug, {$singleFieldSlug}" ; ?></strong></div>
                                    <?php

                                    }

                                    }
                                else {
                                    displaySingleField($one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $pageVars["data"]["pipeline"]["settings"]) ; }

                            }

                            echo '  </div>';
                            echo '</div>'; } ?>
                                </div>
                        </div>
                        <div class="col-sm-12">
                            <span class="scroll-mods-bottom-inner" onclick="modsDown()" >
                                <i class="fa fa-2x fa-arrow-circle-down"></i>
                            </span>
                        </div>
                    </div>
                    <label for="project-slug" class="col-sm-1 control-label"></label>
                </div>

                               <hr />
                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Steps</h3>
                        </div>
                    </div>

                    <ul class="form-group ui-sortable" id="sortableSteps">

                    <?php
                        if (is_array($pageVars["data"]["pipeline"]["steps"]) && count($pageVars["data"]["pipeline"]["steps"])>0) {

                            foreach ($pageVars["data"]["pipeline"]["steps"] as $hash => $one_build_step) {
                                echo '<li class="form-group  bg-primary singleBuildStep" id="step'.$hash.'">'."\n" ;
                                echo '  <h3>'.$one_build_step["module"].'</h3>'."\n" ;
//                                echo '  <div class="col-sm-12">'."\n" ;
                                echo '  <div class="form-group col-sm-12">'."\n" ;
//                                echo '    <label for="steps['.$hash.'][data]" class="control-label step_subtitle">'.$one_build_step["title"].'</label>'."\n" ;
//                                echo '  	<div>'."\n" ;

                                echo '       <p><strong>Hash: </strong>'.$hash.'</p>';
//                                echo '      <p><strong>Module: </strong>'.$one_build_step["module"].'</p>';
                                echo '      <p><strong>Step Type: </strong>'.$one_build_step["steptype"].'</p>';
                                echo '      <input type="hidden" id="steps['.$hash.'][module]" name="steps['.$hash.'][module]" value="'.$one_build_step["module"].'" />';
                                echo '      <input type="hidden" id="steps['.$hash.'][steptype]" name="steps['.$hash.'][steptype]" value="'.$one_build_step["steptype"].'" />';
                                echo '  <div>'."\n" ;
//                                echo ' 		<label for="'.$one_build_step["steptype"].'" class="col-sm-2 control-label text-left">'.$one_build_step["steptype"].'</label>';
                                echo '		<div class="col-sm-14">';
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
//                                    var_dump($pageVars['data']['builders'][$one_build_step["module"]]['fields'][$one_build_step["steptype"]]["type"] ) ;
                                    $data = $pageVars['data']['builders'][$one_build_step["module"]]['fields'][$one_build_step["steptype"]] ;


                                    if ($data['type'] == 'text' || $data['type'] == 'time' || $data['type'] == 'number') {
                                        echo '      <input id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" value="'.$one_build_step["data"].'" class="form-control" type="'.$data['type'].'" />';
                                    }

                                    if ($data['type'] == 'textarea') {
//                                        echo '      <textarea id="steps['.$hash.']['.$data['slug'].']" name="steps['.$hash.']['.$data['slug'].']" class="form-control">'.$one_build_step[$data['slug']].'</textarea>';
                                        echo '      <textarea id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" class="form-control buildStepTextArea">'.$one_build_step["data"].'</textarea>';
                                    }
                                    if ($data["type"] == "dropdown") {
                                        echo '<select id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" '.$action.' class="form-control">';
                                        foreach ($data['data'] as $key => $value) {
                                            $selected = ($one_build_step["data"] == $key)? 'selected' : '';
                                            echo '<option '.$selected.' value="'.$key.'">'.$value.'</option>';
                                        }
                                        echo '</select>';
                                    }
                                    if ($data["type"] == "radio") {

//                                        foreach ($data['data'] as $key => $value) {
                                        $selected = ($one_build_step["data"] == "on")? 'checked="checked"' : '';
                                        echo ' <input type="'.$data["type"].'" id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" value="'.$key.'" '.$selected.' class="form-control">'.$value;
//                                        }
                                    }
                                    if ($data["type"] == "boolean" || $data["type"] == "checkbox") {

//                                        foreach ($data['data'] as $key => $value) {
                                        $selected = ($one_build_step["data"] == "on")? 'checked="checked"' : '';
                                        echo ' <input type="checkbox" id="steps['.$hash.'][data]" name="steps['.$hash.'][data]" '.$selected.' class="form-control">'.$value;
//                                        }
                                    }


                                }
                                echo '  </div>';
//                                echo '  </div>';
                                echo '  <div class="col-sm-12">'  ;
                                echo '    <a class="btn btn-info" onclick="deleteStepField(\''.$hash.'\')">Delete Step</a>'."\n" ;
                                echo '  </div>';
//                                echo '  </div>';
//                                echo '  </div>';
                                echo '</li>'; } } ?>
                                    
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
                            <button type="submit" id="bt" class=" btn btn-success hvr-float-shadow" data-toggle="tooltip" data-placement="top" title="Save configure" data-original-title="Tooltip on right">Save Configuration</button>
                        </div>
                    </div>

                    <?php

                    if ($pageVars["route"]["action"] == "new") {
                        echo '<input type="hidden" name="creation" id="creation" value="yes" />'."\n" ; }

                    ?>

                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />

                </form>
            </div>
             <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

        </div>

    </div>
</div><!-- container -->



<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/BuildConfigure/css/buildconfigure.css">
<script type="text/javascript">
	savedSteps = <?php echo json_encode($pageVars["data"]["pipeline"]["steps"]) ; ?> ;
    steps = <?php echo json_encode($pageVars["data"]["fields"]) ; ?> ;
</script>
<script type="text/javascript">

    $(function() {
        $( "#sortableSteps" ).sortable();
       // $( "#sortableSteps" ).disableSelection();
    });
</script>


<?php

function displaySingleField($one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $settings=null, $val=null, $field_hash=null, $fieldset=null) {

    if ($field_hash==null) {
        $fieldset_id = "" ;
        $field_slug_hash_string = "" ;
        $hash_score_string = "" ; }
    else {
        $fieldset_id = "[$fieldset][$field_hash]" ;
        $field_slug_hash_string = "[$fieldset][$field_hash]" ;
        $hash_score_string = "_$fieldSlug" ; }

    switch ($fieldInfo["type"]) {
        case "boolean" :
            if ( (isset($settings[$one_config_slug][$fieldSlug])) &&
                $settings[$one_config_slug][$fieldSlug] == "on" ) {
                $onoff = "on" ; }
            else if ( (isset($settings[$one_config_slug][$fieldSlug])) &&
                $settings[$one_config_slug][$fieldSlug] != "on" ) {
                $onoff = "off" ; }
            else {
                if ($val==null) {
                $onoff = (!isset($onoff))
                    ? $fieldInfo["default"]
                    : $onoff ; } }
            if ($onoff === "on") { $onoff = 'checked="checked"'."\n" ;}
            else {$onoff = "" ;}
            echo '  <div class="col-sm-12 field_boolean'.$hash_score_string.'">'."\n" ;
            echo '      <label for="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>'."\n" ;
            echo '      <input name="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" id="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" type="checkbox" class="'.$fieldSlug.'" '.$onoff.' />'."\n" ;
            echo '  </div>'."\n" ;
            break ;
        case "text" :
            if ($val==null) {
                if (isset($settings[$one_config_slug][$fieldSlug])) {
                    $val = $settings[$one_config_slug][$fieldSlug];  }
                if (!isset($val)) {
                    $val = $one_conf_tails["default"] ; } }
            echo '  <div class="col-sm-12 field_text'.$hash_score_string.'">'."\n" ;
            echo '      <label for="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>'."\n" ;
            echo '      <input name="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" id="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" type="text" class="form-control '.$fieldSlug.'" value="'.
                $val.'" placeholder="'.$one_conf_tails["label"].'" />'."\n" ;
            echo '  </div>'."\n" ;
            break ;
        case "textarea" :
            if ($val==null) {
                if (isset($settings[$one_config_slug][$fieldSlug])) {
                    $val = $settings[$one_config_slug][$fieldSlug];  }
                if (!isset($val)) {
                    $val = $one_conf_tails["default"] ; } }
            echo '  <div class="col-sm-12 field_textarea'.$hash_score_string.'">'."\n" ;
            echo '      <label for="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>'."\n" ;
            echo '      <textarea name="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" id="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" type="text" class="form-control '.$fieldSlug.'" placeholder="'.
                $one_conf_tails["label"].'" >'.$val.'</textarea>'."\n" ;
            echo '  </div>'."\n" ;
            break ;
        case "options" :
            if ($val==null) {
                if (isset($settings[$one_config_slug][$fieldSlug])) {
                    $val = $settings[$one_config_slug][$fieldSlug];  }
                else if (!isset($val) && isset($one_conf_tails["default"]) ) {
                    $val = $one_conf_tails["default"] ; }
                else {
                    $val = "" ; } }

            echo ' <div class="col-sm-12 wrap_'.$fieldSlug.'_'.$field_hash.'">'."\n" ;
            echo ' <div class="col-sm-4">'."\n" ;
            echo '   <h4>'.$fieldInfo["name"].'</h4>'."\n" ;
            echo ' </div>'."\n" ;
            echo ' <div class="col-sm-5">';
            echo '    <button aria-expanded="true" data-toggle="dropdown" id="dropdownMenu_'.$fieldSlug.'_'.$field_hash.'" type="button" class="btn btn-info dropdown-toggle"> ';
            echo '      Select Option ';
//            echo '   <span class="caret"></span> ';
            echo '    </button>' ;
            echo '   <ul aria-labelledby="dropdownMenu_'.$fieldSlug.'_'.$field_hash.'" role="menu" class="dropdown-menu" >'."\n" ;
            $selected_string = "" ;
            foreach ($fieldInfo["options"] as $option) {
                if ($val == $option) { $selected_string = 'active ' ; }
                $changestring = "" ;
                if (isset($fieldInfo["js_change_function"])) {
                    $changestring = ' onclick="'.$fieldInfo["js_change_function"]."('".$field_hash."', '".$option."');\"" ; }
                echo '    <li role="presentation"> ';
                echo '      <a class="'.$selected_string.'" '.$changestring.' tabindex="-1" role="menuitem">'.$option.'</a>' ;
                echo '    </li> '; }
            echo '  </ul>'."\n" ;
            echo '</div>'."\n" ;
            echo '<div class="col-sm-3">'."\n" ;
            echo '  <input type="text" name="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_type]" ';
            echo ' id="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_type]"  class="btn btn-success options_display" value="'.$val.'" />' ;
            $orig_opt_str = implode("," , $fieldInfo["options"]) ;

//            echo '<input type="hidden" name="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_type]" ';
//            echo ' id="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_type]" class="param_type" value="'.$val.'" />' ;
            echo '<input type="hidden" name="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_original_options]" ';
            echo ' id="settings['.$one_config_slug.']'.$field_slug_hash_string.'[param_original_options]" class="param_original_options" value="'.$orig_opt_str.'" />' ;

            // @todo this should be an event or something
            if ($one_config_slug == "PipeRunParameters") {
                echo '  <script type="text/javascript">'."\n" ;
                echo '      $( document ).ready(function() {'."\n" ;
                echo '          changePipeRunParameterType("'.$field_hash.'", "'.$val.'") ;'."\n" ;
                echo '      });'."\n" ;
                echo '  </script>'."\n" ;  }

            echo '</div>'."\n" ;
            echo '</div>'."\n" ;
            break ; }
}


function displaySingleFieldSet( $one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $settings ) {

    echo '<script type="text/javascript">'."\n" ;
    echo '  build_settings_fieldsets["'.$one_config_slug.'"] = [] ; '."\n" ;
    echo '</script>'."\n" ;

//    var_dump($fieldInfo) ;

    foreach ($fieldInfo as $fieldSetSlug => $fieldSetDetails) {

        echo '<div class="form-group" class="fieldset" id="fieldsets_'.$one_config_slug.'_'.$fieldSetSlug.'">' ;

        echo '<script type="text/javascript">'."\n" ;
        $json_fieldset =
             '  build_settings_fieldsets["'.$one_config_slug.'"]["'.$fieldSetSlug.'"] = ' .
            json_encode($fieldInfo)." ;" ;
        echo $json_fieldset ;
        echo '</script>'."\n" ;

        $hashes = array_keys($settings[$one_config_slug][$fieldSetSlug]) ;

        foreach($hashes as $field_hash) {
            echo '  <div class="col-sm-12" id="fieldset_'.$one_config_slug.'_'.$fieldSetSlug.'_'.$field_hash.'">'."\n" ;
            foreach ($fieldSetDetails as $singleFieldSlug => $fieldDetail) {
                displaySingleField(
                    $one_config_slug,
                    $one_conf_tails,
                    $singleFieldSlug,
                    $fieldDetail,
                    $settings,
                    $settings[$one_config_slug][$fieldSetSlug][$field_hash][$singleFieldSlug],
                    $field_hash,
                    $fieldSetSlug ) ;}
//            echo '    <script type="text/javascript">'."\n" ;
//            echo '      changePipeRunParameterType("'.$field_hash.'", "'.$fieldSetSlug.'") ;'."\n" ;
//            echo '    </script>'."\n" ;
            echo '    <div class="col-sm-12">' ;
            echo '        <a class="btn btn-warning" onclick="deleteFieldsetField(\''.$one_config_slug.'\', \''.$fieldSetSlug.'\', \''.$field_hash.'\')">Delete Fieldset</a>' ;
            echo '    </div>' ;
            echo '  </div>'; }
        echo '</div>' ;
    }
}

?>