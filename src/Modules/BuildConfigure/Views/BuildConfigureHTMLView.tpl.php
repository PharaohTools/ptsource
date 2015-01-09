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
            <h2 class="text-uppercase text-light"><a href="/">                 Phrankinsense - Pharaoh Tools          </a></h2>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="#">Build Configure <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=some_build_1">Build Home for some_build 1-</a>
                </h5>
                <form class="form-horizontal custom-form">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label text-left">Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Project Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label text-left">Git URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Git URL">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label text-left">Configuration</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Configure</button>
                        </div>
                    </div>
                </form>
                <?php

                foreach ($pageVars["build_steps"] as $build_step) {
                    if ($build_step["hidden"] != true) {
                        echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
                    }
                }

                ?>
                <h5 class="text-uppercase text-light">
                    <a href="/index.php?control=BuildConfigure&action=save&item=some_build_1">Save configuration of some_build 1-</a>
                </h5>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->