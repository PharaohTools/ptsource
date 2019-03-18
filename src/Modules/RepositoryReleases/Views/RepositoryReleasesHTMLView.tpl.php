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
                        <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="index.php?control=RepositoryReleases&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Releases <span class="badge"></span>
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
                <h2>Release History: <strong><?php echo $pageVars['data']["repository"]["project-name"] ; ?></strong></h2>
                <div class="form-group col-sm-12">
                    <div role="tabpanel grid">
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">
                                        <div class="allBuildRows table-hover">
                                            <?php
                                            $i = $pageVars['data']['tag_count'] ;
                                            foreach ($pageVars['data']['tags'] as $one_tag) {
                                                ?>
                                                <div class="tagRow" data-tag="<?php echo $one_tag['tag']; ?>" id="blRow_<?php echo $one_tag['tag']; ?>" >
                                                    <div class="blCell col-sm-1" scope="row">
                                                        <h2>
                                                            <?php echo $i; ?>
                                                        </h2>
                                                    </div>
                                                    <div class="blCell col-sm-11">
                                                        <h4>
                                                            Version:
                                                            <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars['data']["repository"]["project-slug"]; ?>&identifier=<?php echo $one_tag['tag']; ?>&tag=<?php echo $one_tag['tag'] ; ?>" class="pipeName">
                                                                <?php echo $one_tag['tag']; ?>
                                                            </a>
                                                        </h4>

                                                        <p>
                                                            <?php
                                                            if (isset($one_tag['message']) && $one_tag['message'] != '') {
                                                                echo $one_tag['message'];
                                                            } else {
                                                                echo 'No Message Associated with this Tag' ;
                                                            }?>
                                                        </p>

                                                        <div class="repository_release_package_row fullRow">

                                                            <?php

                                                            if ($pageVars['data']['standard_release_enabled'] === true) {

                                                            ?>

                                                                <h4>
                                                                    Standard Release Packages
                                                                </h4>

                                                                <?php

                                                                foreach ($pageVars['data']['release_packages']['default'] as $one_release_slug => $one_release_details) {

                                                                    if (in_array($one_release_slug, $pageVars['data']['enabled_default_release_packages'])) {

                                                                        ?>

                                                                        <div class="col-sm-4">

                                                                            <div class="repository_release_package col-sm-12">
                                                                                <div class="repository_release_package_title">
                                                                                    <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $one_release_slug; ?>">
                                                                                        <h4>
                                                                                            <?php echo $one_release_details['title']; ?>
                                                                                        </h4>
                                                                                    </a>
                                                                                </div>

                                                                                <?php
                                                                                if (isset($one_release_details['image']) && strlen($one_release_details['image'])>3) {
                                                                                    ?>

                                                                                    <div class="col-sm-12">
                                                                                        <img src="<?php echo $one_release_details['image']; ?>"
                                                                                             alt="Release Image"
                                                                                             class="release_package_image" />
                                                                                    </div>

                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                                <div class="repository_release_package_description col-sm-12">
                                                                                    <a href="<?php echo $one_release_details['link']; ?>">
                                                                                        Download
                                                                                    </a>
                                                                                    <p>
                                                                                        <?php echo $one_release_details['description']; ?>
                                                                                    </p>
                                                                                </div>

                                                                            </div>

                                                                        </div>

                                                                        <?php
                                                                    }
                                                                }
                                                                ?>

                                                            <?php

                                                            }

                                                            ?>


                                                        </div>

                                                        <div class="repository_release_package_row fullRow">

                                                            <?php

                                                            if ($pageVars['data']['pharaoh_build_release_enabled'] === true) {

                                                            ?>

                                                                <h4>
                                                                    Pharaoh Build Release Packages
                                                                </h4>

                                                                <?php

                                                                foreach ($pageVars['data']['release_packages']['pharaoh_build_integration'] as $one_release_slug => $one_release_details) {

                                                                    ?>

                                                                    <div class="col-sm-4">

                                                                        <div class="repository_release_package col-sm-12">
                                                                            <div class="repository_release_package_title">
                                                                                <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $one_release_slug; ?>">
                                                                                    <h4>
                                                                                        <?php echo $one_release_details['title']; ?>
                                                                                    </h4>
                                                                                </a>
                                                                            </div>

                                                                            <?php
                                                                            if (isset($one_release_details['image']) && strlen($one_release_details['image'])>3) {
                                                                                ?>

                                                                                <div class="col-sm-12">
                                                                                    <img src="<?php echo $one_release_details['image']; ?>"
                                                                                         alt="Release Image"
                                                                                         class="release_package_image" />
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            ?>

                                                                            <div class="repository_release_package_description col-sm-12">
                                                                                <a href="<?php echo $one_release_details['link']; ?>">
                                                                                    Download
                                                                                </a>
                                                                                <p>
                                                                                    <?php echo $one_release_details['description']; ?>
                                                                                </p>
                                                                            </div>

                                                                        </div>

                                                                    </div>

                                                                    <?php
                                                                }
                                                                ?>
                                                            <?php

                                                            }

                                                            ?>

                                                            <hr />

                                                        </div>

                                                    </div>

                                                </div>
                                                <?php
                                                $i-- ;
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div><!-- /.container -->
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryReleases/css/repositoryreleases.css">
<script type="text/javascript" src="/Assets/Modules/RepositoryReleases/js/repositoryreleases.js"></script>


