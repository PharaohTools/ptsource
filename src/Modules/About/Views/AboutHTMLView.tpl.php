<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active"> Menu <span class="pull-right" id="slide-submenu">
                    <i class="fa fa-times"></i>
                </span> </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> All Pipelines
                </a>
                <a href="/index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-user"></i> Configure
                </a>
                <a href="/index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="/index.php?control=About&action=changes&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Changes <span class="badge">3</span>
                </a>
                <a href="/index.php?control=About&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="/index.php?control=About&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Delete
                </a>
                <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
                </a>
            </div>
        </div>
        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h4 class="text-uppercase text-light">Pipeline</h4>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="">PTBuild - Pharaoh Tools <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <p> Pharaoh Tools: Build </p>
                <p> Part of the Pharaoh Tools Package </p>

            </div>
            <div class="row clearfix no-margin">
                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>
            </div>

        </div>

    </div>
</div>