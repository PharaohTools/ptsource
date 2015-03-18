<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
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
                    <a href="/index.php?control=Index&action=show">
                        <i class="fa fa-dashboard fa-fw"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=Licensing&action=show">
                        <i class="fa fa-bar-chart-o"></i> Licensing <span class="badge">OK</span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show">
                        <i class="fa fa-group"></i> User Manager
                      
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show">
                        <i class="fa fa-suitcase"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9">
                    <div class="well well-lg">         
                    	<h2 class="text-uppercase text-light"><a href="/">PTBuild - Pharaoh Tools</a></h2>
            <div class="row clearfix no-margin">

                <?php
                $act = '/index.php?control=ApplicationConfigure&action=save' ;
                ?>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">


                    <h3 class="text-uppercase text-light" style="margin-top: 15px;">
                        Module Configuration <i style="font-size: 18px;" class="fa fa-chevron-right"></i>
                    </h3>

                    <?php

                        if (is_array($pageVars["data"]["mod_configs"]) && count($pageVars["data"]["mod_configs"]>0)) {
                            foreach ($pageVars["data"]["mod_configs"] as $module_name => $one_mod_confs) {
                                echo '  <div class="col-sm-10">' ;
                                echo '      <h4>Module: '.$module_name.'</h4>';
                                echo '  </div>';
                                foreach ($one_mod_confs as $one_config_slug => $one_conf_tails) {
                                    echo '<div class="form-group">' ;
                                    echo '  <label for="'.$one_config_slug.'" class="col-sm-6 control-label text-left">'.$one_conf_tails["label"].'</label>' ;
                                    echo '  <div class="col-sm-4">' ;
                                    switch ($one_conf_tails["type"]) {
                                        case "boolean" :
                                            if ( (isset($pageVars["data"]["current_configs"]["mod_config"][$module_name]["".$one_config_slug])) &&
                                                $pageVars["data"]["current_configs"]["mod_config"][$module_name]["".$one_config_slug] == "on" ) {
                                                $onoff = "on" ; }
                                            else if ( (isset($pageVars["data"]["current_configs"]["mod_config"][$module_name][$one_config_slug])) &&
                                                $pageVars["data"]["current_configs"]["mod_config"][$module_name][$one_config_slug] != "on" ) {
                                                $onoff = "off" ; }
                                            else {
                                                $onoff = (!isset($onoff) || is_null($onoff))
                                                    ? $one_conf_tails["default"]
                                                    : $onoff ; }
                                            if ($onoff === "on") { $onoff = 'checked="checked"' ;}
                                            else {$onoff = "" ;}
                                            echo '<input name="mod_config['.$module_name.']['.$one_config_slug.']" id="mod_config['.$module_name.']['.$one_config_slug.']" type="checkbox" '.$onoff.' />' ;
                                            break ;
                                        case "text" :
                                            if (isset($pageVars["data"]["current_configs"]["mod_config"][$module_name][$one_config_slug]) &&
                                                strlen($pageVars["data"]["current_configs"]["mod_config"][$module_name][$one_config_slug])>0) {
                                                $val = ' value="'.$pageVars["data"]["current_configs"]["mod_config"][$module_name][$one_config_slug].'" ';  }
                                            else {
                                                $val = "" ; }
                                            if ($val == "" || is_null($val)) {
                                                $placeholder = ' placeholder="'.$one_conf_tails["default"].'" ' ; }
                                            echo '<input name="mod_config['.$module_name.']['.$one_config_slug.']" id="mod_config['.$module_name.']['.$one_config_slug.']" type="text" class="form-control" '.$val.' '.$placeholder.' ></input>' ;
                                            break ; }
                                    echo '  </div>';
                                    echo '</div>'; } } }
                        else {
                            echo '<div class="form-group">' ;
                            echo '    <p>No Modules are providing editable configurations</p>';
                            echo '</div>'; }

                    ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                            <button type="submit" class="btn btn-primary">Clear</button>
                            <button type="submit" class="btn btn-warning">Use Defaults</button>
                        </div>
                    </div>

                </form>

            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

    </div>

</div>
