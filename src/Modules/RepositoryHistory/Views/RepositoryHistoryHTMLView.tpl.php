<div class="container" id="wrapper">

	<div class="col-lg-12">
        <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
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
                            <li>
                                <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>

                    <?php

                    if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                        ?>
                        <li>
                            <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                            </a>
                        </li>

                        <?php

                    }

                    ?>
                    <li>
                        <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars['data']["history_count"] ; ?></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars['data']["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>
            <br />
        </div>
		<div class="well well-lg">
			<div class="row clearfix no-margin">

                <h3 class="text-uppercase text-light">Commit History: <strong><?php echo $pageVars['data']["repository"]["project-name"] ; ?></strong></h3>

                <div class="form-group col-sm-12">
                    <div class="form-group col-sm-3 thin_padding">
                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                            Select Branch
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" id="assigneelist" role="menu" aria-labelledby="dropdownMenu1">
                            <?php
                            foreach($pageVars["data"]["branches"] as $branch_name) {
                                ?>
                                <li role="presentation">
                                    <a role="menuitem" tabindex="-1" href="<?php echo $_SERVER['REQUEST_URI'] ; ?>&identifier=<?php echo $branch_name ; ?>">
                                        <?= $branch_name ?>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="form-group col-sm-9 thin_padding">
                        <?php
                        if (isset($pageVars["data"]["current_branch"]) && $pageVars["data"]["current_branch"] != null) {
                            ?>
                            <h4> Current Branch : <strong><?php echo $pageVars["data"]["current_branch"] ; ?></strong></h4>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div role="tabpanel grid">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">
                                        <div>
                                            <div class="blCell cellRowIndex">#</div>
                                            <div class="blCell cellRowMessage">Message</div>
                                            <div class="blCell cellRowAuthor">Author</div>
                                            <div class="blCell cellRowDate">Date</div>
                                            <div class="blCell cellRowHash">Hash</div>
                                        </div>
                                        <div class="allBuildRows table-hover">

                                            <?php

                                            $i = 1;

                                            foreach ($pageVars['data']['commits'] as $commitDetails) {

                                                ?>

                                                <div class="commitRow" id="blRow_<?php echo $commitDetails['commit']; ?>" >
                                                    <div class="blCell cellRowIndex" scope="row"><?php echo $i; ?> </div>
                                                    <div class="blCell cellRowMessage">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&commit=<?php echo $commitDetails['commit'] ; ?>" class="pipeName">
                                                            <?php echo $commitDetails["message"]; ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowAuthor">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&commit=<?php echo $commitDetails['commit'] ; ?>" class="pipeName">
                                                            <?php echo $commitDetails["author"]; ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowDate">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&commit=<?php echo $commitDetails['commit'] ; ?>" class="pipeName">
                                                            <?php echo str_replace('+0000', '', $commitDetails["date"]) ; ?>
                                                        </a>
                                                    </div>
                                                    <div class="blCell cellRowHash">
                                                        <a href="/index.php?control=CommitDetails&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $pageVars['data']['identifier'] ; ?>&commit=<?php echo $commitDetails['commit'] ; ?>" class="pipeName">
                                                            <?php echo substr($commitDetails['commit'], 0, 6); ?>
                                                        </a>
                                                    </div>
                                                </div>

                                                <?php

                                                $i++ ;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <hr />
            <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
        </div>
    </div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryHistory/js/repositoryhistory.js"></script>


