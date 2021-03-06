<?php

if (isset($pageVars["data"]["user"]['username'])) {

    $ownerOrPublic = (isset($pageVars["data"]["repository"]["project-owner"]) &&
        strlen($pageVars["data"]["repository"]["project-owner"])>0) ?
        $pageVars["data"]["repository"]["project-owner"] : "public" ;
    ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <span class="centered_button select_git_command btn btn-primary">
                    <h2>Write Enabled</h2>
                </span>
            </div>
            <div class="col-sm-6">
                <?php
                $manual_upload_link = "index.php?control=ManualUpload&action=show&item=".$pageVars["data"]["repository"]["project-slug"] ;
                ?>
                <a href="<?php echo $manual_upload_link ; ?>" class="centered_button select_git_command btn btn-success">
                    <h2>Manual Upload</h2>
                </a>
            </div>
        </div>
        <div class="col-sm-12">
            <h4>To upload to this repository using curl, use the commands below:</h4>
        </div>

        <?php
        $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_2 = "curl -F version=*.*.* -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;

        $curl_str_3 = "curl -F group=development -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_4 = "curl -F group=development -F version=*.*.* -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F auth_user={$pageVars['data']['user']['username']} -F auth_pw={password} {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;

        ?>

        <div class="col-sm-12">
            <?php
            $default_group_string = '' ;
            if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                $default_group_string = "" ;
                if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'specific') {
                    $allowed_groups_string = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allowed_groups"] ;
                    $allowed_groups = explode("\r\n", $allowed_groups_string) ;
                    $default_group = $allowed_groups[0] ;
                    $default_group_string = ", your default group of <strong>$default_group</strong>" ;
                } else if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'allow_all') {
                    $default_group = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_default"] ;
                    $default_group_string = ", your default group of <strong>$default_group</strong>" ;
                }
            }
            ?>
            <h4 class="raw_repo_subtitle">
                Latest version<?php echo $default_group_string ; ?>
                <pre><?php echo $curl_str_1 ; ?></pre>
            </h4>
            <h4 class="raw_repo_subtitle">
                To specify version, just swap the version number parameter for yours<?php echo $default_group_string ; ?>
                <pre><?php echo $curl_str_2 ; ?></pre>
            </h4>

            <?php

            if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                ?>

                <h4>
                    Latest version and specified group
                    <pre><?php echo $curl_str_3  ; ?></pre>
                </h4>

                <h4>
                    Specified version and group
                    <pre><?php echo $curl_str_4  ; ?></pre>
                </h4>
                <?php

            }

            ?>

        </div>

    </div>

    <hr />

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <span class="centered_button select_git_command btn btn-warning">
                    <h2>Read Enabled</h2>
                </span>
            </div>
            <div class="col-sm-6">
                <?php
                $browser_link = "{$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php?control=BinaryServer&action=serve&item=".$pageVars["data"]["repository"]["project-slug"] ;
                ?>
                <a href="<?php echo $browser_link ; ?>" class="centered_button select_git_command btn btn-success">
                    <h2>Latest Download</h2>
                </a>
            </div>
        </div>
        <div class="col-sm-12">
            <h4>To download from this repository using curl, use the commands below:</h4>
        </div>

        <?php
        $curl_str_1 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=".$pageVars["data"]["repository"]["project-slug"]."&auth_user={$pageVars['data']['user']['username']}&auth_pw={password}&version=*.*.*\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_2 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=".$pageVars["data"]["repository"]["project-slug"]."&auth_user={$pageVars['data']['user']['username']}&auth_pw={password}\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_3 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=".$pageVars["data"]["repository"]["project-slug"]."&auth_user={$pageVars['data']['user']['username']}&auth_pw={password}&group=development\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_4 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=".$pageVars["data"]["repository"]["project-slug"]."&auth_user={$pageVars['data']['user']['username']}&auth_pw={password}&version=*.*.*&group=development\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php" ;
        ?>

        <div class="col-sm-12">
            <?php
                $default_group_string = '' ;
                if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                    $default_group_string = "" ;
                    if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'specific') {
                        $allowed_groups_string = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allowed_groups"] ;
                        $allowed_groups = explode("\r\n", $allowed_groups_string) ;
                        $default_group = $allowed_groups[0] ;
                        $default_group_string = ", your default group of <strong>$default_group</strong>" ;
                    } else if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_or_specific"] == 'allow_all') {
                        $default_group = $pageVars["data"]["repository"]["settings"]["BinaryGroups"]["allow_all_default"] ;
                        $default_group_string = ", your default group of <strong>$default_group</strong>" ;
                    }
                }
            ?>
            <h4>
                Latest version<?php echo $default_group_string ; ?>
                <pre><?php echo $curl_str_2  ; ?></pre>
            </h4>
            <h4>
                Specified version<?php echo $default_group_string ; ?>
                <pre><?php echo $curl_str_1  ; ?></pre>
            </h4>
            <?php

            if ($pageVars["data"]["repository"]["settings"]["BinaryGroups"]["enabled"] == "on") {
                ?>

                <h4>
                    Latest version and specified group
                    <pre><?php echo $curl_str_3  ; ?></pre>
                </h4>

                <h4>
                    Specified version and group
                    <pre><?php echo $curl_str_4  ; ?></pre>
                </h4>
                <?php

            }

            ?>
        </div>
    </div>


    <?php
}
else {


    if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["enabled"] == "on") {
        ?>

<?php

        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_write"] == "on") {
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                <span class="centered_button select_git_command btn btn-primary">
                    <h2>Write Enabled</h2>
                </span>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $manual_upload_link = "index.php?control=ManualUpload&action=show&item=" . $pageVars["data"]["repository"]["project-slug"];
                        ?>
                        <a href="<?php echo $manual_upload_link; ?>"
                           class="centered_button select_git_command btn btn-success">
                            <h2>Manual Upload</h2>
                        </a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <h4>To upload to this repository using curl, use the commands below:</h4>
                </div>

                <?php
                $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=" . $pageVars["data"]["repository"]["project-slug"] . " {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php";
                $curl_str_2 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=" . $pageVars["data"]["repository"]["project-slug"] . " -F version=*.*.* {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php";
                ?>

                <div class="col-sm-12">
                    <h4>
                        Guess latest version
                        <pre><?php echo $curl_str_2; ?></pre>
                    </h4>
                    <h4>
                        Specify version
                        <pre><?php echo $curl_str_1; ?></pre>
                    </h4>
                </div>

            </div>


        <?php
        }
        ?>

        <hr/>

        <?php
        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_read"] == "on")  {
        ?>

        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-6">
                <span class="centered_button select_git_command btn btn-warning">
                    <h2>Read Enabled</h2>
                </span>
                </div>
                <div class="col-sm-6">
                    <?php
                    $browser_link = "{$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php?control=BinaryServer&action=serve&item=" . $pageVars["data"]["repository"]["project-slug"];
                    ?>
                    <a href="<?php echo $browser_link; ?>" class="centered_button select_git_command btn btn-success">
                        <h2>Latest Download</h2>
                    </a>
                </div>
            </div>
            <div class="col-sm-12">
                <h4>To download from this repository using curl, use the commands below:</h4>
            </div>

            <?php
            $curl_str_1 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=" . $pageVars["data"]["repository"]["project-slug"] . "&version=*.*.*\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php";
            $curl_str_2 = "curl -X POST -O -J -d \"control=BinaryServer&action=serve&item=" . $pageVars["data"]["repository"]["project-slug"] . "\" {$ht_string_lower}://{$_SERVER['SERVER_NAME']}/index.php";
            ?>

            <div class="col-sm-12">
                <h4>
                    Latest version
                    <pre><?php echo $curl_str_2; ?></pre>
                </h4>
                <h4>
                    Specify version
                    <pre><?php echo $curl_str_1; ?></pre>
                </h4>
            </div>
        </div>


        <?php
        }
        ?>

        <?php
    }


}
?>


<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHome/css/repositoryhome.css">
<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryHistory/css/repositoryhistory.css">