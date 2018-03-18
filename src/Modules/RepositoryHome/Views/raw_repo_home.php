<?php

?>


<?php
if (isset($pageVars["data"]["user"]['username'])) {

    $ownerOrPublic = (isset($pageVars["data"]["repository"]["project-owner"]) &&
        strlen($pageVars["data"]["repository"]["project-owner"])>0) ?
        $pageVars["data"]["repository"]["project-owner"] : "public" ;
    ?>
    <div class="row">
        <div class="col-sm-12">
            <h4>To upload to this repository using curl, you can use the following command:</h4>
        </div>
        <div class="col-sm-12">
            <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
        </div>
        <div class="col-sm-12">

        <?php
        $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." {$ht_string_lower}://{$pageVars['data']['user']['username']}:{password}@{$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_2 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F version=*.*.* http://source.pharaoh.tld/index.php" ;
        ?>

            <div class="col-sm-12">
                <h2 class="git_command_text">
                    Specify version
                    <strong><?php echo $curl_str_1  ; ?></strong>
                </h2>
                <h2 class="git_command_text">
                    Create latest version
                    <strong><?php echo $curl_str_2  ; ?></strong>
                </h2>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12">
            <h4>To download from this repository using curl, you can use the following command:</h4>
        </div>
        <div class="col-sm-12">
            <span id="select_pull" class="centered_button select_git_command btn btn-warning">Read</span>
        </div>

        <?php
        $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F version=*.*.* {$_SERVER['SERVER_NAME']}/index.php" ;
        $curl_str_2 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." {$_SERVER['SERVER_NAME']}/index.php" ;
        ?>

        <div class="col-sm-12">
            <h2 class="git_command_text">
                Specify version
                <strong><?php echo $curl_str_1  ; ?></strong>
            </h2>
            <h2 class="git_command_text">
                Download latest version
                <strong><?php echo $curl_str_2  ; ?></strong>
            </h2>
        </div>
    </div>


    <?php
}
else {
    ?>

    <div class="row">
    <hr />
    <?php

    if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["enabled"] == "on") {
        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_read"] == "on") { ?>

            <?php

            if (in_array($pageVars["data"]["current_user_role"], array("1", "2")) ||
                $pageVars["data"]["repository"]["settings"]["PublicScope"]["public_write"] == "on") { ?>

                <div class="col-sm-12">
                    <h4>To upload to this repository using curl, you can use the following command:</h4>
                </div>

                <div class="col-sm-12">
                    <span id="select_push" class="centered_button select_git_command btn btn-warning">Write</span>
                </div>

                <?php

                $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F version=*.*.* {$_SERVER['SERVER_NAME']}/index.php" ;
                $curl_str_2 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." {$_SERVER['SERVER_NAME']}/index.php" ;

                ?>

                <div class="col-sm-12">
                    <h2 class="git_command_text">
                        Specify version
                        <strong><?php echo $curl_str_1  ; ?></strong>
                    </h2>
                    <h2 class="git_command_text">
                        Create latest version
                        <strong><?php echo $curl_str_2  ; ?></strong>
                    </h2>
                </div>

            <?php } ?>


            <div class="col-sm-12">
                <h4>To download from this repository using curl, you can use the following command:</h4>
            </div>
            <div class="col-sm-12">
                <span id="select_pull" class="centered_button select_git_command btn btn-warning">Read</span>
            </div>

            <?php

            $curl_str_1 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." -F version=*.*.* {$_SERVER['SERVER_NAME']}/index.php" ;
            $curl_str_2 = "curl -F file=@/path/to/file -F control=BinaryServer -F action=serve -F item=".$pageVars["data"]["repository"]["project-slug"]." {$_SERVER['SERVER_NAME']}/index.php" ;

            ?>

            <div class="col-sm-12">
                <h2 class="git_command_text">
                    Specify version
                    <strong><?php echo $curl_str_1  ; ?></strong>
                </h2>
                <h2 class="git_command_text">
                    Download latest version
                    <strong><?php echo $curl_str_2  ; ?></strong>
                </h2>
            </div>

        <?php } ?>
        <div class="col-sm-12">

            <?php

            if (in_array($pageVars["data"]["current_user_role"], array("1", "2")) ||
                $pageVars["data"]["repository"]["settings"]["PublicScope"]["public_write"] == "on") {?>
                <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
            <?php } else { ?>
                <span class="col-sm-3 centered_button btn btn-danger">Write Disabled</span>
            <?php } ?>

        </div>
    </div>
        <?php
    }


}