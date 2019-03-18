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
                            <a href="/index.php?control=ModuleManager&action=show" class=" hvr-curl-bottom-right">Modules</a>
                        </li>
                        <li>
                            <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                        </li>
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

    <div class="col-lg-12">
        <div class="well well-lg">
            <?php echo $this->renderLogs() ; ?>
            <div class="row clearfix no-margin">
           <h2>OAuth Keys</h2>

                <div class="row clearfix no-margin">
                <h5 class="text-uppercase text-light" style="margin-top: 15px;margin-left: 51px;">  </h5>
                <div class="col-sm-12" id="useroauthkey-loading-holder">
                </div>
                <div class="col-sm-12">
                    <span style="color:#FF0000;" id="form_alert"></span>
                    <a id="create_new_key" class="btn btn-success hvr-grow-shadow leftAlignButton">
                        Create New Key
                    </a>
                </div>
                <div class="col-sm-12" id="create_new_key_fields">
                    <form class="form-horizontal custom-form" action="/index.php?control=UserOAuthKey&action=create" method="POST">

                        <div class="col-sm-12">
                            <div class="col-sm-12 create_new_key_field">
                                <label for="new_oauth_key_title" class="col-sm-4 control-label text-left" style="color:#757575">Title</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="new_oauth_key_title" name="new_oauth_key_title" value="" placeholder="Your Key Name" />
                                    <span style="color:#FF0000;" id="new_oauth_key_title_alert"></span>
                                </div>
                            </div>

                            <div class="col-sm-12 create_new_key_field">
                                <label for="new_oauth_key" class="col-sm-4 control-label text-left" style="color:#757575;">OAuth Key</label>
                                <div class="col-sm-7">
                                    <input class="form-control" id="new_oauth_key" name="new_oauth_key" placeholder="To Be Generated" readonly="readonly"/>
                                    <span style="color:#FF0000;" id="new_oauth_key_alert"></span>
                                </div>
                            </div>

                            <div class="col-sm-12 loading_keys">
                                <img src="/Assets/Modules/UserOAuthKey/image/loading.gif" alt="Loading Keys">
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
                    <h4 class="text-uppercase text-light">OAuth Keys</h4>

                    <div role="tabpanel grid">

                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="all">
                                <div class="table-responsive">
                                    <div class="table table-striped table-bordered table-condensed">

                                        <div id="allOAuthKeyRows" class="allOAuthKeyRows table-hover">

                                            <?php

                                            if (isset($pageVars['data']['public_oauth_keys']) &&
                                                is_array($pageVars['data']['public_oauth_keys']) &&
                                                count($pageVars['data']['public_oauth_keys'])>0) {

                                                $i = 1;

                                                foreach ($pageVars['data']['public_oauth_keys'] as $public_oauth_key) {

                                                    ?>

                                                    <div class="public_oauth_key_row" id="oauthkey_<?php echo $public_oauth_key['key_hash'] ; ?>" >
                                                        <div class="blCell cellRowIndex" scope="row"> <?php echo $i; ?> </div>
                                                        <div class="blCell cellRowKeyDetails">
                                                            <div class="fullRow">
                                                                <strong>
                                                                    <?php echo $public_oauth_key['title']; ?>
                                                                </strong>
                                                            </div>
                                                            <div class="fullRow">
                                                                <?php echo $public_oauth_key['fingerprint']; ?>
                                                            </div>
                                                            <div class="fullRow">
                                                               Created On: <?php echo $public_oauth_key['created_on_format'] ; ?> — Last Used: <?php echo $public_oauth_key['last_used_format'] ; ?>
                                                            </div>
                                                        </div>
                                                        <div class="blCell cellRowDeleteKey">
                                                            <div class="fullRow">
                                                                <?php if ($public_oauth_key['enabled'] === 'on') {
                                                                    $disable_hidden = '' ;
                                                                    $enable_hidden = ' hidden' ;
                                                                } else {
                                                                    $disable_hidden = ' hidden' ;
                                                                    $enable_hidden = '' ;
                                                                } ?>
                                                                <div class="fullRow">
                                                                    <btn class="btn btn-success <?php echo $enable_hidden ; ?> enable_oauth_key"
                                                                         data-source_hash="<?php echo $public_oauth_key['key_hash'] ; ?>"
                                                                         id="enable_<?php echo $public_oauth_key['key_hash'] ; ?>">
                                                                        Enable
                                                                    </btn>
                                                                    <div class="button_loader hidden"
                                                                         id="enable_<?php echo $public_oauth_key['key_hash'] ; ?>_loading">
                                                                        <img src="/Assets/Modules/UserOAuthKey/image/loading.gif" alt="Loading Keys">
                                                                    </div>
                                                                </div>
                                                                <div class="fullRow">
                                                                    <btn class="btn btn-warning <?php echo $disable_hidden ; ?> disable_oauth_key"
                                                                         data-source_hash="<?php echo $public_oauth_key['key_hash'] ; ?>"
                                                                         id="disable_<?php echo $public_oauth_key['key_hash'] ; ?>">
                                                                        Disable
                                                                    </btn>
                                                                    <div class="button_loader hidden" id="disable_<?php echo $public_oauth_key['key_hash'] ; ?>_loading">
                                                                        <img src="/Assets/Modules/UserOAuthKey/image/loading.gif" alt="Loading Keys">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="fullRow">
                                                                <btn class="btn btn-danger delete_oauth_key"
                                                                     data-source_hash="<?php echo $public_oauth_key['key_hash'] ; ?>"
                                                                     id="delete_<?php echo $public_oauth_key['key_hash'] ; ?>">
                                                                    Delete
                                                                </btn>
                                                                <div class="button_loader hidden" id="delete_<?php echo $public_oauth_key['key_hash'] ; ?>_loading">
                                                                      <img src="/Assets/Modules/UserOAuthKey/image/loading.gif" alt="Loading Keys" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php

                                                    $i++ ;
                                                } }

                                            else {
                                                ?>

                                                <h4>No Public OAuth Keys found attached to this account</h4>

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
        </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserOAuthKey/css/useroauthkey.css">