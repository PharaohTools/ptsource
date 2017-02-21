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
                    <a href="/index.php?control=Index&action=show" class="active hvr-bounce-in"><i class="fa fa-dashboard fa-fw hvr-grow-shadow"></i> Dashboard</a>
                </li>
            </ul>
        </div>
    </div>

    <div class="col-lg-9">
                    <div class="well well-lg">
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href=""> PTSource - Holding Your Code, Pharaoh Tools
                        <i style="font-size: 18px;" class="fa fa-chevron-right"></i>
                    </a></h3>

                <?php echo $this->renderLogs() ; ?>

                <p> Pharaoh Tools: Source </p>
                <p> Part of the Pharaoh Tools Package </p>
                <p>
                    Source Control Management Server in PHP.
                    <br/>
                    Manage Repositories, Data, Teams
                    <br/>
                    Full feature set, Easily extensible with downloadable modules.
                    <br/>
                </p>
            </div>
            <div class="row clearfix no-margin">
                <hr />
                <p class="text-center">
                                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more

            </p>
            </div>

        </div>

    </div>
</div>