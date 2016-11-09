<div class="container" id="wrapper">
       
        <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
			<ul class="nav in" id="side-menu">


                <?php

                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                ?>
                <li>
                    <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
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
                    <a href="index.php?control=RepositoryMonitor&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in""></i> History <span class="badge"></span>
                    </a>
                </li>

                <?php

                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                    ?>

                    <li>
                        <a href="index.php?control=CommitDetails&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in""></i> Delete
                        </a>
                    </li>

                <?php

                }
                ?>

            </ul>
        </div>
        </div>
    
        <div class="col-lg-9">

            <div class="well well-lg ">
           
            <div class="row clearfix no-margin">
            	 <h3 class="text-uppercase text-light ">Repository</h3>
                <!--
                <h3><a class="lg-anchor text-light" href="">PTRepository - Pharaoh Tools <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                -->
                <p> Project Name: <?php echo $pageVars["data"]["repository"]["project-name"] ; ?></p>
                <p> Project Slug: <?php echo $pageVars["data"]["repository"]["project-slug"] ; ?></p>
                <p> Project Desc: <?php echo $pageVars["data"]["repository"]["project-description"] ; ?></p>
            </div>
            <hr>
            <div class="row clearfix no-margin build-home-properties">
<!--                <h3><a class="lg-anchor text-light" href="/index.php?control=RepositoryConfigure&action=show&item=--><?php //echo $pageVars["data"]["repository"]["project-slug"] ; ?><!--">-->
<!--                    Configure Repository: --><?php //echo $pageVars["data"]["repository"]["project-name"] ; ?><!--- <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>-->

                <div class="pipe-now-status-block pipe-block">
                    <h4 class="propertyTitle">Repository Status Currently:</h4>
                </div>

                <div class="pipe-features-block pipe-block">
                    <h4 class="propertyTitle">Repository Features:</h4>
                    <div class="col-sm-12">
                    <?php
                    if (isset($pageVars["data"]["features"]) &&
                        count($pageVars["data"]["features"])>0 ) {
                        foreach ($pageVars["data"]["features"] as $build_feature) {
//                            var_dump($build_feature);
                            if (isset($build_feature["hidden"]) && $build_feature["hidden"] != true
                                || !isset($build_feature["hidden"]) ) {
                                echo '<div class="build-feature">' ;
                                echo '<a target="_blank" href="'.$build_feature["model"]["link"].'">' ;
                                echo  '<h3>'.$build_feature["model"]["title"].'</h3>' ;
                                echo  '<img src="'.$build_feature["model"]["image"].'" />' ;
                                echo "</a>" ;
                                echo '</div>' ; } } }
                    ?>
                    </div>
                </div>
                <div class="pipe-history-block pipe-block">
                    <h4 class="propertyTitle">Repository History:</h4>
                    <?php
                        if (isset($pageVars["data"]["repository"]["build_history"]) &&
                            count($pageVars["data"]["repository"]["build_history"])>0 ) {
                            foreach ($pageVars["data"]["repository"]["build_history"] as $build_history) {
                                if ($moduleInfo["hidden"] != true) {
                                    echo '<p><a href="/index.php?control=RepositoryConfigure&action=show&item=">'.$build_history["count"].
                                        ' - '.$build_history["status"].' - '.$build_history["message"]."</p>"; } } }
                    ?>
                </div>

               <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/CommitDetails/css/repositoryhome.css">
<script type="text/javascript" src="/Assets/Modules/CommitDetails/js/repositoryhome.js"></script>