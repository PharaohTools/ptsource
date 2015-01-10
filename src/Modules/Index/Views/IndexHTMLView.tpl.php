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
                <a href="/index.php?control=BulidConfigure&action=new" class="list-group-item">
                    <i class="fa fa-comment-o"></i> New Pipeline
                </a>
                <a href="/index.php?control=ApplicationConfigure&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> Configure Phrankinsense
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i>All Pipelines
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
            <h4 class="text-uppercase text-light">Pharaoh Tools</h4>
            <div class="row clearfix no-margin">
                <h3>
                    <a class="lg-anchor text-light" href="">
                        Phrankinsense - The Builder <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <p>
                    Build and Monitoring Server in PHP.
                    <br/>
                    Can be used to set up monitoring of any application feature in minutes.
                    <br/>
                    Create simple or complex build pipelines fully integrated with pharaoh tools
                    <br/>
                    Using Convention over Configuration, a lot of common build tasks can be completed with little or
                    no extra implementation work.
                 </p>
            </div>
            <hr>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>

                <p>
                    Available Commands:
                </p>

                <p>
                    ---------------------------------------
                </p>
                <?php

                foreach ($pageVars["modulesInfo"] as $moduleInfo) {
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