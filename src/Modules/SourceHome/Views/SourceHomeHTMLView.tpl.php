<div class="container" id="wrapper">

    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form hvr-bounce-in">
                        <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search hvr-"></i>
                                </button>
                            </span>
                    </div>
                    <!-- /input-group -->
                </li>

                <li>
                    <a href="/index.php?control=Index&action=show" class="active hvr-bounce-in" ><i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard</a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw"></i> Configure PTSource<span class="fa arrow"></span>
                    </a>
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
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <li>
                    <a href="/index.php?control=RepositoryConfigure&action=new" class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Repository</a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&action=show" class=" hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories</a>
                </li>

                <?php
                    if ($pageVars["data"]["user"] !== false && ($pageVars["data"]["user"]->role == 1)) {
                ?>

                    <li>
                        <a href="/index.php?control=TeamConfigure&action=new" class=" hvr-bounce-in"><i class="fa fa-edit fa-fw hvr-bounce-in"></i> New Team</a>
                    </li>
                    <li>
                        <a href="/index.php?control=TeamList&action=show" class=" hvr-bounce-in"><i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Teams</a>
                    </li>

                <?php
                    }
                ?>

            </ul>
        </div>
    </div>
    <div class="col-lg-9">

        <?php echo $this->renderLogs() ; ?>

        <div class="well well-lg">
            <div class="row clearfix no-margin">

                <div class="row">

                    <div class="col-lg-3 col-md-4 hvr-pop">

                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-database fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge hvr-grow-rotate" ><?php echo count($pageVars['data']['all_repositories']); ?></div>
                                        <div>Total Repositories</div>
                                    </div>
                                </div>
                            </div>
                            <!-- <a href="#">
                                 <div class="panel-footer">
                                     <span class="pull-left">View Details</span>
                                     <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                     <div class="clearfix"></div>
                                 </div>-->
<!--                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-check-circle fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge  hvr-grow-rotate">
                                            <?php echo $pageVars['data']['my_owned_repositories']; ?>
                                        </div>
                                        <div>Your Repositories</div>
                                    </div>
                                </div>
                            </div>
                            <!--    <a href="#">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>-->
<!--                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-times-circle fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge  hvr-grow-rotate"><?php echo $pageVars['data']['my_member_repositories']; ?></div>
                                        <div>Broken</div>
                                    </div>
                                </div>
                            </div>
                            <!--   <a href="#">
                                   <div class="panel-footer">
                                       <span class="pull-left">View Details</span>
                                       <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                       <div class="clearfix"></div>
                                   </div>-->
<!--                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 hvr-pop">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-chain-broken fa-4x hvr-buzz-out"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge hvr-grow-rotate">?</div>
                                        <div>Issues</div>
                                    </div>
                                </div>
                            </div>
                            <!--  <a href="#">
                                  <div class="panel-footer">
                                      <span class="pull-left">View Details</span>
                                      <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                      <div class="clearfix"></div>
                                  </div>-->
