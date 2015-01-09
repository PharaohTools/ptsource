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
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment-o"></i> New Pipeline
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-search">Configure Phrankinsense</i>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-user">List Pipelines</i>
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
            <h4 class="text-uppercase text-light">GC cleopetra</h4>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="">Phrankinsense - Pharaoh Tools <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <p>
                    The Build and Monitoring Server built for the Web, in its favourite language.
                    <br/>
                    The home page for a single build
                </p>
            </div>
            <hr>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="/index.php?control=BuildConfigure&action=show&item=some_build_1">Configure some_build 1- <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>

                <p>
                    Build Status Currently:
                    <br/>
                    ---------------------------------------
                </p>
                <p>
                    Build Plugins/features/monitors:
                    <br/>
                    ---------------------------------------
                </p>
                <p>
                    Build Status:
                    <br/>
                    ---------------------------------------
                </p>
                <?php

                foreach ($pageVars["build_history"] as $build_history) {
                    if ($moduleInfo["hidden"] != true) {
                        echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
                    }
                }

                ?>

                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>
            </div>

        </div>

    </div>
</div><!-- /.container -->