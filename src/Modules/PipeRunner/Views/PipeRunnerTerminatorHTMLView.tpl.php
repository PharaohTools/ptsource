<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav in" id="side-menu">
				<li class="sidebar-search">
					<div class="input-group custom-search-form  hvr-bounce-in">
						<input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
								<i class="fa fa-search"></i>
							</button> </span>
                        
					</div>
					</li>
                <li>
                    <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildList&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
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
                    <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
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

                <h3>Now Terminating Pipeline <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?><?php
                        echo ', Run '.$pageVars["data"]["historic_build"]["run-id"] ;
                    ?> </h3>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <?php
                    if (isset($pageVars["pipex"])) {
                        ?>

                        <div class="form-group">
                            <div class="col-sm-10">
                                Pipeline Termination started - Run # <?= $pageVars["pipex"] ;?>
                            </div>
                        </div>

                    <?php
                    }
                    ?>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div id="updatable">
                                Checking Pipeline Termination Output...

                            </div>
                        </div>
                    </div>

                      <script type="text/javascript">
                          window.pipeitem = "<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" ;
                          window.runid = "<?php echo $pageVars["data"]["historic_build"]["run-id"] ; ?>" ;
                      </script>
                          <div class="form-group" id="loading-holder">
                              <div class="col-sm-offset-2 col-sm-8">
                                  <div class="text-center  ">

                                  </div>
                             </div>
                      </div>

                    <div class="form-group" id="submit-holder">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <img src="Assets/startbootstrap-sb-admin-2-1.0.5/dist/image/712.GIF" style="width:100px;">
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="item" value="<?= $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                    <input type="hidden" id="run-id" value="<?= $pageVars["data"]["historic_build"]["run-id"] ; ?>" />

                </form>
            </div>
            <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

        </div>

    </div>
</div><!-- /.container -->

<script type="text/javascript" src="/Assets/Modules/PipeRunner/js/pipeterminator.js"></script>
