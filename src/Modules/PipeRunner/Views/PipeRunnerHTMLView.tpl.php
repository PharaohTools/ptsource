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
                    <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildList&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-home fa-fw hvr-bounce-in"></i>  Pipeline Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildList&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines
                    </a>
                </li>
                
                
                <li>
                    <a href="index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                    </a>
                </li>
                
                <li>

                    <a href="/index.php?control=Workspace&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-sign-in fa-fw hvr-bounce-in"></i> Run Again
                    </a>
                </li>
            </ul>
        </div>
       </div>
                
               

         <div class="col-lg-9">
                    <div class="well well-lg">
            <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools </a></h2>
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

                    <i style="font-size: 18px;" </i></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"></a>
                </h5>
                <?php
                    if ($pageVars["route"]["action"] != "summary") {
                        $act = '/index.php?control=PipeRunner&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=summary' ; }
                    else {
                        $act = '/index.php?control=PipeRunner&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=summary&run-id='.$pageVars["data"]["historic_build"]["run-id"]  ; }
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
                                        echo '<a href="/index.php?control=PipeRunner&action=summary&item='.$pageVars["data"]["pipeline"]["project-slug"].'&run-id='.$hb.'">'.$hb.'</a><br />' ; } }
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
                              <script type="text/javascript" src="/index.php?control=AssetLoader&action=show&module=PipeRunner&type=js&asset=piperunner.js"></script>
                              <div class="form-group" id="loading-holder">
                                  <div class="col-sm-offset-2 col-sm-8">
                                      <div class="text-center  ">
                                          
                                      </div>
                                 </div>
                             </div>'; }
                    ?>



                    <?php
                    if ($pageVars["route"]["action"] =="start") {
                    ?>
                        <div class="form-group" id="submit-holder">
                            <div class="col-sm-offset-2 col-sm-8">
                                <div class="text-center">
                                    <i class="fa fa-spinner fa-spin fa-5x "> </i>


                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="submit-holder">
                            <div class="col-sm-offset-2 col-sm-8">
                                <div class="text-center">


                                    <button type="submit" class="btn btn-danger" id="end-now">End Now</button>
                                </div>

                            </div>
                        </div>
                    <?php
                       }
                    ?>

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
