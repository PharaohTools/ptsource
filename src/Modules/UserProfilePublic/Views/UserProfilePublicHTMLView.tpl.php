<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="thin_padding" id="show_menu_wrapper">
                        <button class="btn btn-success" id="show_menu_button" type="button">
                            Show Menu
                        </button>
                    </div>
                    <div class="thin_padding" id="hide_menu_wrapper">
                        <button class="btn btn-info" id="hide_menu_button" type="button">
                            Hide Menu
                        </button>
                    </div>
                </li>
                <li>
                    <a class=" hvr-bounce-in">
                        <i class="fa fa-user fa-fw"></i> User Menu <span class="fa arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show" class=" hvr-curl-bottom-right">User Manager</a>
                </li>
                <li>
                    <a href="/index.php?control=UserProfile&action=show" class=" hvr-curl-bottom-right">Edit Profile</a>
                </li>
                <li>
                    <a href="/index.php?control=UserProfilePublic&action=show" class=" hvr-curl-bottom-right active">Public Profile</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9">
        <div class="well well-lg">

            <?php echo $this->renderLogs() ; ?>

            <div class="row clearfix no-margin">
                <h4 class="text-uppercase text-primary">
                    <i class="fa fa-users hvr-grow-rotate"></i>User Profile
                </h4>

                <?php

                if ($pageVars['route']['action'] == "show") {
                ?>
                    <h5 class="text-uppercase text-primary">User Profile</h5>
                <?php
                }
                ?>

                <div class="form-group">
                    <div class="col-sm-4">
                        <div id="avatar">
                            <?php

                            if (isset($pageVars['data']['user']->avatar) &&
                                is_string($pageVars['data']['user']->avatar) &&
                            (strlen($pageVars['data']['user']->avatar) > 3 )) {
                                ?>
                                <img src="<?php echo $pageVars['data']['user']->avatar ; ?>" alt="Your Avatar" />
                            <?php } else { ?>
                                <h4>
                                    No Avatar Stored
                                </h4>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-sm-8">

                        <?php
                        if (isset($pageVars['data']['user']->full_name)) { ?>
                            <h3>
                                <?php echo $pageVars['data']['user']->full_name ; ?>
                            </h3>
                        <?php } else { ?>
                            <h5>
                                No Full Name Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->username)) { ?>
                            <h4>
                                <?php echo $pageVars['data']['user']->username ; ?>
                            </h4>
                        <?php } else { ?>
                            <h5>
                                No User Name Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->created_on)) { ?>
                            <h4>
                                <?php echo date('H:i d/m/Y', $pageVars['data']['user']->created_on) ; ?>
                            </h4>
                        <?php } else { ?>
                            <h5>
                                No Join Date Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->user_bio)) { ?>
                            <h6>
                                <?php echo $pageVars['data']['user']->user_bio ; ?>
                            </h6>
                        <?php } else { ?>
                            <h5>
                                No User Bio Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->email)) {
                            if (isset($pageVars['data']['user']->display_email) &&
                                $pageVars['data']['user']->display_email === 'on') { ?>
                                <h5>
                                    <?php echo $pageVars['data']['user']->email ; ?>
                                </h5>
                            <?php } else { ?>
                                <h5>E-Mail Hidden</h5>
                            <?php } ?>
                        <?php } else { ?>
                            <h5>
                                No User Email Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->website)) {
                            if (isset($pageVars['data']['user']->display_website) &&
                                $pageVars['data']['user']->display_website === 'on') { ?>
                                <h5>
                                    <?php echo $pageVars['data']['user']->website ; ?>
                                </h5>
                            <?php } else { ?>
                                <h5>Website Hidden</h5>
                            <?php } ?>
                        <?php } else { ?>
                            <h5>
                                No Website Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->location)) {
                            if (isset($pageVars['data']['user']->display_location) &&
                                $pageVars['data']['user']->display_location === 'on') { ?>
                                <h5>
                                    <?php echo $pageVars['data']['user']->location ; ?>
                                </h5>
                            <?php } else { ?>
                                <h5>Location Hidden</h5>
                            <?php } ?>
                        <?php } else { ?>
                            <h5>
                                No Location Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user_teams']) && is_array($pageVars['data']['user_teams'])) {
                            foreach ($pageVars['data']['user_teams'] as $team) { ?>
                                <div class="one_team">
                                    <div class="one_team_logo">
                                        <a href="<?php echo $team['link'] ; ?>" class="one_team_link">
                                            <img src="<?php echo $team['image'] ; ?>" class="one_team_image" />
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <h5>
                                No User Teams
                            </h5>
                        <?php } ?>

                    </div>
                </div>

                <div class="form-group" id="userprofilepublic-fields">
                    <form class="form-horizontal custom-form"
                          action="/index.php?control=UserProfilePublic&action=create"
                          method="POST">

                        <?php

                        if ( isset($pageVars['data']['popular_repositories']) &&
                             is_array($pageVars['data']['popular_repositories']) ) {
                            ?>
                            <div class="row clearfix form-group col-sm-12">
                                <h4>Popular Repositories</h4>
                                <?php
                                foreach ($pageVars['data']['popular_repositories'] as $one_repo) {
                                    ?>
                                    <p>
                                        A popular repo
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        <?php  }

                        if ( isset($pageVars['data']['contribution_activity']) &&
                             is_array($pageVars['data']['contribution_activity']) ) {
                            ?>
                            <div class="row clearfix form-group col-sm-12">
                                <h4>Contribution Activity</h4>
                                <?php
                                foreach ($pageVars['data']['contribution_activity'] as $contribution_activity) {
                                    ?>
                                    <p>
                                        A single contribution
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        <?php  }

                        if ( isset($pageVars['data']['recent_contributions']) &&
                             is_array($pageVars['data']['recent_contributions']) ) {
                            ?>
                            <div class="form-group col-sm-12">
                                <h4>Recent Contributions</h4>
                                <?php
                                foreach ($pageVars['data']['recent_contributions'] as $contribution) {
                                    ?>
                                    <p>
                                        A recent contribution
                                    </p>
                                <?php
                                }
                                ?>
                            </div>
                        <?php  } ?>


                    </form>

                </div>

            <hr />

            <div class="form-group col-sm-12">
                <p class="text-center">
                    Visit www.pharaohtools.com for more
                </p>
            </div>

    </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserProfilePublic/css/userprofilepublic.css">
