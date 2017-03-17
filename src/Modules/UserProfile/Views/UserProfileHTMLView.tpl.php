<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
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
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw"></i> Configure PT<?php echo ucfirst(PHARAOH_APP)  ; ?><span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">User Manager</a>
                        </li>
                        <li>
                            <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                        </li>
                        <li>
                            <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                        </li>s
                    </ul>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-user fa-fw"></i> User Menu <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="/index.php?control=UserProfile&action=show" class=" hvr-curl-bottom-right">Edit Profile</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserProfilePublic&action=show" class=" hvr-curl-bottom-right">Public Profile</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserSSHKey&action=show" class=" hvr-curl-bottom-right">SSH Keys</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserOAuthKey&action=show" class=" hvr-curl-bottom-right">OAuth Keys</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>



        </div>
    </div>

  <div class="col-lg-9">
                    <div class="well well-lg">
<!--        <h2 class="text-uppercase text-light"><a href="/"> PT<?php echo ucfirst(PHARAOH_APP)  ; ?> - Pharaoh Tools</a></h2>-->

                        <?php echo $this->renderLogs() ; ?>

                        <div class="row clearfix no-margin">
           <h4 class="text-uppercase text-primary"><i class="fa fa-users hvr-grow-rotate"></i>User Profile</h4>

                <?php

                if ($pageVars["route"]["action"] == "new") {
                ?>
                    <h5 class="text-uppercase text-primary">Create New User</h5>
                <?php
                }
                if ($pageVars["route"]["action"] == "show") {
                ?>
                    <h5 class="text-uppercase text-primary">Update Current User</h5>
                <?php
                }
                ?>


                <div class="row clearfix no-margin">
                <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                <div class="form-group" id="userprofile-loading-holder">
                </div>
                <div class="fullRow">
                    <span style="color:#FF0000;" id="form_alert"></span>
