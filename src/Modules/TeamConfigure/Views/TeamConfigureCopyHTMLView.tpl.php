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
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                ?>
                <li>
                    <a href="/index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class=" hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i> Repository Home
                    </a>
                </li>
                <?php
                }
                ?>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
                <?php
                if ($pageVars["route"]["action"] !== "new") {
                ?>
                <li>
                    <a href="/index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"><?php echo $pageVars["data"]["history_count"] ; ?></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryHome&action=delete&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class=" hvr-bounce-in">
                        <i class="fa fa-trash fa-fw hvr-bounce-in"></i> Delete
                    </a>
                </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
<div class="col-lg-9">

    <div class="well well-lg">

        <?php
        $act = '/index.php?control=RepositoryConfigure&action=copy' ;
        ?>

<!--            <h2 class="text-uppercase text-light"><a href="/"> Build - Pharaoh Tools </a></h2>-->
            <div class="row clearfix no-margin">

                <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <h3>Repository Settings</h3>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>Default Settings - These will apply to the new Repository you create</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-name" class="col-sm-2 control-label text-left">Project Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-name" id="project-name" placeholder="Project Name" value="<?php echo $pageVars["data"]["repository"]["project-name"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-slug" class="col-sm-2 control-label text-left">Project Slug</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="project-slug" id="project-slug" placeholder="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" value="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="project-description" class="col-sm-2 control-label text-left">Description</label>
                        <div class="col-sm-10">
                            <textarea id="project-description" name="project-description" class="form-control"><?php echo $pageVars["data"]["repository"]["project-description"] ; ?></textarea>
                        </div>
                    </div>
                    <hr>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <h4>Pick Repository to Copy:</h4>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="selectorWrap" id="new_step_module_selector_wrap">
                                <?php
                                $count = count($pageVars["data"]["pipe_names"]) ;
                                $size = ($count<10) ? $count : 10 ;
                                ?>
                                <select size="<?php echo $size ; ?>" class="col-sm-12" name="source_repository" id="source_repository">
                                    <?php
                                        foreach ($pageVars["data"]["pipe_names"] as $pipe_slug => $pipe_name) {
                                            echo '  <option value="'.$pipe_name.'">'.$pipe_name.'</option>'; } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" id="bt" class="btn btn-success hvr-float-shadow" data-toggle="tooltip" data-placement="top" title="Create New Repository" data-original-title="Tooltip on right"">Save Configuration</button>
                        </div>
                    </div>
                    <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" />
                </form>
             </div>
             <hr>
             <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
             </p>
        </div>
    </div>
</div><!-- container -->


<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
<!--<link rel="stylesheet" type="text/css" href="/Assets/Modules/RepositoryConfigure/css/repositoryconfigurecopy.css">-->
<script type="text/javascript">
	savedSteps = <?php echo json_encode($pageVars["data"]["repository"]["steps"]) ; ?> ;
    steps = <?php echo json_encode($pageVars["data"]["fields"]) ; ?> ;
</script>
<!--<script type="text/javascript" src="/Assets/Modules/RepositoryConfigure/js/repositoryconfigurecopy.js"></script>-->
<script type="text/javascript">

    $(function() {
        $( "#sortableSteps" ).sortable();
       // $( "#sortableSteps" ).disableSelection();
    });
</script>
