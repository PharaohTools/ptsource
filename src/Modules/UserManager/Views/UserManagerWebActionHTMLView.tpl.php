<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active">
                    Menu
                    <span class="pull-right" id="slide-submenu"> <i class="fa fa-times"></i> </span>
                </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=UserManager&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> User Manager
                </a>
            </div>
        </div>

        <?php
            $act = '/index.php?control=UserManager&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">

                <h3>User and Extension Manager</h3>

                    <div class="form-group">

                        <div class="col-sm-2">
                            <label for="project-name" class="control-label text-left">Git Repository</label>
                        </div>
                        <form class="form-horizontal custom-form" action="<?php echo '/index.php?control=UserManager&action=save' ; ?>" method="POST">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="new-user-repository" id="new-user-repository" placeholder="Git Repository" value="<?php echo $pageVars["data"]["new-user"]["project-name"] ; ?>" />
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Download User</button>
                                        <input type="hidden" name="" id="item" value="" />
                                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                                </div>
                            </div>
                        </form>

                        <div class="form-group">
                            <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                        </div>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-12">

                            <h3>Available Users</h3>

                            <div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">

                                <div class="form-group ui-sortable userList" id="sortableSteps">

                                    <?php

                                    $oddeven = "Odd" ;

                                    foreach ($pageVars["data"]["available_users"] as $modSlug => $one_available_user) {
                                        //echo '<div class="form-group ui-state-default ui-sortable-handle userEntry" id="step'.$modSlug.'">' ;

                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;

                                        echo ' <div class="col-sm-12 userEntry userEntry'.$oddeven.'" id="step'.$modSlug.'">' ;
                                        echo '  <div class="col-sm-8">' ;
                                        echo '   <p><strong>'.$one_available_user["name"].' </strong></p>';
                                        echo '   <p>'.$one_available_user["description"].'</p>';
                                        echo '   <p><strong>Dependencies: </strong>'.implode(", ", $one_available_user["dependencies"]).'</p>';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][user]" name="steps['.$modSlug.'][user]" value="'.$one_available_user["user"].'" />';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][steptype]" name="steps['.$modSlug.'][steptype]" value="'.$one_available_user["steptype"].'" />';
                                        echo '  </div>';
                                        echo '  <div class="col-sm-4">'  ;
                                        echo '   <div class="col-sm-12">' ;
                                        echo '    <a class="btn btn-success text-center" onclick="deleteStepField(hash)">Download</a>' ;
                                        echo '   </div>';
                                        echo '   <div class="col-sm-12">' ;
                                        echo '    <a class="btn btn-success text-center" onclick="deleteStepField(hash)">Download Dependencies</a>' ;
                                        echo '   </div>';
                                        echo '  </div>';
                                        echo ' </div>';
                                        // echo '</div>';
                                    } ?>

                                    <br style="clear: both;" />

                                </div> <!-- sortable end -->

                            </div>

                        </div>

                    </div>

                <!--
                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                    </div>

                </form>
                -->
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- container -->

<link rel="stylesheet" href="/Assets/UserManager/css/usermanager.css">
