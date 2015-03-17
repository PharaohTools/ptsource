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
                        <i class="fa fa-sitemap fa-fw"></i> Configure PTBuild</a>
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
                            <table class="table table-hover table-custom" >
                                <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>User Group</th>
                                    <th>Action</th>
                                 </tr></thead>
				<tbody class="table-hover">
				<?php      
					$i = 1;   
					foreach ($pageVars["userdata"] as $userdetails) { ?>
                	    <tr class="default">
                	    <th scope="row"><?php echo $i ; ?></th>
	           	        <td><?php echo '<b>'.$userdetails->username.'</b>'; ?></td>
                	    <td><?php echo '<p style="">'.$userdetails->email.'</p>'; ?></td>
                        <td><?php 
							if($userdetails->role==1){
							echo '<b><p class="text-primary">Admin</p></b>'; }
							if($userdetails->role==2){
							echo '<b><p class="text-success">Builder</p></b>'; }
							if($userdetails->role==3){
							echo '<b><p class="text-warning">Viewer</p></b>'; } ?>
						</td>
						<td>
				<?php
                     if ($userdetails->role == 1) {
                           echo'<div class="btn-group">
                            <button type="button" class="btn btn-primary  btn-xs">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="#" class="text-info">Change role</a></li>
							<li class="divider"></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=2">Builder</a></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=3">Viewer</a></li>
							<li class="divider"></li>
							<li><a href="#" class="text-info">Remove user</a></li>
							</ul>
							</div>';}
                            if ($userdetails->role == 2) {
							 echo'<div class="btn-group">
                            <button type="button" class="btn btn-primary  btn-xs">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="#" class="text-info">Change role</a></li>
							<li class="divider"></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=1">Admin</a></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=3">Viewer</a></li>
							<li class="divider"></li>
							<li><a href="#" class="text-info">Remove user</a></li>
							</ul>
							</div>';}
		                    if ($userdetails->role == 3) {
                            echo'<div class="btn-group">
                           <button type="button" class="btn btn-primary  btn-xs">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li><a href="#" class="text-info">Change role</a></li>
							<li class="divider"></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=1">Admin</a></li>
							<li><a href="/index.php?control=UserManager&action=changerole&username='.$userdetails->username.'&email='.$userdetails->email.'&role=2">Builder</a></li>
							<li class="divider"></li>
							<li><a href="#" class="text-info">Remove user</a></li>
							</ul>
							</div>';} ?>
        		            </td> 
                            </tr>
							<?php 
                            $i++; }  
                            ?>
                         </tbody>
                     </div>
                  </div></table>
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
