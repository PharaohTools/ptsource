
<script type="text/javascript" src="/Assets/Modules/RepositoryConfigure/js/repositoryconfigure.js"></script>
<script type="text/javascript" src="/Assets/Modules/RepositoryConfigure/js/repositoryconfigure_settings.js"></script>
<div class="container" id="wrapper">
<div class="col-lg-12">
    <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <div class="sidebar-search">
                <button class="btn btn-success" id="menu_visibility_label" type="button">
                    Show Menu
                </button>
                <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
            </div>
            <ul class="nav in" id="side-menu">
                <li>
                    <a href="/index.php?control=Index&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                    ?>
                    <li>
                        <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-home hvr-bounce-in"></i> Repository Home
                        </a>
                    </li>
                    <?php
                }
                ?>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                    ?>
                    <li>
                        <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                        </a>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
    </div>
                    <div class="well well-lg">

        <?php
        $act = '/index.php?control=RepositoryConfigure&item='.$pageVars["data"]["repository"]["project-slug"].'&action=save' ;
        ?>

            <?php echo $this->renderLogs() ; ?>

            <script type="text/javascript">
                build_settings_fieldsets = [] ;
            </script>

            <div class="row clearfix no-margin">

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Repository Settings</h3>
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
                            <input type="text" class="form-control" name="project-name" id="project-name" placeholder="Project Name" value="<?php echo $pageVars["data"]["repository"]["project-name"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left">Project Slug</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-slug" id="project-slug" placeholder="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" value="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left">Project Owner</label>

                        <div class="col-sm-10">
                            <?php

                            if ($pageVars["data"]["current_user_data"] !== false && ($pageVars["data"]["current_user_data"]->role == 1)) {
                                ?>


                                <div class="col-sm-3">
                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                            Select Owner
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" id="ownerlist" role="menu" aria-labelledby="dropdownMenu1">
                                            <?php

                                            foreach($pageVars["data"]["available_users"] as $ownerSlug) {
                                                ?>
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" onclick="switchOwnerButton('<?php echo $ownerSlug ; ?>'); return false;">
                                                        <?= $ownerSlug ; ?>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>

                                        <?php
                                        echo '<script type="text/javascript">'."\n";
                                        echo '  window.avOwners = []; '."\n";
                                        foreach($pageVars["data"]["available_users"] as $ownerSlug) {
                                            echo '  window.avOwners["'.$ownerSlug.'"] = "'.$ownerSlug.'" ;'."\n"; }
                                        echo '  console.log(window.avOwners)'."\n";
                                        echo '</script>'."\n";;

                                        ?>
                                    </div>
                                </div>

                                <div class="col-sm-3" id="newOwnerDiv">

                                    <?php
                                    $allOwners = $pageVars["data"]["available_users"] ;
                                    foreach ($allOwners as $oneOwner) {
                                        if ($oneOwner == $pageVars["data"]["repository"]["project-owner"]) {
                                            $owner = $oneOwner ; } }

                                    if (isset($owner)) {
                                        ?>

                                        <div class="btn btn-success" value="<?php echo $owner ; ?>"><?php echo $owner ; ?></div>
                                        <input type="hidden" name="project-owner" id="project-owner" value="<?php echo $pageVars["data"]["repository"]["project-owner"] ; ?>" />
                                        <!--                                    <p>Owner Currently: </p>-->

                                    <?php
                                    }
                                    ?>

                                </div>


                                <?php
                            }

                            else {
                                if ($pageVars["route"]["action"] == "new") {
                                    ?>
                                    <h5 id="project-owner"><?php echo $pageVars["data"]["current_user_data"]['username'] ; ?></h5>

                                <?php

                                } else {
                                    ?>
                                    <p id="project-owner"><?php echo $pageVars["data"]["repository"]["project-owner"] ; ?></p>
                                <?php
                                }

                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-description" class="col-sm-2 control-label text-left">Description</label>
                        <div class="col-sm-10">
                            <textarea id="project-description" name="project-description" class="form-control"><?php echo $pageVars["data"]["repository"]["project-description"] ; ?></textarea>
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

                                    displaySingleFieldSet($one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $pageVars["data"]["repository"]["settings"], $singleFieldSlug) ;

                                    ?>
                                        <div class="btn btn-success" onclick='displayRepositoryConfigureSettingsFieldset("<?php echo $one_config_slug ; ?>", "<?php echo $singleFieldSlug ; ?>")'>
                                            Add Fieldset: <strong><?php echo "$one_config_slug, {$singleFieldSlug}" ; ?></strong></div>
                                    <?php

                                    }

                                    }
                                else {
                                    displaySingleField($one_config_slug, $one_conf_tails, $fieldSlug, $fieldInfo, $pageVars["data"]["repository"]["settings"]) ; }

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
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="bt" class=" btn btn-success hvr-float-shadow" data-toggle="tooltip" data-placement="top" title="Save configure" data-original-title="Tooltip on right">Save Configuration</button>
                        </div>
                    </div>

                    <?php

                    if ($pageVars["route"]["action"] == "new") {
                        echo '<input type="hidden" name="creation" id="creation" value="yes" />'."\n" ; }

                    ?>

                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" />

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
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryConfigure/css/repositoryconfigure.css">

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
                    if (isset($fieldInfo["default"])) {
                        $onoff = (!isset($onoff))
                            ? $fieldInfo["default"]
                            : $onoff ; }
                    else {
                        $onoff = "off" ; } } }
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
            $label = (isset($one_conf_tails["label"])) ? $one_conf_tails["label"] : "" ;
            echo '  <div class="col-sm-12 field_text'.$hash_score_string.'">'."\n" ;
            echo '      <label for="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>'."\n" ;
            echo '      <input name="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" id="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" type="text" class="form-control '.$fieldSlug.'" value="'.
                $val.'" placeholder="'.$label.'" />'."\n" ;
            echo '  </div>'."\n" ;
            break ;
        case "textarea" :
            if ($val==null) {
                if (isset($settings[$one_config_slug][$fieldSlug])) {
                    $val = $settings[$one_config_slug][$fieldSlug];  }
                if (!isset($val)) {
                    $val = $one_conf_tails["default"] ; } }
            $label = (isset($one_conf_tails["label"])) ? $one_conf_tails["label"] : "" ;
            echo '  <div class="col-sm-12 field_textarea'.$hash_score_string.'">'."\n" ;
            echo '      <label for="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" class="control-label text-left">'.$fieldInfo["name"].':</label>'."\n" ;
            echo '      <textarea name="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" id="settings['.$one_config_slug.']'.$field_slug_hash_string.'['.$fieldSlug.']" type="text" class="form-control '.$fieldSlug.'" placeholder="'.
                $label.'" >'.$val.'</textarea>'."\n" ;
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