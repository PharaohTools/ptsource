<div class="container" id="wrapper">
    <div class="col-lg-12">
        <div class="well well-lg">
            <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
                <div class="sidebar-nav ">
                    <div class="sidebar-search">
                        <button class="btn btn-success" id="menu_visibility_label" type="button">
                            Show Menu
                        </button>
                        <i class="fa fa-1x fa-toggle-off hvr-grow" id="menu_visibility_switch"></i>
                    </div>
                    <ul class="nav in" id="side-menu">
                        <li>
                            <a href="/index.php?control=Index&action=show" class="active hvr-bounce-in">
                                <i class="fa fa-dashboard fa-fw hvr-grow-shadow"></i> Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href=""> Pharaoh Source - Source Code Management
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