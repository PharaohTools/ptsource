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
                            Submenu
                            <span class="pull-right" id="slide-submenu">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                <a href="#" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-search"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-user"></i> Lorem ipsum
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Lorem ipsum <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Lorem ipsumr <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> Lorem ipsum
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools</a></h2>

            <div class="row clearfix no-margin">
                <h4 class="text-uppercase text-light">A list of builds in a page</h4>
                <h3><a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-custom">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Bulid Name</th>
                            <th>Table heading</th>
                            <th>Table heading</th>
                        </tr>
                        </thead>
                        <tbody class="table-hover">
                        <tr>
                            <th scope="row">1</th>
                            <td><a href="/index.php?control=BuildHome&action=show&item=some_build_1">Build Home for some_build 1</a></td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td><a href="/index.php?control=BuildHome&action=show&item=some_build_2">Build Home for some_build 2</a></td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td><a href="/index.php?control=BuildHome&action=show&item=some_build_3">Build Home for some_build 3</a></td>
                            <td>Table cell</td>
                            <td>Table cell</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php

            foreach ($pageVars["build"] as $build) {
                if ($moduleInfo["hidden"] != true) {
                    echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
                }
            }

            ?>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>
        </div>


    </div>

</div><!-- /.container -->
