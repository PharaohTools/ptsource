<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
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
                    <a href="index.php?control=BuildList&action=show"class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i>  Pipeline Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildList&amp;action=show"class="hvr-bounce-in">
                        <i class="fa fa-bars hvr-bounce-in"></i> All Pipelines
                    </a>
                </li>
                
                
                <li>
                    <a href="index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-history hvr-bounce-in"></i> History <span class="badge"></span>
                    </a>
                </li>
                
                <li>
                    <a href="/index.php?control=Workspace&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-sign-in fa-fw hvr-bounce-in"></i> Run Again
                    </a>
                </li>
            </ul>
        </div>
       </div>
                
               

         <div class="col-lg-9">
                    <div class="well well-lg">
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