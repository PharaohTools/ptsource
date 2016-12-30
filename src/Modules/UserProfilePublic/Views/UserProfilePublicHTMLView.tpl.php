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
                                <strong>Username: </strong>
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
                                <strong>Joined On: </strong>
                                <?php echo date('H:i d/m/Y', $pageVars['data']['user']->created_on) ; ?>
                            </h4>
                        <?php } else { ?>
                            <h5>
                                No Join Date Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->user_bio)) { ?>
                            <h5>
                                <strong>Bio: </strong>
                                <?php echo $pageVars['data']['user']->user_bio ; ?>
                            </h5>
                        <?php } else { ?>
                            <h5>
                                No User Bio Stored
                            </h5>
                        <?php } ?>

                        <?php
                        if (isset($pageVars['data']['user']->email)) {
                            if (isset($pageVars['data']['user']->show_email) &&
                                $pageVars['data']['user']->show_email === 'on') { ?>
                                <h5>
                                    <strong>E-Mail: </strong>
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
                            if (isset($pageVars['data']['user']->show_website) &&
                                $pageVars['data']['user']->show_website === 'on') { ?>
                                <h5>
                                    <strong>Site: </strong>
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
                            if (isset($pageVars['data']['user']->show_location) &&
                                $pageVars['data']['user']->show_location === 'on') { ?>
                                <h5>
                                    <strong>Location: </strong>
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

                    </div>
                </div>

                <div class="form-group" id="userprofilepublic-fields">
                    <form class="form-horizontal custom-form"
                          action="/index.php?control=UserProfilePublic&action=create"
                          method="POST">

                        <?php

                        if ( isset($pageVars['data']['my_repositories']) &&
                             is_array($pageVars['data']['my_repositories']) ) {
                            ?>
                            <div class="row clearfix form-group col-sm-12">
                                <h4>My Repositories</h4>
                                <?php

                                $i = 0 ;
                                $count = 0 ;

                                foreach ($pageVars['data']['my_repositories'] as $one_repo) {

                                    if ($i === 0) { ?>

                                <div class="profile_repository_row fullRow">

                                    <?php } ?>

                                    <div class="col-sm-4">
                                        <div class="profile_repository col-sm-12">
                                            <div class="profile_repository_title col-sm-12">
                                                <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $one_repo['project-slug']; ?>">
                                                    <h4>
                                                        <?php echo $one_repo['project-name'] ; ?>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div class="profile_repository_description col-sm-12">
                                                <p>
                                                    <?php echo $one_repo['project-description'] ; ?>
                                                </p>
                                            </div>
                                            <div class="profile_repository_features col-sm-12">

                                                <?php

                                                if (isset($one_repo['features']) &&
                                                    count($one_repo['features'])>0 ) {
                                                    foreach ($one_repo['features'] as $repository_feature) {
                                                        echo '<div class="repository-feature">' ;
                                                        echo ' <a target="_blank" href="'.$repository_feature['model']['link'].'">' ;
                                                        echo '  <img src="'.$repository_feature['model']['image'].'" />' ;
                                                        echo ' </a>' ;
                                                        echo '</div>' ; } }
                                                else {
                                                    echo '&nbsp;' ; }

                                                ?>

                                            </div>
                                        </div>
                                    </div>



                                    <?php

                                    $count++ ;
                                    $i++ ;
                                    if ($i === 3 || $count >= count($pageVars['data']['my_repositories'])) {

                                        $i = 0 ;
                                        ?>

                                </div> <!-- profile_repository_row-->

                                    <?php }  } ?>

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
                        <?php  }

                        if ( isset($pageVars['data']['my_member_repositories']) &&
                             is_array($pageVars['data']['my_member_repositories']) ) {
                            ?>
                            <div class="row clearfix form-group col-sm-12">
                                <h4>Repositories I am a Member of</h4>
                                <?php

                                $i = 1 ;
                                $count = 0 ;

                                foreach ($pageVars['data']['my_member_repositories'] as $one_repo) {

                                    if ($i === 1) { ?>

                                <div class="profile_repository_row fullRow">

                                    <?php }  ?>

                                    <div class="col-sm-4">
                                        <div class="profile_repository col-sm-12">
                                            <div class="profile_repository_title col-sm-12">
                                                <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $one_repo['project-slug']; ?>">
                                                    <h4>
                                                        <?php echo $one_repo['project-name'] ; ?>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div class="profile_repository_description col-sm-12">
                                                <p>
                                                    <?php echo $one_repo['project-description'] ; ?>
                                                </p>
                                            </div>
                                            <div class="profile_repository_features col-sm-12">

                                                <?php

                                                if (isset($one_repo['features']) &&
                                                    count($one_repo['features'])>0 ) {
                                                    foreach ($one_repo['features'] as $repository_feature) {
                                                        echo '<div class="repository-feature">' ;
                                                        echo ' <a target="_blank" href="'.$repository_feature['model']['link'].'">' ;
                                                        echo '  <img src="'.$repository_feature['model']['image'].'" />' ;
                                                        echo ' </a>' ;
                                                        echo '</div>' ; } }
                                                else {
                                                    echo '&nbsp;' ; }

                                                ?>

                                            </div>
                                        </div>
                                    </div>

                                    <?php

                                    $count++ ;
                                    if ($i === 3 || $count >= count($pageVars['data']['my_member_repositories'])) {

                                        $i = 1 ;
                                        ?>

                                </div> <!-- profile_repository_row-->

                                <?php }  } ?>

                            </div>
                        <?php  }

                        if ( isset($pageVars['data']['my_teams']) &&
                             is_array($pageVars['data']['my_teams']) ) {
                            ?>
                            <div class="row clearfix form-group col-sm-12">
                                <h4>My Teams</h4>
                                <?php
                                foreach ($pageVars['data']['my_teams'] as $one_team) {
                                    ?>
                                    <div class="col-sm-4">
                                        <div class="profile_team col-sm-12">
                                            <div class="profile_team_title col-sm-12">
                                                <a href="/index.php?control=TeamHome&action=show&item=<?php echo $one_team['team-slug']; ?>">
                                                    <h4>
                                                        <?php echo $one_team['team-name'] ; ?>
                                                    </h4>
                                                </a>
                                            </div>
                                            <div class="profile_team_description col-sm-12">
                                                <p>
                                                    <?php echo $one_team['team-description'] ; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
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
