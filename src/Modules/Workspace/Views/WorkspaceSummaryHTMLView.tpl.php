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
                <a href="/index.php?control=Workspace&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project_slug"]["value"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Again
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
<!--            <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools </a></h2>-->
            <div class="row clearfix no-margin">
                <?php
                    $stat = ($pageVars["route"]["action"] == "start") ? "Now Executing " : "Execution Summary of " ;
                ?>
                <h3><?= $stat; ?> Pipeline <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?> <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project_slug"]["value"] ; ?>"></a>
                </h5>
                <form class="form-horizontal custom-form" action="/index.php?control=Workspace&action=show" method="POST">

                    <?php
                    if (isset($pageVars["pipex"])) {
                        ?>

                        <div class="form-group">
                            <div class="col-sm-10">
                                Pipeline Execution started - PID <?= $pageVars["pipex"] ;?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <div id="updatable">
                                Checking Pipeline Execution Output...
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript" src="/Assets/Workspace/js/workspace.js"></script>

                    <div class="form-group" id="loading-holder">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <img class="loadingImage" src="/Assets/Workspace/images/loading.gif" />'
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="submit-holder">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger" id="end-now">End Now</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="item" value="<?= $pageVars["data"]["pipeline"]["project_slug"]["value"] ;?>" />
                    <input type="hidden" id="pid" value="<?= $pageVars["pipex"] ;?>" />

                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->