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
                <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors
                </a>
                <a href="/index.php?control=Workspace&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                </a>
                <a href="/index.php?control=Workspace&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Again
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">
                <?php
                    switch ($pageVars["route"]["action"]) {
                        case "show" :
                            $stat = "Workspace From " ;
                            break ; }
                ?>
                <h3><?= $stat; ?> Pipeline <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?></h3>
                <?php
                    $rootPath = str_replace($pageVars["data"]["relpath"], "", $pageVars["data"]["wsdir"]) ;
                    echo '<h3><a href="/index.php?control=Workspace&action=show&item='.
                         $pageVars["data"]["pipeline"]["project-slug"].'">'.$rootPath.'</a></h3>' ;

                    $act = '/index.php?control=Workspace&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=show' ;
                ?>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <div id="updatable">
                                 <?php
                                if ($pageVars["route"]["action"]=="show") {
                                    foreach ($pageVars["data"]["directory"] as $name => $isDir) {

                                        $dirString = ($isDir) ? " - (D)" : "" ;
                                        $trail = ($isDir) ? "/" : "" ;
                                        echo '<a href="/index.php?control=Workspace&action=show&item='.$pageVars["data"]["pipeline"]["project-slug"].'&relpath='.$pageVars["data"]["relpath"].'">'.$pageVars["data"]["relpath"].'</a>' ;

                                        $relativeString = str_replace($pageVars["data"]["wsdir"], "", $name) ;
                                        $nameparts = explode(DS, $relativeString) ;

                                        foreach ($nameparts as $namepart => $isSubDir) {
                                            echo '<a href="/index.php?control=Workspace&action=show&item='.$pageVars["data"]["pipeline"]["project-slug"].'&relpath='.$pageVars["data"]["relpath"].$name.
                                                $trail.'">'.$name.'</a>' ; }

                                        echo $trail.$dirString.'<br />' ; } }
                                ?>
                            </div>
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