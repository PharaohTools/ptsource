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
                            <li>
                                <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="well well-lg">

            <?php echo $this->renderLogs() ; ?>
            <div class="row clearfix no-margin">
           <h4 class="text-uppercase text-primary">
               <i class="fa fa-users hvr-grow-rotate"></i>User Profile
           </h4>

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
                            <div class="col-sm-12 create_new_key_field">
                                <label for="new_ssh_key_title" class="col-sm-4 control-label text-left" style="color:#757575">Title</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" id="new_ssh_key_title" name="new_ssh_key_title" value="" placeholder="Your Key Name" />
                                    <span style="color:#FF0000;" id="new_ssh_key_title_alert"></span>
                                </div>
                            </div>

                            <div class="col-sm-12 create_new_key_field">
                                <label for="new_ssh_key" class="col-sm-4 control-label text-left" style="color:#757575;">SSH Key</label>
                                <div class="col-sm-7">
                                    <textarea class="form-control" id="new_ssh_key" name="new_ssh_key" placeholder="Your Key Content"></textarea>
                                    <span style="color:#FF0000;" id="new_ssh_key_alert"></span>
                                </div>
                            </div>

                            <div class="col-sm-12 create_new_key_field">
                                <div class="col-sm-offset-4 col-sm-3 actionButtonWrap">
                                    <a id="save_new_key" class="btn btn-success hvr-grow-shadow actionButton">
                                        Save this Key
                                    </a>
                                </div>
                            </div>

                            <div class="col-sm-12 loading_keys">
                                <img src="/Assets/Modules/DefaultSkin/image/loader.gif" alt="Loading Keys">
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

                                        <div id="allSSHKeyRows" class="allSSHKeyRows table-hover">

                                            <?php

                                            if (isset($pageVars['data']['public_ssh_keys']) &&
                                                is_array($pageVars['data']['public_ssh_keys']) &&
                                                count($pageVars['data']['public_ssh_keys'])>0) {

                                                $i = 1;

                                                foreach ($pageVars['data']['public_ssh_keys'] as $public_ssh_key) {

                                                    ?>

                                                    <div class="public_ssh_key_row" id="sshkey_<?php echo $public_ssh_key['key_hash'] ; ?>" >
                                                        <div class="blCell cellRowIndex" scope="row"> <?php echo $i; ?> </div>
                                                        <div class="blCell cellRowKeyDetails">
                                                            <div class="fullRow">
                                                                <strong>
                                                                    <?php echo $public_ssh_key['title']; ?>
                                                                </strong>
                                                            </div>
                                                            <div class="fullRow">
                                                                <?php echo $public_ssh_key['key_hash']; ?>
                                                            </div>
                                                            <div class="fullRow">
                                                               Created On: <?php echo $public_ssh_key['created_on_format'] ; ?> — Last Used: <?php echo $public_ssh_key['last_used_format'] ; ?>
                                                            </div>
                                                        </div>
                                                        <div class="blCell cellRowDeleteKey">
                                                            <div class="fullRow">
                                                                <?php if ($public_ssh_key['enabled'] === 'on') {
                                                                    $disable_hidden = '' ;
                                                                    $enable_hidden = ' hidden' ;
                                                                } else {
                                                                    $disable_hidden = ' hidden' ;
                                                                    $enable_hidden = '' ;
                                                                } ?>
                                                                <div class="fullRow">
                                                                    <btn class="btn btn-success <?php echo $enable_hidden ; ?> enable_ssh_key" id="enable_<?php echo $public_ssh_key['key_hash'] ; ?>">
                                                                        Enable
                                                                    </btn>
                                                                    <div class="button_loader hidden" id="enable_<?php echo $public_ssh_key['key_hash'] ; ?>_loading">
                                                                        <img src="/Assets/Modules/UserSSHKey/image/loading.gif" alt="Loading Keys">
                                                                    </div>
                                                                </div>
                                                                <div class="fullRow">
                                                                    <btn class="btn btn-warning <?php echo $disable_hidden ; ?> disable_ssh_key" id="disable_<?php echo $public_ssh_key['key_hash'] ; ?>">
                                                                        Disable
                                                                    </btn>
                                                                    <div class="button_loader hidden" id="disable_<?php echo $public_ssh_key['key_hash'] ; ?>_loading">
                                                                        <img src="/Assets/Modules/UserSSHKey/image/loading.gif" alt="Loading Keys">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="fullRow">
                                                                <btn class="btn btn-danger delete_ssh_key" id="delete_<?php echo $public_ssh_key['key_hash'] ; ?>">
                                                                    Delete
                                                                </btn>
                                                                <div class="button_loader hidden" id="delete_<?php echo $public_ssh_key['key_hash'] ; ?>_loading">
                                                                      <img src="/Assets/Modules/UserSSHKey/image/loading.gif" alt="Loading Keys" />
                                                                </div>
                                                            </div>
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