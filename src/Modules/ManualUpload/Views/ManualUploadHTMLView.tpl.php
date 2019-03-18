<div class="container" id="wrapper">

    <div class="col-lg-12">
        <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
            <div class="sidebar-nav ">
                <div class="sidebar-search">
                    <button class="btn btn-success" id="menu_visibility_label" type="button">
                        Show Menu
                    </button>
                    <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
                </div>
                <ul class="nav in" id="side-menu">

                    <li>
                        <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-home hvr-bounce-in"></i>  Repository Home
                        </a>
                    </li>
                    <?php

                    if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                        ?>
                        <li>
                            <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                            </a>
                        </li>

                        <?php

                    }

                    ?>

                    <li>
                        <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryReleases&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Releases <span class="badge"></span>
                        </a>
                    </li>

                    <?php
                    if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                        ?>

                        <li>
                            <a href="index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                            </a>
                        </li>

                        <?php
                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="well well-lg">
            <div class="row clearfix no-margin">
                <?php
                    switch ($pageVars["route"]["action"]) {
                        case "show" :
                            $stat = "Manual Upload to " ;
                            break ;
                    }
                ?>
                <h2>
                    <?= $stat; ?> Repository <?php echo $pageVars["data"]["repository"]["project-name"] ; ?>
                </h2>

                <?php
                    $rootPath = str_replace($pageVars["data"]["relpath"], "", $pageVars["data"]["wsdir"]) ;
                    echo '<h3><a href="/index.php?control=ManualUpload&action=show&item='.
                         $pageVars["data"]["repository"]["project-slug"].'">'.$rootPath.'</a></h3>' ;

                    $act = '/index.php?control=ManualUpload&item='.$pageVars["data"]["repository"]["project-slug"].'&action=show' ;
                ?>

                <div class="form-group col-sm-12" id="ajaxMessages">
                </div>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group col-sm-12">
                        <label for="version">Customize Version Number:</label>
                        <input type="text" name="version" id="version" value="<?php echo $pageVars["data"]["next_version"] ; ?>" onchange="setDZOptions(this); return false;" />
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10" id="updatable">

                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" name="itemid" id="itemid" />

                </form>
                <div class="form-group">
                    <div class="col-sm-10">
                        <form action="/index.php?control=ManualUpload&action=fileupload&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>&output-format=SERVICE" class="dropzone" id="manualUpload-drop"></form>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div><!-- /.container -->
<script type="text/javascript" src="/Assets/Modules/ManualUpload/js/dropzone.js"></script>
<script type="text/javascript" src="/Assets/Modules/ManualUpload/js/dropzone-options.js"></script>
<script type="text/javascript" src="/Assets/Modules/ManualUpload/js/manual_upload.js"></script>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/ManualUpload/css/manual_upload.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/ManualUpload/css/dropzone.css">
