<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
			<ul class="nav in" id="side-menu">
				<li class="sidebar-search">
					<div class="input-group custom-search-form hvr-bounce-in">
						<input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button>
                        </span>
					</div>
					</li>
                <li>
                    <a href="/index.php?control=Index&amp;action=show"class="hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryList&action=show"class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i>  Repository Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositorys
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                    </a>
                </li>
                <li>
                    <a href="index.php?control=Conversations&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Conversations
                    </a>
                </li>
                <li>
                    <a href="index.php?control=IssueList&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Issues
                    </a>
                </li>

                <li>
                    <a href="index.php?control=ManualUpload&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> ManualUpload
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryProcesses&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Processes
                    </a>
                </li>
            </ul>
        </div>
       </div>
                
               

    <div class="col-lg-12">
        <div class="well well-lg">
            <div class="row clearfix no-margin">
                <?php
                    switch ($pageVars["route"]["action"]) {
                        case "show" :
                            $stat = "Manual Upload to " ;
                            break ;
                    }
                ?>
                <h3>
                    <?= $stat; ?> Repository <?php echo $pageVars["data"]["repository"]["project-name"] ; ?>
                </h3>

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
