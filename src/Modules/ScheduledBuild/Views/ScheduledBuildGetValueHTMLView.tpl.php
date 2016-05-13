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
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
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
    
	<form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">     
    
                <h3>Project  <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?></h3>
		<h5>This build requires parameters</h5>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"></a>
                </h5>
                
		<div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left"><?php echo $pageVars["data"]["pipeline"]["parameter-name"] ; ?></label>
                        <div class="col-sm-10">
                                        <input type="text" class="form-control" name="parameter-input" id="parameter-input" value="<?php echo $pageVars["data"]["pipeline"]["parameter-dvalue"] ; ?>" />
                        </div>
                    </div>

                   
 		<div class="form-group">
                        <div class="col-sm-4"><br>
                            <button type="submit" class="btn btn-success">Build</button>
                        </div>
                    </div>
<div class="form-group">
                       
<?php

                    if ($pageVars["route"]["action"] == "new") {
                        echo '<input type="hidden" name="creation" id="creation" value="yes" />' ; }

                    ?>

                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />

                    <h5 class="text-uppercase text-light">
                        <a href="#/index.php?control=BuildConfigure&action=save">
                            Build configuration of <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>-</a>
                    </h5>

                </form>
            </div> 
                    
            <p style="position:absolute; bottom:10px;">
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->
