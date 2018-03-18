<?php
if (isset($pageVars["data"]["user"]['username'])) {

    $ownerOrPublic = (isset($pageVars["data"]["repository"]["project-owner"]) &&
        strlen($pageVars["data"]["repository"]["project-owner"])>0) ?
        $pageVars["data"]["repository"]["project-owner"] : "public" ;
    ?>
    <div class="row">
        <div class="col-sm-12">
            <hr />
            <div class="col-sm-2">
                &nbsp;
            </div>
            <div class="col-sm-4">
                <span id="select_http" class="centered_button select_git_command btn btn-success">HTTP/S</span>
            </div>
            <div class="col-sm-4">
                <span id="select_ssh" class="centered_button select_git_command btn btn-warning">SSH</span>
            </div>
            <div class="col-sm-2">
                &nbsp;
            </div>
        </div>
        <div class="col-sm-12">

            <?php

            $git_http_url = "{$ht_string_lower}://{$pageVars["data"]["user"]['username']}:{password}@{$_SERVER["SERVER_NAME"]}/git/{$ownerOrPublic}/{$pageVars["data"]["repository"]["project-slug"]} " ;
            $git_ssh_url = "ssh://ptgit@{$_SERVER["SERVER_NAME"]}/git/{$ownerOrPublic}/{$pageVars["data"]["repository"]["project-slug"]} " ;


            ?>
            <input type="hidden" id="git_http_url" value="<?= $git_http_url ;?>" />
            <input type="hidden" id="git_ssh_url" value="<?= $git_ssh_url ;?>" />

            <h2 class="git_command_text">
                <strong>git clone</strong>
                <strong id="git_url_string"><?php echo $git_http_url  ; ?></strong>
            </h2>
        </div>
        <div class="col-sm-12">
            <span class="col-sm-3 centered_button btn btn-success">Write Enabled</span>
        </div>
    </div>
    <?php
}
else {
    ?>

    <div class="row">
    <div class="col-sm-12">
    <hr />
    <?php

    if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["enabled"] == "on") {
        if ($pageVars["data"]["repository"]["settings"]["PublicScope"]["public_read"] == "on") { ?>

            <div class="col-sm-4">
                <span id="select_clone" class="centered_button select_git_command btn btn-success">Clone</span>
            </div>

            <?php

            if (in_array($pageVars["data"]["current_user_role"], array("1", "2")) ||
                $pageVars["data"]["repository"]["settings"]["PublicScope"]["public_write"] == "on") { ?>
                <div class="col-sm-4">
                    <span id="select_push" class="centered_button select_git_command btn btn-warning">Push</span>
                </div>
                <div class="col-sm-4">
                    <span id="select_pull" class="centered_button select_git_command btn btn-warning">Pull</span>
                </div>

            <?php } ?>
            </div>

            <div class="col-sm-12">
                <h2 class="git_command_text"><strong id="git_command_string">git clone</strong> <?php echo "{$ht_string_lower}://anon:any@{$_SERVER["SERVER_NAME"]}/git/public/{$pageVars["data"]["repository"]["project-slug"]} "  ; ?></h2>
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


?>