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
                <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-search"></i> Pipeline Home
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> All Pipelines
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Delete
                </a>
                <a href="/index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
                </a>
            </div>
        </div>

        <?php
            $act = '/index.php?control=BuildConfigure&item='.$pageVars["data"]["pipeline"]["project-slug"].'&action=save' ;
        ?>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">

                <h3><a class="lg-anchor text-light" href="#">Build Configure <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>

                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>">
                        Pipeline Summary for <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>-</a>
                </h5>

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <label for="project-name" class="col-sm-2 control-label text-left">Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-name" id="project-name" placeholder="Project Name" value="<?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left">Project Slug</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-slug" id="project-slug" placeholder="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-description" class="col-sm-2 control-label text-left">Description</label>
                        <div class="col-sm-10">
                            <textarea id="project-description" name="project-description" class="form-control"><?php echo $pageVars["data"]["pipeline"]["project-description"] ; ?></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="default-scm-url" class="col-sm-2 control-label text-left">Default SCM URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="default-scm-url" name="default-scm-url" placeholder="Git URL" value="<?php echo $pageVars["data"]["pipeline"]["default-scm-url"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Build Steps</h3>
                        </div>
                    </div>

                    <?php
                        foreach ($pageVars["data"]["pipeline"]["steps"] as $one_build_step) {
                            echo '<div class="form-group">' ;
                            echo '  <label for="'.$one_build_step["hash"].'" class="col-sm-2 control-label text-left">'.$one_build_step["title"].'</label>' ;
                            echo '  <div class="col-sm-10">' ;
                            echo '      <p>'.$one_build_step["title"].'</p>';
                            echo '      <p>Step Type: '.$one_build_step["type"]."</p>";
                            echo '      <textarea id="'.$one_build_step["hash"].'" name="'.$one_build_step["hash"].'" class="form-control">'.$one_build_step["value"].'</textarea>';
                            echo '  </div>';
                            echo '</div>'; } ?>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <h5>Add New Step</h5>
                            <div class="seletorWrap" id="new_step_module_selector_wrap">
                                <select name="new_step_module_selector" id="new_step_module_selector" onchange="changeModule(this)">
                                    <option value="">-- Select Step --</option>
                                    <?php

                                    foreach ($pageVars["data"]["builders"] as $builderName => $builderBits) {
                                        foreach ($builderBits["step-types"] as $step_type) {
                                            echo '  <option value="'.$builderName.'_'.$step_type.'">'.$builderName.', '.$step_type.'</option>'; } }

                                    ?>
                                </select>
                            </div>
                            <div class="seletorWrap" id="new_step_type_selector_wrap">
                                <select name="new_step_type_selector" id="new_step_type_selector" onchange="changeStepType(this)">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-success">Save Configuration</button>
                        </div>
                    </div>

                    <script type="text/javascript" src="/Assets/BuildConfigure/js/buildconfigure.js"></script>

                    <?php

                    if ($pageVars["route"]["action"] == "new") {
                        echo '<input type="hidden" name="creation" id="creation" value="yes" />' ;
                    }

                    ?>

                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />

                    <h5 class="text-uppercase text-light">
                        <a href="/index.php?control=BuildConfigure&action=save">
                            Save configuration of <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>-</a>
                    </h5>

                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->