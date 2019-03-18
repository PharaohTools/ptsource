<div class="container" id="wrapper">

	<div class="col-lg-12">
		<div class="well well-lg">
            <div  id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
                <div class="sidebar-nav ">
                    <div class="sidebar-search">
                        <button class="btn btn-success" id="menu_visibility_label" type="button">
                            Show Menu
                        </button>
                        <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
                    </div>
                    <ul class="nav in" id="side-menu">
                        <li>
                            <a href="/index.php?control=Index&action=show" class=" hvr-bounce-in"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in"> <i class="fa fa-cogs fa-fw"></i> Configure PTSource<span class="fa arrow"></span> </a>
                            <ul class="nav nav-second-level collapse">
                                <li>
                                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
                                </li>
                                <li>
                                    <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">Users</a>
                                </li>
                                <li>
                                    <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                                </li>
                                <li>
                                    <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="/index.php?control=RepositoryConfigure&action=new"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Repository</a>
                        </li>
                        <li>
                            <a href="/index.php?control=RepositoryConfigure&action=copy"class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> Copy Repository</a>
                        </li>
                    </ul>
                </div>
                <br />


            </div>

			<div class="row clearfix no-margin">
				<h2>All Repositories</h2>

				<div role="tabpanel grid">
                    <table class="table table-striped table-bordered table-condensed">
                                <thead>
                                    <tr style="background-color: #fff">
                                        <th class="blCell cellRowIndex">#</th>
                                        <th class="blCell cellRowName">Repository</th>
                                        <th class="blCell cellRowType">Type</th>
                                        <th class="blCell cellRowAction">Action</th>
                                        <th class="blCell cellRowFeatures">Features</th>
                                    </tr>
                                </thead>
                                <tbody class="allBuildRows table-hover">

                                <?php

                                $i = 1;
                                foreach ($pageVars["data"]["repositories"] as $repositorySlug => $repositoryDetails) {

                                    if ($repositoryDetails["last_status"] === true) {
                                        $successFailureClass = "successRow"  ; }
                                    else if ($repositoryDetails["last_status"] === false) {
                                        $successFailureClass = "failureRow" ; }
                                    else {
                                        $successFailureClass = "unstableRow" ; }

                                    if (isset($repositoryDetails["project-name"])) {
                                        $slugOrName = $repositoryDetails["project-name"] ; }
                                    else if (isset($repositorySlug)) {
                                        $slugOrName = $repositorySlug ; }
                                    else {
                                        $slugOrName = "Unnamed Project" ; }

                                    ?>

                                <tr class="repositoryRow <?php echo $successFailureClass ?>" id="blRow_<?php echo $repositorySlug; ?>" >
                                    <td class="blCell cellRowIndex" scope="row">
                                        <?php echo $i; ?>
                                    </td>
                                    <td class="blCell cellRowName">
                                        <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $repositorySlug; ?>" class="pipeName">
                                            <?php echo $slugOrName; ?>
                                        </a>
                                    </td>
                                    <td class="blCell cellRowType">
                                        <?php

                                        if (isset($repositoryDetails["project-type"])) {

                                            if ($repositoryDetails["project-type"] == 'raw') {
                                                echo 'Raw' ; }
                                            else {
                                                echo "Git" ; }

                                        }

                                        ?>
                                    </td>

                                    <td class="blCell cellRowAction">
                                        <div class="col-sm-12">
                                            <div class="col-sm-2">
                                                <a class="tooltip_trigger" href="/index.php?control=RepositoryConfigure&action=show&item=<?php echo $repositorySlug ; ?>">
                                                    <i class="fa fa-cog fa-2x hvr-grow-shadow"></i>
                                                    <span class="tooltiptext">Settings</span>
                                                </a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="tooltip_trigger" href="/index.php?control=FileBrowser&action=show&item=<?php echo $repositorySlug ; ?>">
                                                    <i class="tooltip_trigger fa fa-folder-open-o fa-2x hvr-grow-shadow"></i>
                                                    <span class="tooltiptext">File Browser</span>
                                                </a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="tooltip_trigger" href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $repositorySlug ; ?>">
                                                    <i class="tooltip_trigger fa fa-history fa-2x hvr-grow-shadow"></i>
                                                    <span class="tooltiptext">History</span>
                                                </a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="tooltip_trigger" href="/index.php?control=RepositoryCharts&action=contributors&item=<?php echo $repositorySlug ; ?>">
                                                    <i class="tooltip_trigger fa fa-users fa-2x hvr-grow-shadow"></i>
                                                    <span class="tooltiptext">Contributors</span>
                                                </a>
                                            </div>
                                            <div class="col-sm-2">
                                                <a class="tooltip_trigger" href="/index.php?control=RepositoryCharts&action=show&item=<?php echo $repositorySlug ; ?>">
                                                    <i class="fa fa-bar-chart-o fa-2x hvr-grow-shadow"></i>
                                                    <span class="tooltiptext">Charts</span>
                                                </a>
                                            </div>
                                        </div>

                                    </td>
                                    <td class="blCell cellRowFeatures">
                                        <?php

                                        if (isset($repositoryDetails["features"]) &&
                                            count($repositoryDetails["features"])>0 ) {
                                            foreach ($repositoryDetails["features"] as $repository_feature) {
                                                echo '<div class="repository-feature">' ;
                                                echo ' <a target="_blank" href="'.$repository_feature["model"]["link"].'">' ;
    //                                                echo  '<h3>'.$repository_feature["model"]["title"].'</h3>' ;
                                                echo '  <img src="'.$repository_feature["model"]["image"].'" />' ;
                                                echo " </a>" ;
                                                echo '</div>' ; } }
                                        else {
                                            echo '&nbsp;' ; }

                                        ?>
                                    </td>
                                </tr>

                                <?php
                                $i++;
                                }
                                ?>

                                </tbody>
                            </table>
                </div>

	        </div>
</div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryList/css/repositorylist.css">
