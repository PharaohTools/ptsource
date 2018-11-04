<div class="container" id="wrapper">
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
                    <a href="/index.php?control=Index&action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i>  Repository Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&action=show"class="hvr-bounce-in">
                        <i class="fa fa-bars hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
                <li>
                    <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>

                <?php
                if (in_array($pageVars["data"]["repository"]["project-type"], 'raw')) {
                    ?>

                    <li>
                        <a href="/index.php?control=VersionQuery&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-folder-open-o hvr-bounce-in"></i> Versions
                        </a>
                    </li>

                    <?php
                }
                ?>

                <?php
                if (in_array($pageVars["data"]["repository"]["project-type"], 'git')) {
                    ?>


                    <li>
                        <a href="/index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                            <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                        </a>
                    </li>
                    <li>
                        <a href="/index.php?control=RepositoryReleases&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                            <i class="fa fa-code fa-fw hvr-bounce-in"></i> Releases <span class="badge"></span>
                        </a>
                    </li>

                    <?php
                }
                ?>

            </ul>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="well well-lg">
            <?php echo $this->renderLogs() ; ?>
            <div class="row clearfix no-margin">

                <h4 class="text-uppercase text-light">Versions:</h4>

                <div class="row clearfix no-margin">

                    <hr />
                <div class="col-sm-12">

                    <div role="tabpanel grid">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">

                                        <div id="allOAuthKeyRows" class="allOAuthKeyRows table-hover">

                                            <?php

                                            if (isset($pageVars['data']['version']['groups_disabled'])) {
                                                $group_label = 'Groups are disabled for this Repository' ;
                                            }

                                            foreach ($pageVars['data']['version'] as $group_label => $version_set) {

//                                                if (!isset($version_set['groups_disabled'])) {
//                                                    $group_label = 'Groups are disabled for this Repository' ;
//                                                }

                                                ?>

                                                <div class="fullRow">
                                                    <h2><?php echo $group_label; ?></h2>
                                                    <h3>Current Version:</h3>
                                                    <h5><strong>Version: </strong><?php echo $version_set['current']['version']; ?></h5>
                                                    <h5><strong>Path: </strong><?php echo $version_set['current']['path']; ?></h5>
                                                    <h3>Next Version:</h3>
                                                    <h5><strong>Version: </strong><?php echo $version_set['next']['version']; ?></h5>
                                                    <h5><strong>Path: </strong><?php echo $version_set['next']['path']; ?></h5>
                                                </div>

                                                <?php

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

                    <div class="col-sm-12">
                        <h2>To Query Versions of this repository using curl, use the commands below:</h2>
                    </div>

                    <hr />

                    <?php

                    $ht_string = ($pageVars["data"]["is_https"] == true) ? 'HTTPS' : 'HTTP' ;
                    $ht_string_lower = strtolower($ht_string) ;

                    $default_group_string = '' ;
                    if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                        $default_group_string = "" ;
                        if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'specific') {
                            $allowed_groups_string = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allowed_groups"] ;
                            $allowed_groups = explode("\r\n", $allowed_groups_string) ;
                            $default_group = $allowed_groups[0] ;
                            $default_group_string = ", for your default group of <strong>$default_group</strong>" ;
                        } else {
                            $default_group = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_default"] ;
                            $default_group_string = ", for your default group of <strong>$default_group</strong>" ;
                        }
                        $curl_strings['curl_current_text_group'] = "curl -F control=VersionQuery -F action=current -F group=$default_group -F output-format=TEXT item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                        $curl_strings['curl_next_text_group'] = "curl -F control=VersionQuery -F action=next -F group=$default_group -F output-format=TEXT item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                    }

                    $curl_strings['curl_current_text'] = "curl -F control=VersionQuery -F action=current -F output-format=TEXT item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                    $curl_strings['curl_current_json'] = "curl -F control=VersionQuery -F action=current -F output-format=JSON item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                    $curl_strings['curl_next_text'] = "curl -F control=VersionQuery -F action=next -F output-format=TEXT item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                    $curl_strings['curl_next_json'] = "curl -F control=VersionQuery -F action=next -F output-format=JSON item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
                    
                    ?>

                    <div class="col-sm-12">

                        <h4 class="raw_repo_subtitle">
                            Current Version, Plain Text Format<?php echo $default_group_string ; ?>
                            <pre><?php echo $curl_strings['curl_current_text'] ; ?></pre>
                        </h4>
                        <h4 class="raw_repo_subtitle">
                            Current Version, JSON Format<?php echo $default_group_string ; ?>
                            <pre><?php echo $curl_strings['curl_current_json'] ; ?></pre>
                        </h4>

                        <?php

                        if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                            ?>

                            <h4 class="raw_repo_subtitle">
                                Current version, Specified group, Plain Text Format
                                <pre><?php echo $curl_strings['curl_current_text_group']  ; ?></pre>
                            </h4>

                            <?php

                        }

                        ?>
                        <h4 class="raw_repo_subtitle">
                            Next Available Version, Plain Text Format<?php echo $default_group_string ; ?>
                            <pre><?php echo $curl_strings['curl_current_text'] ; ?></pre>
                        </h4>
                        <h4 class="raw_repo_subtitle">
                            Next Available Version, JSON Format<?php echo $default_group_string ; ?>
                            <pre><?php echo $curl_strings['curl_current_json'] ; ?></pre>
                        </h4>

                        <?php

                        if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                            ?>

                            <h4 class="raw_repo_subtitle">
                                Next version, Specified group, Plain Text Format
                                <pre><?php echo $curl_strings['curl_next_text_group']  ; ?></pre>
                            </h4>

                            <?php

                        }

                        ?>

                    </div>

                </div>
            </div>
     
            <hr />

        </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserOAuthKey/css/useroauthkey.css">