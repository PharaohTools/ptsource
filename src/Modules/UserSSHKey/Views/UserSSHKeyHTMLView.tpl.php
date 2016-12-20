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
                        <i class="fa fa-cogs fa-fw"></i> Configure PTBuild<span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level collapse">
                        <li>
                            <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-curl-bottom-right">Application</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">User Manager</a>
                        </li>
                        <li>
                            <a href="/index.php?control=UserSSHKey&action=show" class=" hvr-curl-bottom-right">User Profile</a>
                        </li>
                        <li>
                            <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
            </ul>
        </div>
    </div>

  <div class="col-lg-9">
        <div class="well well-lg">
            <?php echo $this->renderLogs() ; ?>
            <div class="row clearfix no-margin">
           <h4 class="text-uppercase text-primary"><i class="fa fa-users hvr-grow-rotate"></i>User Profile</h4>

                <div class="row clearfix no-margin">
                <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                <div class="col-sm-12" id="usersshkey-loading-holder">
                </div>
                <div class="col-sm-12">
                    <span style="color:#FF0000;" id="form_alert"></span>
                    <a id="create_new_key" class="btn btn-success hvr-grow-shadow leftAlignButton">
                        Create New Key
                    </a>
                </div>
                <div class="col-sm-12" id="create_new_key_fields">
                    <form class="form-horizontal custom-form" action="/index.php?control=UserSSHKey&action=create" method="POST">

                        <div class="col-sm-12">
                            <label for="new_ssh_key_title" class="col-sm-4 control-label text-left" style="color:#757575">Title</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" id="new_ssh_key_title" name="new_ssh_key_title" value="" placeholder="Your Key Name" />
                                <span style="color:#FF0000;" id="new_ssh_key_title_alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <label for="new_ssh_key" class="col-sm-4 control-label text-left" style="color:#757575;">SSH Key</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" id="new_ssh_key" name="new_ssh_key">Your New Key</textarea>
                                <span style="color:#FF0000;" id="new_ssh_key_alert"></span>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="col-sm-offset-4 col-sm-3 actionButtonWrap">
                                <a id="save_new_key" class="btn btn-success hvr-grow-shadow actionButton">
                                    Save this Key
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-sm-12">
                    <h4 class="text-uppercase text-light">SSH Keys</h4>

                    <div role="tabpanel grid">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">

                                        <div class="allSSHKeyRows table-hover">

                                            <?php

                                            if (isset($pageVars['data']['public_ssh_keys']) &&
                                                is_array($pageVars['data']['public_ssh_keys']) &&
                                                count($pageVars['data']['public_ssh_keys'])>0) {

                                                $i = 1;

                                                foreach ($pageVars['data']['public_ssh_keys'] as $public_ssh_key) {

                                                    ?>

                                                    <div class="public_ssh_key_row" id="blRow_<?php echo $public_ssh_key['fingerprint']; ?>" >
                                                        <div class="blCell cellRowIndex" scope="row"> <?php echo $i; ?> </div>
                                                        <div class="blCell cellRowKeyDetails">
                                                            <div class="fullRow">
                                                                <?php echo $public_ssh_key['title']; ?>
                                                            </div>
                                                            <div class="fullRow">
                                                                <?php echo $public_ssh_key['fingerprint']; ?>
                                                            </div>
                                                            <div class="fullRow">
                                                                Key Creation Data — Last used within the last 4 days
                                                            </div>
                                                        </div>
                                                        <div class="blCell cellRowDeleteKey">
                                                            <btn class="btn btn-warning">Delete</btn>
                                                        </div>
                                                    </div>

                                                    <?php

                                                    $i++ ;
                                                } }

                                            else {
                                                ?>

                                                <h4>No Public SSH Keys found attached to this account</h4>

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
            </div>
     
            <hr />

            <p class="text-center">
                Visit www.pharaohtools.com for more
            </p>
        </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserSSHKey/css/usersshkey.css">