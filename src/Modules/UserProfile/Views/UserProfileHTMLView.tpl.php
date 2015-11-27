<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
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
                        <i class="fa fa-cogs fa-fw hvr-bounce-in"></i> Configure PTTrack</a>
                </li>
                <li>
                    <a href="/index.php?control=UserProfile&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-group hvr-bounce-in"></i> User Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-suitcase hvr-bounce-in"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

  <div class="col-lg-9">
                    <div class="well well-lg">
        <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>

                        <?php echo $this->renderLogs() ; ?>

                        <div class="row clearfix no-margin">
           <h4 class="text-uppercase text-primary"><i class="fa fa-users hvr-grow-rotate"></i>User Profile</h4>

            <div class="row clearfix no-margin">
                <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                <p style="color: #7CFC00; margin-left: 100px;" id="registration_error_msg"></p>
                <div class="form-group" id="userprofile-loading-holder">
                </div>
                <div class="form-group" id="userprofile-fields">
                    <form class="form-horizontal custom-form" action="/index.php?control=UserProfile&action=save" method="POST">
                        <div class="form-group">
                            <label for="update_username" class="col-sm-4 control-label text-left" style="color:#757575">User Name</label>
                            <div class="col-sm-7">
                                <?php

                                if ($pageVars["data"]["allusers"] === false) {
                                    ?>


                                    <input type="text" readonly="readonly" class="form-control" id="update_username" name="update_username" placeholder="User Name" value="<?php echo $pageVars["data"]["user"]->username ; ?>">
                                <?php
                                } else {

                                    ?>

                                    <div class="dropdown">
                                        <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                            Select User
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                            <?php
                                            foreach($pageVars["data"]["allusers"] as $oneUser) {
                                                ?>
                                                <li role="presentation">
                                                    <a role="menuitem" tabindex="-1" onclick="refreshUserDetails('<?php echo $oneUser->username ; ?>');">
                                                        <?= $oneUser->username ; ?>
                                                    </a>
                                                </li>
                                            <?php
                                            }
                                            ?>
                                        </ul>
                                        <input type="hidden" class="form-control" id="update_username" name="update_username" value="<?php echo $pageVars["data"]["user"]->username ; ?>">
                                    </div>

                                <?php
                                }
                                ?>
                                <span style="color:#FF0000;" id="update_username_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="update_email" class="col-sm-4 control-label text-left" style="color:#757575">Email</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="update_email" name="update_email"
                                       value="<?php echo $pageVars["data"]["user"]->email ; ?>" placeholder="Email">
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
                            <label for="update_password_match" class="col-sm-4 control-label text-left" style="color:#757575;" >Retype Password</label>
                            <div class="col-sm-7">
                                <input type="password" class="form-control" id="update_password_match" name="update_password_match" placeholder="Retype Password">
                                <span style="color:#FF0000;" id="update_password_match_alert"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-3">
                                <button type="submit" class="btn btn-success hvr-grow-shadow">
                                    Update Details
                                </button>
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
