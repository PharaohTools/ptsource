<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav ">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search  ">
                    <div class="input-group custom-search-form  hvr-bounce-in">
                        <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                    </div>
                    <!-- /input-group -->
                </li>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=Integrations&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> Module Manager
                </a>
            </div>
        </div>

        <?php
            $act = '/index.php?control=Integrations&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>

         <div class="col-lg-9">
                    <div class="well well-lg"> 
<!--            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>-->
            <div class="row clearfix no-margin">

                <h3>Module and Extension Manager</h3>

                    <div class="form-group">

                        <div class="col-sm-2">
                            <label for="project-name" class="control-label text-left">Git Repository</label>
                        </div>
                        <form class="form-horizontal custom-form" action="<?php echo '/index.php?control=Integrations&action=save' ; ?>" method="POST">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="new-module-repository" id="new-module-repository" placeholder="Git Repository" value="<?php echo $pageVars["data"]["new-module"]["project-name"] ; ?>" />
                            </div>

                            <div class="form-group">
                                <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success">Download Module</button>
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
                       <?php

                       if($pageVars["data"]["available_modules"]!=null)
									{?>
									  <h3>Available Modules</h3>
					  <?php

									}?>
                            

                            <div class="col-sm-12" style="height: 150px; overflow-y: scroll; resize:both;">

                                <div class="form-group ui-sortable moduleList" id="sortableSteps">

                                    <?php
                                   

                                    $oddeven = "Odd" ;

                                    foreach ($pageVars["data"]["available_modules"] as $modSlug => $one_available_module) {
                                        //echo '<div class="form-group ui-state-default ui-sortable-handle moduleEntry" id="step'.$modSlug.'">' ;

                                        $oddeven = ($oddeven == "Odd") ? "Even" : "Odd" ;

                                        echo ' <div class="col-sm-12 moduleEntry moduleEntry'.$oddeven.'" id="step'.$modSlug.'">' ;
                                        echo '  <div class="col-sm-8">' ;
                                        echo '   <p><strong>'.$one_available_module["name"].' </strong></p>';
                                        echo '   <p>'.$one_available_module["description"].'</p>';
                                        echo '   <p><strong>Dependencies: </strong>'.implode(", ", $one_available_module["dependencies"]).'</p>';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][module]" name="steps['.$modSlug.'][module]" value="'.$one_available_module["module"].'" />';
                                        echo '   <input type="hidden" id="steps['.$modSlug.'][steptype]" name="steps['.$modSlug.'][steptype]" value="'.$one_available_module["steptype"].'" />';
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
            <hr>
              <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>

        </div>

    </div>
</div><!-- container -->

<link rel="stylesheet" href="/Assets/Integrations/css/integrations.css">