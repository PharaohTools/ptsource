<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active"> Menu <span class="pull-right" id="slide-submenu">
                    <i class="fa fa-times"></i>
                </span> </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i>All Pipelines
                </a>
                <a href="/index.php?control=BuildConfigure&action=show" class="list-group-item">
                    <i class="fa fa-user"></i>Configure This Pipeline
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Lorem ipsum <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Lorem ipsumr <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> Lorem ipsum
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h4 class="text-uppercase text-light">Pipeline</h4>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="">Phrankinsense - Pharaoh Tools <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <p><?php echo $pageVars["data"]["pipeline"]["project_title"]["label"] ; ?>:
                    <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?></p>
                <p><?php echo $pageVars["data"]["pipeline"]["project_description"]["label"] ; ?>:
                    <?php echo $pageVars["data"]["pipeline"]["project_description"]["value"] ; ?></p>
            </div>
            <hr>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="/index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project_slug"]["value"] ; ?>">
                        Configure Pipeline: <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?>- <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <p>Build Status Currently:</p>
                <div class="pipe-now-status-block pipe-block"></div>
                <p>Build Monitors:</p>
                <div class="pipe-monitor-block pipe-block"></div>
                <p>Build Plugins/Features:</p>
                <div class="pipe-features-block pipe-block"></div>
                <p>Build History:</p>
                <div class="pipe-history-block pipe-block">

                <?php

                foreach ($pageVars["data"]["pipeline"]["build_history"] as $build_history) {
                    if ($moduleInfo["hidden"] != true) {
                        echo '<p><a href="/index.php?control=BuildConfigure&action=show&item=">'.$build_history["count"].' - '.$build_history["status"].' - '.$build_history["message"]."</p>";
                    }
                }

                ?>
                </div>

                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>
            </div>

        </div>

    </div>
</div><!-- /.container -->