<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" ><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show">
                        <i class="fa fa-cogs fa-fw"></i> Configure PTBuild<span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="flot.html">New Pipeline</a>
                        </li>
                        <li>
                            <a href="morris.html">Morris.js Charts</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="/index.php?control=BuildConfigure&action=new"><i class="fa fa-edit fa-fw"></i> New Pipeline</a>
                </li>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class="active"><i class="fa fa-bars fa-fw"></i> All Pipelines</a>
                </li>
                <li>
                    <a href="/index.php?control=Monitors&action=DefaultHistory"><i class="fa fa-history fa-fw"></i> History<span class="fa arrow"></span></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-md-9 col-sm-10" id="page-wrapper">
        <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>

        <div class="row clearfix no-margin">
            <h4 class="text-uppercase text-light">A list of builds in a page</h4>
            <!--
            <h3>
                <a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">
                    Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
            </h3>
            -->
            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                    <li role="presentation"><a href="#success" aria-controls="success" role="tab" data-toggle="tab">All Success</a></li>
                    <li role="presentation"><a href="#failed" aria-controls="failed" role="tab" data-toggle="tab">All Failed</a></li>
                    <li role="presentation"><a href="#unstable" aria-controls="unstable" role="tab" data-toggle="tab">All Unstable</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="all">
                        <div class="table-responsive">
                            <table class="table table-bordered table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Pipeline</th>
                                    <th>Run Now</th>
                                    <th>Status</th>
                                    <th>Success</th>
                                    <th>Failure</th>
                                    <th>Duration</th>
                                    <!--
                                    <th>Parent</th>
                                    <th>Child</th>
                                    -->
                                </tr>
                                </thead>
                                <tbody class="table-hover">

                                <?php

                                $i = 1;
                                foreach ($pageVars["data"]["pipelines"] as $pipelineSlug => $pipelineDetails) { ?>
                                    <tr>
                                        <th scope="row"><?php echo $i ; ?></th>
                                        <td><a href="/index.php?control=BuildHome&action=show&item=<?php echo $pipelineSlug ; ?>"><?php echo $pipelineDetails["project-name"] ; ?></a></td>
                                        <td>
                                            <?php
                                            echo '<a href="/index.php?control=PipeRunner&action=start&item='.$pipelineDetails["project-slug"].'">';
                                            echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=run.png" /></a>' ;
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pipelineDetails["last_status"] === true) {
                                                echo '<img class="listImage listImageWide" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=green-ball.png" />' ; }
                                            else {
                                                echo '<img class="listImage listImageWide" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=red-ball.png" />' ; }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pipelineDetails["last_success"] != false) {
                                                echo date('Y-m-d \<\b\r\> h:i:s', $pipelineDetails["last_success"]) ;
                                                echo ' #('.$pipelineDetails["last_success_build"].')'; }
                                            else {
                                                echo 'N/A' ; }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pipelineDetails["last_fail"] != false) {
                                                echo date('Y-m-d \<\b\r\> h:i:s', $pipelineDetails["last_fail"]) ;
                                                echo ' #('.$pipelineDetails["last_fail_build"].')'; }
                                            else {
                                                echo 'N/A' ; }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pipelineDetails["duration"] != false) {
                                                echo $pipelineDetails["duration"].' seconds' ; }
                                            else {
                                                echo 'N/A' ; }
                                            ?>
                                        </td>
                                        <!--
                                        <td>
                                            <?php
                                            if ($pipelineDetails["has_parents"] === true) {
                                                echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=tick.png" />' ; }
                                            else {
                                                echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=cross.png" />' ; }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($pipelineDetails["has_children"] === true) {
                                                echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=tick.png" />' ; }
                                            else {
                                                echo '<img class="listImage" src="/index.php?control=AssetLoader&action=show&module=BuildList&type=image&asset=cross.png" />' ; }
                                            ?>
                                        </td>
                                        -->
                                    </tr>
                                    <?php
                                    $i++;
                                } ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>
            ---------------------------------------<br/>
            Visit www.pharaohtools.com for more
        </p>
    </div>
</div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/index.php?control=AssetLoader&action=show&module=BuildList&type=css&asset=buildlist.css">



