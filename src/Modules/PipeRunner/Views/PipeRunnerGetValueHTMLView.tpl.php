<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form  hvr-bounce-in">
                        <input type="text" class="form-control" placeholder="Search...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                    </div>
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard fa-fw hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-home fa-fw hvr-bounce-in"></i>  Pipeline Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=BuildList&action=show" class="hvr-bounce-in">
                        <i class="fa fa-bars fa-fw hvr-bounce-in"></i> All Pipelines
                    </a>
                </li>
                <li>
                    <a href="index.php?control=Workspace&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> Workspace
                    </a>
                </li>
                <li>
                    <a href="index.php?control=BuildMonitor&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Monitors
                    </a>
                </li>
                <li>
                    <a href="index.php?control=PipeRunner&action=history&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                    </a>
                </li>
                <li>
                    <a href="index.php?control=PipeRunner&action=start&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"  class="hvr-bounce-in">
                        <i class="fa fa-sign-in fa-fw hvr-bounce-in"></i> Run Again
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <?php $act= "index.php?control=PipeRunner&action=start&item={$pageVars["data"]["pipeline"]["project-slug"]}" ; ?>

    <form class="form-horizontal custom-form" action="<?php echo $act ; ?>" method="POST">

        <div class="col-sm-9 clearfix main-container">
                <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools </a></h2>
                <div class="col-sm-10">
                    <div class="row clearfix no-margin">

                    <h3>Project  <?php echo $pageVars["data"]["pipeline"]["project-name"] ; ?></h3>
                    <h5>This build requires parameters</h5>
                    <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                        <a href="index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>"></a>
                    </h5>
                </div>

                <div class="form-group">
                    <div class="col-sm-10">

                        <?php

                        foreach ($pageVars["data"]["pipeline"]["settings"]["PipeRunParameters"]["parameters"] as $parameter) {

//                            var_dump($parameter) ;

                            if ($parameter["param_type"]=="text") {
                                ?>

                            <div class="col-sm-4">
                                <label for="build-parameters[<?php echo $parameter["param_name"] ; ?>]" class="control-label text-left"><?php echo $parameter["param_name"] ; ?></label>
                            </div>

                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="build-parameters[<?php echo $parameter["param_name"] ; ?>]" id="build-parameters[<?php echo $parameter["param_name"] ; ?>]" value="<?php echo $parameter["param_default"] ; ?>" />
                            </div>

                                <?php
                            }

                            else if ($parameter["param_type"]=="textarea") {
                                ?>

                                <div class="col-sm-4">
                                    <label for="build-parameters[<?php echo $parameter["param_name"] ; ?>]" class="control-label text-left"><?php echo $parameter["param_name"] ; ?></label>
                                </div>

                                <div class="col-sm-8">
                                    <textarea class="form-control col-sm-7" name="build-parameters[<?php echo $parameter["param_name"] ; ?>]" id="build-parameters[<?php echo $parameter["param_name"] ; ?>]"><?php echo $parameter["param_default"] ; ?></textarea>
                                </div>

                            <?php
                            }

                            else if ($parameter["param_type"]=="options") {

//                              var_dump("parameter", $parameter) ;

                                ?>

                                <div class="col-sm-4">
                                    <label for="build-parameters[<?php echo $parameter["param_name"] ; ?>]" class="control-label text-left"><?php echo $parameter["param_name"] ; ?></label>
                                </div>

                                <div class="col-sm-8">

                                    <select name="build-parameters[<?php echo $parameter["param_name"] ; ?>]" id="build-parameters[<?php echo $parameter["param_name"] ; ?>]">
                                        <?php
                                            $original_options = explode("\n", $parameter["param_options"]) ;
                                            foreach ($original_options as $option_value) {
                                                $option_value = rtrim($option_value) ;
//                                                var_dump($option_value, $parameter["param_default"]) ;
                                                if ($option_value == $parameter["param_default"]) { $selstring = " selected='selected' " ; }
                                                else { $selstring = "" ; }
                                                echo '<option '.$selstring.' value="'.$option_value.'">'.$option_value.'</option>' ; }
                                        ?>
                                    </select>

                                </div>

                            <?php
                            }

                            else if ($parameter["param_type"]=="boolean") {
                                ?>

                                <div class="col-sm-4">
                                    <label for="build-parameters[<?php echo $parameter["param_name"] ; ?>]" class="control-label text-right"><?php echo $parameter["param_name"] ; ?></label>
                                </div>

                                <div class="col-sm-8">
                                    <input type="checkbox" class="text-left form-control" name="build-parameters[<?php echo $parameter["param_name"] ; ?>]" id="build-parameters[<?php echo $parameter["param_name"] ; ?>]" value="<?php echo $parameter["param_type"] ; ?>" />
                                </div>


                            <?php
                            }

                            ?>
                            <?php
                        }

                        ?>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-4"><br>
                        <button type="submit" class="btn btn-success">Build</button>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-12">

                        <input type="hidden" name="item" id="item" value="<?php echo $pageVars["data"]["pipeline"]["project-slug"] ; ?>" />

                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-12">
                        <hr>
                        <p class="text-center">
                            Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </form>
</div><!-- /.container -->