<!--                            </a>-->
                        </div>
                    </div>
                </div>
				
                <div class="row">
	                <div class="col-lg-12">
	                    <div class="panel panel-default">
	                        <div class="panel-heading">
	                            <i class="fa fa-bar-chart-o fa-fw"></i> Repository Statuses
	                        </div>
	                        <!-- /.panel-heading -->
	                        <div class="panel-body">
	                            <div id="pipes-build-chart"></div>

                                <div class="row">
                                    <div class="col-sm-12 text-center"><h2>Repositories</h2></div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-4 col-md-6 hvr-pcreatoop">

                                        <div class="panel panel-primary">
                                            <a href="/index.php?control=RepositoryList&action=show">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-xs-12 huge hvr-grow-rotate text-center" >
                                                            All - <?php echo count($pageVars['data']['all_repositories']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span class="pull-left">View Repositories</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                    if (isset($pageVars["data"]['user']->username)) {
                                    ?>

                                    <div class="col-lg-4 col-md-6 hvr-pcreatoop">
                                        <div class="panel panel-green">
                                            <a href="/index.php?control=RepositoryList&action=show&filters[]=user::<?php echo $pageVars["data"]['user']->username ; ?>">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-xs-12 huge hvr-grow-rotate text-center">
                                                            Yours - <?php echo $pageVars['data']['my_owned_repositories']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span class="pull-left">View Repositories</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                    }
                                    ?>

                                    <div class="col-lg-4 col-md-6 hvr-pcreatoop">
                                        <div class="panel panel-yellow">
                                            <a href="/index.php?control=RepositoryList&action=show&userswitch=true">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-xs-12 huge hvr-grow-rotate text-center">
                                                            Member - <?php echo $pageVars['data']['my_member_repositories']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span class="pull-left">View Repositories</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-sm-12 text-center"><h2>Teams</h2></div>
                                </div>

                                <div class="row">

                                    <div class="col-lg-4 col-md-6 hvr-pcreatoop">

                                        <div class="panel panel-primary">
                                            <a href="/index.php?control=TeamList&action=show">
                                                <div class="panel-heading">
                                                    <div class="row">
                                                        <div class="col-xs-12 text-center">
                                                            <div class="huge hvr-grow-rotate" ><?php
                                                                $jc = (isset( $pageVars["data"]['all_teams'])) ?  count($pageVars["data"]['all_teams']) : "?" ;
                                                                echo $jc; ?></div>
                                                            <div>All</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="panel-footer">
                                                    <span class="pull-left">View Teams</span>
                                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <?php
                                    if (isset($pageVars["data"]['user']->username)) {
                                        ?>
                                        <div class="col-lg-4 col-md-6 hvr-pcreatoop">
                                            <div class="panel panel-green">
                                                <a href="/index.php?control=TeamList&action=show&filters[]=team_creator::<?php echo $pageVars["data"]['user']->username ; ?>">
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <div class="huge  hvr-grow-rotate"><?php
                                                                    $jc = (isset( $pageVars["data"]['my_team_created_count'])) ?  $pageVars["data"]['my_job_created_count'] : "?" ;
                                                                    echo $jc; ?></div>
                                                                <div>Yours</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <span class="pull-left">View Teams</span>
                                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>


                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (isset($pageVars["data"]['user']->username)) {
                                        ?>
                                        <div class="col-lg-4 col-md-6 hvr-pcreatoop">
                                            <div class="panel panel-yellow">
                                                <a href="/index.php?control=TeamList&action=show&filters[]=team_members[~]::<?php echo $pageVars["data"]['user']->username ; ?>">
                                                    <div class="panel-heading">
                                                        <div class="row">
                                                            <div class="col-xs-12 text-center">
                                                                <div class="huge  hvr-grow-rotate"><?php
                                                                    $jc = (isset( $pageVars["data"]['my_team_member_count'])) ?  $pageVars["data"]['my_job_member_count'] : "?" ;
                                                                    echo $jc; ?></div>
                                                                <div>Member</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="panel-footer">
                                                        <span class="pull-left">View Teams</span>
                                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                </div>

                                <div class="row">
                                    <div class="col-sm-12 text-center"><h2>Latest</h2></div>
                                </div>

                                <div class="row text-center">
                                    <div class="col-sm-6 text-center">
                                        <?php
                                        if (isset($pageVars["data"]["latest_issues"]) && count($pageVars["data"]["latest_issues"])>0 ) { ?>
                                            <h4>Latest Issues</h4>
                                            <?php
                                            $i = 1;

                                            foreach ($pageVars["data"]["latest_issues"] as $IssueTracker) {
                                                ?>

                                                    <div class="trackerRow col-sm-12">
                                                        <a target="_blank" href="<?php echo $IssueTracker["values"]["track_job_url"]; ?>">
                                                            <div class="blCell cellRowDescription fullRow">
                                                                <?php echo $IssueTracker["model"]["title"]; ?>
                                                                <img src="<?php echo $IssueTracker["model"]["image"]; ?>" alt="Pharaoh Track - <?php echo $IssueTracker["model"]["title"]; ?>" />
                                                            </div>
                                                            <div class="blCell cellRowDescription fullRow">
                                                                <button class="btn btn-success">
                                                                    Loading Issues
                                                                </button>
                                                            </div>
                                                        </a>
                                                    </div>
                                                <?php

                                                $i++ ;
                                            } }
                                        else { ?>
                                            <h4>No Latest Issues Found</h4>

                                        <?php  }  ?>
                                    </div>
                                    <div class="col-sm-6 text-center">
                                        <?php

                                        if (isset($pageVars["data"]["latest_commits"]) && count($pageVars["data"]["latest_commits"])>0 ) { ?>
                                            <h4>Latest Commits</h4>
                                            <?php
                                            $i = 0;
                                            foreach ($pageVars["data"]["latest_commits"] as $latestCommit) {
                                                if ($i > 5) { $hidString = " hiddenCommitRow" ; }
                                                else { $hidString = "" ; }
                                                ?>

                                                <div class="commitRow <?php echo $hidString; ?>" id="commitRow_<?php echo $latestCommit["commit"]; ?>" >
                                                    <div class="blCell cellRowName leftWideCell">
                                                        <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $latestCommit["repo_slug"]; ?>">
                                                            <i class="fa fa-database"></i> <?php echo $latestCommit["repo_name"]; ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowSourceHome rightNarrowCell">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $latestCommit["repo_slug"]; ?>&commit=<?php echo $latestCommit["commit"]; ?>">
                                                            <i class="fa fa-pencil"></i> <?php echo substr($latestCommit["commit"], 0, 6); ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowDescription fullRow"><?php
                                                        if (strlen($latestCommit["message"]) < 150) {
                                                            echo $latestCommit["message"]; }
                                                        else {
                                                            $trunc = substr($latestCommit["message"], 0, 150) ;
                                                            $trunc .= " ..." ;
                                                            echo $trunc ; } ?>
                                                    </div>
                                                    <div class="blCell cellRowAssignee leftCell">
                                                        <a href="/index.php?control=UserProfilePublic&action=show&item=<?php echo $latestCommit["repo_slug"]; ?>">
                                                            <?php echo $latestCommit["author"]; ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowPriority rightCell">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $latestCommit["repo_slug"]; ?>&commit=<?php echo $latestCommit["commit"]; ?>">
                                                            <?php echo str_replace(" +0000", "", $latestCommit["date"]); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php
                                                $i++ ;
                                            } ?>

                                        <div class="blCell">
                                            <button class="btn btn-info" id="showMoreCommits">
                                                Show More
                                            </button>
                                        </div>
                                    </div>
                                        <?php }
                                        else { ?>
                                            <h4>No Latest Commits Found</h4>
                                    </div>
                                        <?php  }  ?>
                                </div>


                            </div>
	                        <!-- /.panel-body -->	                    
	                	</div>
	                </div>             
            </div>

        </div>

        <hr>
        <div class="col-lg-13">

        </div>

</div>

<link rel="stylesheet" type="text/css" href="/Assets/Modules/SourceHome/css/sourcehome.css">
