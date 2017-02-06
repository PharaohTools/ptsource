<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
			<ul class="nav in" id="side-menu">
                <?php

                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {

                ?>
                    <li>
                        <a href="/index.php?control=Index&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryList&amp;action=show" class="hvr-bounce-in">
                            <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryConfigure&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa  fa-cog fa-fw hvr-bounce-in"></i> Configure
                        </a>
                    </li>

                <?php

                }
                ?>

                <li>
                    <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in""></i> History <span class="badge"></span>
                    </a>
                </li>

                <?php
                if (in_array($pageVars["data"]["current_user_role"], array("1", "2"))) {
                    ?>

                    <li>
                        <a href="index.php?control=PullRequest&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-trash fa-fw hvr-bounce-in""></i> Delete
                        </a>
                    </li>

                <?php
                }
                ?>

            </ul>
        </div>
    </div>
    
    <div class="col-lg-9">
        <div class="well well-lg ">
            <div class="row clearfix no-margin">
            	<h3 class="text-uppercase text-light ">Commit</h3>
                <p><strong>Title: </strong><?php echo $pageVars["data"]['pull_request']->getMessage() ; ?></p>
                <p><strong>Requestor: </strong><?php echo $pageVars["data"]['pull_request']->getAuthor()->getName() ; ?></p>
                <p><strong>Commit ID: </strong><?php echo $pageVars["data"]['pull_request']->getShortHash() ; ?></p>
                <p><strong>Source Branch: </strong><?php echo $pageVars["data"]['pull_request']->getDate()->format('H:i d/m/Y') ; ?></p>
                <p><strong>Target Branch: </strong><?php echo $pageVars["data"]['pull_request']->getDate()->format('H:i d/m/Y') ; ?></p>
                <hr />
<!--                <p><strong>File Browser: </strong><a href="http://source.pharaoh.tld/"></a></p>-->
            </div>

        </div>

    </div>
</div>
<link rel="stylesheet" type="text/css" href="/Assets/Modules/PullRequest/css/commitdetails.css">
