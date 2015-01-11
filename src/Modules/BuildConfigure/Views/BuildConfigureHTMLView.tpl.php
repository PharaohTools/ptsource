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
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> Pipeline Home
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> All Pipelines
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="#">Build Configure <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project_slug"]["value"] ; ?>">
                        Pipeline Summary for <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?>-</a>
                </h5>
                <form class="form-horizontal custom-form">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label text-left">Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Project Name" value="<?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label text-left">Git URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Git URL" value="<?php echo $pageVars["data"]["pipeline"]["git_url"]["value"] ; ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label text-left">Configuration</label>
                        <div class="col-sm-10">
                            <textarea class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Steps</h3>
                        </div>
                    </div>
                    <?php
                        foreach ($pageVars["data"]["pipeline"]["steps"] as $one_build_step) {
                            echo '<div class="form-group">' ;
                            echo '  <label for="inputPassword3" class="col-sm-2 control-label text-left">'.$one_build_step["title"].'</label>' ;
                            echo '  <div class="col-sm-10">' ;
                            echo '      <p>'.$one_build_step["title"].'</p>';
                            echo '      <p>Step Type: '.$one_build_step["type"]."</p>";
                            echo '      <textarea class="form-control">'.$one_build_step["value"].'</textarea>';
                            echo '  </div>';
                            echo '</div>'; }
                    ?>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-info">Configure</button>
                        </div>
                    </div>
                    <h5 class="text-uppercase text-light">
                        <a href="/index.php?control=BuildConfigure&action=save&item=<?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?>">
                            Save configuration of <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?>-</a>
                    </h5>
                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->