<!--                    <p style="color: #7CFC00; margin-left: 100px;" id="registration_error_msg"></p>-->
                    <?php if ($pageVars["route"]["action"] !== "new") { ?>
                        <a href="/index.php?control=UserProfile&action=new" class="btn btn-info hvr-grow-shadow rightAlignButton">
                            Create New User
                        </a>
                    <?php } else { ?>
                        <a href="/index.php?control=UserProfile&action=show" class="btn btn-info hvr-grow-shadow rightAlignButton">
                            Edit Current User
                        </a>
                    <?php } ?>
                </div>
                <div class="form-group" id="userprofile-fields">
                    <form class="form-horizontal custom-form" action="/index.php?control=UserProfile&action=create" method="POST">
                        <?php

                        if ($pageVars["route"]["action"] !== "new") {
                        ?>

                        <div class="form-group">
                            <label for="update_username" class="col-sm-4 control-label text-left" style="color:#757575">User Name</label>
                            <div class="col-sm-7">
                                <?php


                                if ($pageVars["data"]["allusers"] === false) {
                                    ?>


                                    <input type="text" readonly="readonly" class="form-control" id="update_username" name="update_username" placeholder="User Name" value="<?php echo $pageVars["data"]["user"]['username'] ; ?>">
                                <?php
                                } else {

                                    ?>

                                    <div class="dropdownUsers">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                            Select Current User
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <?php
                                            foreach($pageVars["data"]["allusers"] as $oneUser) {
                                                ?>
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" onclick="refreshUserDetails('<?php echo $oneUser['username'] ; ?>');">
                                                        <?= $oneUser['username'] ; ?>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <input type="hidden" class="form-control" id="update_username" name="update_username" value="<?php echo $pageVars["data"]["user"]['username'] ; ?>">
                                    </div>
                                    <div class="userShow">
                                        <input type="text" readonly="readonly" class="form-control" id="update_username_text" name="update_username_text" value="<?php echo $pageVars["data"]["user"]['username'] ; ?>">
                                    </div>

                                <?php
                                }
                                ?>

                                <span style="color:#FF0000;" id="update_username_alert"></span>
                                <input type="hidden" class="form-control my_uname" id="my_uname" name="my_uname" value="<?php echo $pageVars["data"]["user"]['username'] ; ?>" >
                            </div>
                        </div>

                        <?php

                        }
                        else  {
                            ?>

                            <div class="form-group">
                                <label for="create_username" class="col-sm-4 control-label text-left" style="color:#757575">Username</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="create_username" name="create_username" value="" placeholder="Username" />
                                    <span style="color:#FF0000;" id="update_username_alert"></span>
                                </div>
                            </div>

                        <?php
                        }

                        $email_string = '' ;
                        if ($pageVars["route"]["action"] !== "new") {
                            $email_string = $pageVars["data"]["user"]['email'] ; }

                        ?>

                        <div class="form-group">
                            <label for="update_email" class="col-sm-4 control-label text-left" style="color:#757575">Email</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="update_email" name="update_email"
                                       value="<?php echo $email_string ; ?>" placeholder="Email">
                                <span style="color:#FF0000;" id="update_email_alert"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="update_password" class="col-sm-4 control-label text-left" style="color:#757575">Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="update_password" name="update_password" placeholder="Password">
                                <span style="color:#FF0000;" id="update_password_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="update_password_match" class="col-sm-4 control-label text-left" style="color:#757575;" >Confirm Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="update_password_match" name="update_password_match" placeholder="Retype Password">
                                <span style="color:#FF0000;" id="update_password_match_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-3 actionButtonWrap">

                                <?php

                                if ($pageVars["route"]["action"] !== "new") {
                                    ?>
                                    <button onclick="updateUser(); return false;" class="btn btn-success hvr-grow-shadow actionButton">
                                        Update Password
                                    </button>
                                    <button onclick="deleteUser(); return false;" class="btn btn-warning hvr-grow-shadow actionButton">
                                        Delete User
                                    </button>
                                <?php }
                                else {
                                    ?>
                                    <button onclick="createUser(); return false;" class="btn btn-success hvr-grow-shadow actionButton">
                                        Create New User
                                    </button>
                                    <?php

                                }

                                ?>

                            </div>
                        </div>

                        <div class="fieldsets_wrap form-group col-sm-12">
                            <?php

                            foreach ($pageVars['data']['extra_fieldsets'] as $extra_fieldset) {
                                ?>

                                <div class="form-group extra_field">
                                    <label for="update_<?php echo $extra_fieldset['slug'] ; ?>"
                                           class="col-sm-4 control-label text-left"
                                           style="color:#757575">
                                        <?php echo $extra_fieldset['title'] ; ?>
                                    </label>
                                    <?php if ( $extra_fieldset['type'] === 'text') { ?>
                                        <div class="col-sm-7">
                                            <input type="text"
                                                   class="form-control"
                                                   id="update_<?php echo $extra_fieldset['slug'] ; ?>"
                                                   name="update_<?php echo $extra_fieldset['slug'] ; ?>"
                                                   placeholder="<?php echo $extra_fieldset['title'] ; ?>"
                                                   value="<?php
                                                    if (isset($pageVars["data"]["user"][$extra_fieldset['slug']])) {
                                                        echo $pageVars["data"]["user"][$extra_fieldset['slug']] ;
                                                    }
                                                    ?>" />
                                            <span style="color:#FF0000;" id="update_<?php echo $extra_fieldset['slug'] ; ?>_alert"></span>
                                        </div>
                                    <?php } else if ( $extra_fieldset['type'] === 'textarea') { ?>
                                        <div class="col-sm-7">
                                            <span style="color:#FF0000;" id="update_<?php echo $extra_fieldset['slug'] ; ?>_alert"></span>
                                            <textarea class="form-control"
                                                      id="update_<?php echo $extra_fieldset['slug'] ; ?>"
                                                      name="update_<?php echo $extra_fieldset['slug'] ; ?>" ><?php
                                                if (isset($pageVars["data"]["user"][$extra_fieldset['slug']])) {
                                                    echo $pageVars["data"]["user"][$extra_fieldset['slug']] ;
                                                }
                                                ?></textarea>
                                        </div>
                                    <?php } else if ( $extra_fieldset['type'] === 'boolean') { ?>
                                        <div class="col-sm-7">
                                            <input type="checkbox" class="form-control"
                                                   id="update_<?php echo $extra_fieldset['slug'] ; ?>"
                                                   name="update_<?php echo $extra_fieldset['slug'] ; ?>" <?php
                                            if (isset($pageVars["data"]["user"][$extra_fieldset['slug']]) &&
                                                $pageVars["data"]["user"][$extra_fieldset['slug']] === 'on') {
                                                echo ' checked="checked" ' ; }?>
                                                   placeholder="<?php echo $extra_fieldset['title'] ; ?>" />
                                            <span style="color:#FF0000;" id="update_<?php echo $extra_fieldset['slug'] ; ?>_alert"></span>
                                        </div>
                                    <?php } ?>
                                </div>

                                <?php } ?>

                            <div class="extra_fields_loader hidden" id="extra_fields_loader">
                                <img src="/Assets/Modules/DefaultSkin/image/loader.gif" alt="Updating User" />
                            </div>

                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-3 actionButtonWrap">
                                <a id="update_extra_fields" class="btn btn-success hvr-grow-shadow actionButton">
                                    Update Extra Fields
                                </a>
                            </div>
                        </div>


                    </form>

                </div>
            </div>
     
            <hr>

            <p class="text-center">
                Visit www.pharaohtools.com for more
            </p>
    </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserProfile/css/userprofile.css">
<script type="text/javascript" src="/Assets/Modules/UserProfile/js/userprofile.js"></script>
