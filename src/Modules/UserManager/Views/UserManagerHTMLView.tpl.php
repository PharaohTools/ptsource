<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav in" id="side-menu">
                <li class="sidebar-search">
                    <div class="input-group custom-search-form">
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
                    <a href="/index.php?control=Index&action=show">
                        <i class="fa fa-comment-o"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show">
                        <i class="fa fa-sitemap fa-fw"></i> Configure PTBuild<span class="fa arrow"></span>
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show">
                        <i class="fa fa-user"></i> User Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show">
                        <i class="fa fa-user"></i> Module Manager
                    </a>
                </li>
            </ul>
        </div>
    </div>

  <div class="col-md-9 col-sm-10" id="page-wrapper">
        <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>

        <div class="row clearfix no-margin">
            <h4 class="text-uppercase text-light">List of users</h4>
            <!--
            <h3>
                <a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">
                    Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
            </h3>
            -->
            <div role="tabpanel">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                    <li role="presentation"><a href="#success" aria-controls="success" role="tab" data-toggle="tab">Group 1</a></li>
                    <li role="presentation"><a href="#failed" aria-controls="failed" role="tab" data-toggle="tab">Group 2</a></li>
                    <li role="presentation"><a href="#unstable" aria-controls="unstable" role="tab" data-toggle="tab">Group 3</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="all">
                        <div class="table-responsive">
                            <table class="table table-bordered table-custom">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>UserName</th>
                                    <th>Email</th>
                                    <th>UserGroup</th>
                                    <!--
                                    <th>Parent</th>
                                    <th>Child</th>
                                    -->
								</tr> </thead><tbody class=
								"table-hover">
						<?php        
							$i = 1;   
								foreach ($pageVars["data"] as $userdetails) { ?>
                                    <tr>
                                        <th scope="row">
											<?php echo $i ; ?>
                                        </th>
                                       <td>
											<?php echo $userdetails->username; ?>
										</td>
                                        <td>
											<?php echo $userdetails->email; ?>
                                        </td>
                                        <td>
											<?php $i++; ?>
                                        </td>  
                                    </tr>
                                    <?php 
                                   }  
                                   ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       <p>
            ---------------------------------------<br/>
            Visit www.pharaohtools.com for more
        </p>
    </div>
</div><!-- container -->
<link rel="stylesheet" href="/index.php?control=AssetLoader&action=show&user=UserManager&type=css&asset=usermanager.css">
