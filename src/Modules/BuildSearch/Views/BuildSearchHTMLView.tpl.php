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
                            <span class="pull-right" id="slide-submenu">
                                <i class="fa fa-times"></i>
                            </span>
                        </span>
                <a href="/index.php?control=Index&action=show" class="list-group-item">
                    <i class="fa fa-comment-o"></i> Dashboard
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-search"></i> Configure PTBuild
                </a>
                <a href="/index.php?control=BuildConfigure&action=new" class="list-group-item">
                    <i class="fa fa-user"></i> New Pipeline
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> List Pipelines
                </a>
                <!--
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Lorem ipsum <span class="badge">14</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Lorem ipsumr <span class="badge">14</span>
                </a>
                -->
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> History
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
<!--            <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>-->

            <?php echo $this->renderLogs() ; ?>

            <div class="row clearfix no-margin">
                <h4 class="text-uppercase text-light">Built Search</h4>
                <h3>Search List </h3>
                <ul class="list-group">
                    <li class="list-group-item"><a href="">Built list 1</a></li>
                    <li class="list-group-item"><a href="">Built list 2</a></li>
                    <li class="list-group-item"><a href="">Built list 3</a></li>
                    <li class="list-group-item"><a href="">Built list 4</a></li>
                    <li class="list-group-item"><a href="">Built list 5</a></li>
                </ul>


            </div>

            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>
        </div>


    </div>

</div><!-- /.container -->


