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
                <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <!--
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                -->
                <a href="/index.php?control=ScheduledBuild&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                </a>
                <a href="/index.php?control=ScheduledBuild&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Again
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
<!--            <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools </a></h2>-->
            <div class="row clearfix no-margin">
                <?php
                    switch ($pageVars["route"]["action"]) {
                        case "start" :
                            $stat = "Now Executing " ;
                            break ;
                        case "history" :
                            $stat = "Historic Builds of " ;
                            break ;
                        case "summary" :
                            $stat = "Execution Summary of " ;
                            break ; }
                ?>
                <h3><?= $stat; ?> Pipeline <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>

                    <?php
                    if ($pageVars["route"]["action"] == "summary") {
                        echo ', Run '.$pageVars["data"]["historic_build"]["run-id"] ; }
                    ?>

                    <i style="font-size: 18px;" class="fa fa-chevron-right"></i></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"></a>
                </h5>
                <?php
                    if ($pageVars["route"]["action"] != "summary") {
                        $act = '/index.php?control=ScheduledBuild&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=summary' ; }
                    else {
                        $act = '/index.php?control=ScheduledBuild&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=summary&run-id='.$pageVars["data"]["historic_build"]["run-id"]  ; }
                ?>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <?php
                    if (isset($pageVars["pipex"])) {
                        ?>

                        <div class="form-group">
                            <div class="col-sm-10">
                                Pipeline Execution started - Run # <?= $pageVars["pipex"] ;?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div id="updatable">
                                Checking Pipeline Execution Output...
                                <?php
                                if ($pageVars["route"]["action"]=="history") {
                                    echo '<p>Historic builds</p>';
                                    foreach ($pageVars["data"]["historic_builds"] as $hb) {
                                        echo '<a href="/index.php?control=ScheduledBuild&action=summary&item='.$pageVars["data"]["pipeline"]["project-slug"].'&run-id='.$hb.'">'.$hb.'</a><br />' ; } }
                                else if ($pageVars["route"]["action"]=="summary") {
                                    echo '<pre>'.$pageVars["data"]["historic_build"]["out"].'</pre>'; }
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($pageVars["route"]["action"] =="start") {
                        echo '
                          <script type="text/javascript">
                              window.pipeitem = "'.$pageVars["data"]["pipeline"]["project-slug"].'" ;
                              window.runid = "'.$pageVars["pipex"].'" ;
                          </script>
                              <script type="text/javascript" src="/Assets/ScheduledBuild/js/piperunner.js"></script>
                              <div class="form-group" id="loading-holder">
                                  <div class="col-sm-offset-2 col-sm-8">
                                      <div class="text-center">
                                          <img class="loadingImage" src="/Assets/ScheduledBuild/images/loading.gif" />
                                      </div>
                                 </div>
                             </div>'; }
                    ?>

                    <div class="form-group" id="submit-holder">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger" id="end-now">End Now</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="item" value="<?= $pageVars["data"]["pipeline"]["project-slug"] ;?>" />
                    <input type="hidden" id="pid" value="<?= $pageVars["pipex"] ;?>" />
                    <?php
                    if ($pageVars["route"]["action"] == "summary") {
                        echo '<input type="hidden" id="run-id" value="'.$pageVars["data"]["historic_build"]["run-id"].'" />' ; }
                    ?>

                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->
