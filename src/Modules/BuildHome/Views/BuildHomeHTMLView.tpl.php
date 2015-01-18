<div class="container">
    <div class="row">
        <div class="col-sm-4 col-md-3 sidebar">
            <div class="mini-submenu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </div>
            <div class="list-group sidebar-list">
                <span href="#" class="list-group-item active"> Menu <span class="pull-right" id="slide-submenu">
                    <i class="fa fa-times"></i>
                </span> </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> All Pipelines
                </a>
                <a href="/index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
                    <i class="fa fa-user"></i> Configure
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Changes <span class="badge">3</span>
                </a>
                <a href="/index.php?control=BuildHome&action=delete&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="list-group-item">
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
        <?php if($pageVars["route"]["action"] == "show"){ ?>
            <div class="col-sm-8 col-md-9 clearfix main-container">
                <h4 class="text-uppercase text-light">Pipeline</h4>
                <div class="row clearfix no-margin">
                    <!--
                    <h3><a class="lg-anchor text-light" href="">Phrankinsense - Pharaoh Tools <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                    -->
                    <p> Project Name: <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?></p>
                    <p> Project Slug: <?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?></p>
                    <p> Project Description: <?php echo $pageVars["data"]["pipeline"]["project-description"] ; ?></p>
                </div>
                <hr>
                <div class="row clearfix no-margin">
                    <h3><a class="lg-anchor text-light" href="/index.php?control=BuildConfigure&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>">
                            Configure Pipeline: <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>- <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                    <p>Build Status Currently:</p>
                    <div class="pipe-now-status-block pipe-block"></div>
                    <p>Build Monitors:</p>
                    <div class="pipe-monitor-block pipe-block"></div>
                    <p>Build Plugins/Features:</p>
                    <div class="pipe-features-block pipe-block"></div>
                    <p>Build History:</p>
                    <div class="pipe-history-block pipe-block">

                        <?php

                        foreach ($pageVars["data"]["pipeline"]["build_history"] as $build_history) {
                            if ($moduleInfo["hidden"] != true) {
                                echo '<p><a href="/index.php?control=BuildConfigure&action=show&item=">'.$build_history["count"].' - '.$build_history["status"].' - '.$build_history["message"]."</p>";
                            }
                        }

                        ?>
                    </div>

                    <p>
                        ---------------------------------------<br/>
                        Visit www.pharaohtools.com for more
                    </p>
                </div>

            </div>
        <?php } if($pageVars["route"]["action"] == "new"){ ?>
            <div class="col-sm-8 col-md-9 clearfix main-container">
                <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
                <div class="row clearfix no-margin">
                    <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                            Add New Pipeline
                    </h5>
                    <form class="form-horizontal custom-form">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label text-left">Project Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="Project Name" value="<?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label text-left">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label text-left">Git URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputPassword3" placeholder="Git URL" value="<?php echo $pageVars["data"]["pipeline"]["git_url"]["value"] ; ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10">
                                <h3>Build Steps</h3>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label text-left" for="inputPassword3">Build Step 1</label>
                            <div class="col-sm-10">
                                <p>Build Step 1</p>
                                <p>Step Type: BashShell</p>
                                <textarea class="form-control">Lets do a git clone or something</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label text-left" for="inputPassword3">Build Step 1</label>
                            <div class="col-sm-10">
                                <p>Build Step 1</p>
                                <p>Step Type: BashShell</p>
                                <textarea class="form-control">Lets do a git clone or something</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info">Configure</button>
                            </div>
                        </div>

                    </form>
                </div>
                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>

            </div>
        <?php } if($pageVars["route"]["action"] == "delete"){ ?>
            <div class="col-sm-8 col-md-9 clearfix main-container">
                <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
                <div class="row clearfix no-margin">
                    <br><br><br>
                    <h2 class="text-uppercase text-light" style="margin-top: 15px;">
                        Successfully deleted!!  Pipeline: <?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>
                    </h2>
                    <br><br><br>

                </div>
                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>

            </div>
        <?php }?>

    </div>
</div><!-- /.container -->