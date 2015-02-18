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
                            <span class="pull-right" id="slide-submenu">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=Licensing&action=show" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Licensing <span class="badge">OK</span>
                </a>
                <a href="/index.php?control=UserManager&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> User Manager
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/">PTBuild - Pharaoh Tools</a></h2>
            <div class="row clearfix no-margin">

                <?php
                $act = '/index.php?control=ApplicationConfigure&action=save' ;
                ?>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <h3 class="text-uppercase text-light" style="margin-top: 15px;">
                        Application Configuration <i style="font-size: 18px;" class="fa fa-chevron-right"></i>
                    </h3>

                    <?php

                        if (is_array($pageVars["data"]["app_configs"]) && count($pageVars["data"]["app_configs"]>0)) {
                            foreach ($pageVars["data"]["app_configs"] as $one_config_slug => $one_conf_tails) {
                                echo '<div class="form-group">' ;
                                echo '  <label for="config_'.$one_config_slug.'" class="col-sm-2 control-label text-left">'.$one_conf_tails["label"].':</label>' ;
                                echo '  <div class="col-sm-10">' ;
                                echo '      <p>' ;

                                switch ($one_conf_tails["type"]) {
                                    case "boolean" :

                                        if (isset($pageVars["data"]["current_configs"]["app_config"]["config_".$one_config_slug])) {
                                            if ($pageVars["data"]["current_configs"]["app_config"]["config_".$one_config_slug]=="on") {
                                                $onoff = "checked";  }
                                            else {
                                                $onoff = "" ; } }
                                        $onoff = (is_null($onoff))
                                            ? ""
                                            : $onoff ;
                                        $onoff = ($onoff === true) ? "checked" : $onoff ;
                                        echo '<input name="app_config[config_'.$one_config_slug.']" id="app_config[config_'.$one_config_slug.']" type="checkbox" checked="'.$onoff.'" autocomplete="off" />' ;
                                        break ;
                                    case "text" :
                                        if (isset($pageVars["data"]["current_configs"]["app_config"]["config_".$one_config_slug])) {
                                                $val = $pageVars["data"]["current_configs"]["app_config"]["config_".$one_config_slug]; }
                                        if (!isset($val) && is_null($onoff)) {
                                            $val = $one_conf_tails["default"] ; }
                                        echo '<input name="app_config[config_'.$one_config_slug.']" id="app_config[config_'.$one_config_slug.']" type="text" class="form-control" value="'.$val.'" placeholder="'.$one_conf_tails["label"].'" />' ;                                        break ; }
                                echo '</p>';
                                echo '  </div>';
                                echo '  <div class="col-sm-offset-2 col-sm-10">';
                                echo '  </div>';
                                echo '</div>'; } }
                        else {
                            echo '<div class="form-group">' ;
                            echo '    <p>No Default are providing editable configurations</p>';
                            echo '</div>'; }
                    ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save App Config</button>
                            <button type="submit" class="btn btn-primary">Clear</button>
                            <button type="submit" class="btn btn-warning">Use Defaults</button>
                        </div>
                    </div>

                    <br />

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
                                    echo '  <label for="config_'.$one_config_slug.'" class="col-sm-6 control-label text-left">'.$one_conf_tails["label"].'</label>' ;
                                    echo '  <div class="col-sm-4">' ;
                                    echo '      <p>' ;
                                    switch ($one_conf_tails["type"]) {
                                        case "boolean" :
                                            if (isset($pageVars["data"]["current_configs"]["mod_config"][$module_name]["config_".$one_config_slug])) {
                                                if ($pageVars["data"]["current_configs"]["mod_config"][$module_name]["config_".$one_config_slug] == true) {
                                                    $onoff = "on";  }
                                                else {
                                                    $onoff = "off" ; } }
                                            $onoff = (is_null($onoff))
                                                ? $one_conf_tails["default"]
                                                : null ;
                                            echo '<input name="mod_config['.$module_name.'][config_'.$one_config_slug.']" id="mod_config['.$module_name.'][config_'.$one_config_slug.']" type="checkbox" value="'.$onoff.'" />' ;
                                            break ;
                                        case "text" :
                                            if (isset($pageVars["data"]["current_configs"]["mod_config"][$module_name]["config_".$one_config_slug])) {
                                                $val = $pageVars["data"]["current_configs"]["mod_config"][$module_name]["config_".$one_config_slug];  }
                                            if (!isset($val) && is_null($onoff)) {
                                                $val = $one_conf_tails["default"] ; }
                                            echo '<input name="mod_config['.$module_name.'][config_'.$one_config_slug.']" id="mod_config['.$module_name.'][config_'.$one_config_slug.']" type="text" class="form-control" value="'.$val.'" placeholder="'.$one_conf_tails["label"].'" />' ;
                                            break ; }
                                    echo '</p>';
                                    echo '  </div>';
                                    echo '</div>'; } } }
                        else {
                            echo '<div class="form-group">' ;
                            echo '    <p>No Modules are providing editable configurations</p>';
                            echo '</div>'; }

                    ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save App Config</button>
                            <button type="submit" class="btn btn-primary">Clear</button>
                            <button type="submit" class="btn btn-warning">Use Defaults</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save All Configurations</button>
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
</div><!-- /.container -->