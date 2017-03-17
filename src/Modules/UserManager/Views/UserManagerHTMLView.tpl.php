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
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ApplicationConfigure&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-cogs fa-fw hvr-bounce-in"></i> Configure PT<?php echo ucfirst(PHARAOH_APP)  ; ?></a>
                </li>
                <li>
                    <a href="/index.php?control=UserManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-group hvr-bounce-in"></i> User Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=ModuleManager&action=show" class=" hvr-bounce-in">
                        <i class="fa fa-suitcase hvr-bounce-in"></i> Module Manager
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=Integrations&action=show" class=" hvr-curl-bottom-right">Integrations</a>
                </li>
            </ul>
        </div>
    </div>

  <div class="col-lg-9">
                    <div class="well well-lg">
<!--        <h2 class="text-uppercase text-light"><a href="/"> PT<?php echo ucfirst(PHARAOH_APP)  ; ?> - Pharaoh Tools</a></h2>-->

                        <?php echo $this->renderLogs() ; ?>

                        <div class="row clearfix no-margin">
           <h4 class="text-uppercase text-primary"><i class="fa fa-users hvr-grow-rotate"></i>  Users</h4>
            <!--
            <h3>
                <a class="lg-anchor text-light" href="/index.php?control=<?php echo ucfirst(PHARAOH_APP)  ; ?>List&action=show">
                    <?php echo ucfirst(PHARAOH_APP)  ; ?> List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
            </h3>
            -->
            <div role="tabpanel">

                <!-- Nav tabs
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#all" aria-controls="all" role="tab" data-toggle="tab">All</a></li>
                    <li role="presentation"><a href="#success" aria-controls="success" role="tab" data-toggle="tab">Group 1</a></li>
                    <li role="presentation"><a href="#failed" aria-controls="failed" role="tab" data-toggle="tab">Group 2</a></li>
                    <li role="presentation"><a href="#unstable" aria-controls="unstable" role="tab" data-toggle="tab">Group 3</a></li>
                </ul>
				-->
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="all">
                        <div class="table">
                            <table class="table table-hover table-custom" >
                                <thead>
                                <tr class="active">
                                    <th>#</th>
                                    <th>User Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                 </tr></thead>
				<tbody class="table-hover">
				<?php      
					$i = 1;   
					foreach ($pageVars["userdata"] as $userdetails) { ?>
                	    <tr class="default">
                	    <th scope="row"><?php echo $i ; ?></th>
	           	        <td><?php echo '<b>'.$userdetails['username'].'</b>'; ?></td>
                	    <td><?php echo '<p style="">'.$userdetails['email'].'</p>'; ?></td>
                        <td><?php 
							if($userdetails['role']==1){
							echo '<b><p class="text-primary">Admin</p></b>'; }
							if($userdetails['role']==2){
							echo '<b><p class="text-success"><?php echo ucfirst(PHARAOH_APP)  ; ?>er</p></b>'; }
							if($userdetails['role']==3){
							echo '<b><p class="text-warning">Viewer</p></b>'; } ?>
						</td>
						<td>
				<?php
                     if ($userdetails['role'] == 1) { ?>
                           <div class="btn-group">
                            <button type="button" class="btn btn-primary  btn-xs ">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle hvr-grow" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li class="divider"></li><li><a class="bg-info">Change role</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=2' ?>" class="hvr-grow-shadow"><?php echo ucfirst(PHARAOH_APP)  ; ?>er</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=3' ?>"class="hvr-grow-shadow">Viewer</a></li>
							<li class="divider"></li><li><a class="bg-info">User option</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=removeuser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Restrict user</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=adduser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Allow user</a></li>
							</ul>
							</div><?php }
                     if ($userdetails['role'] == 2) { ?>
							 <div class="btn-group">
                            <button type="button" class="btn btn-primary  btn-xs">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle hvr-grow" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li class="divider"></li><li><a class="bg-info">Change role</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=1' ?>" class="hvr-grow-shadow">Admin</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=3' ?>" class="hvr-grow-shadow">Viewer</a></li>
							<li class="divider"></li><li><a class="bg-info">User option</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=removeuser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Restrict user</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=adduser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Allow user</a></li>
							</ul>
							</div><?php }
                     if ($userdetails['role'] == 3) { ?>
                           <div class="btn-group">
                           <button type="button" class="btn btn-primary  btn-xs">Options</button>
							<button type="button" class="btn btn-default  btn-xs dropdown-toggle hvr-grow" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><span class="sr-only">Toggle Dropdown</span></button>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<li class="divider"></li><li><a class="bg-info">Change role</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=1' ?>" class="hvr-grow-shadow">Admin</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=changerole&username='.$userdetails['username'].'&email='.$userdetails['email'].'&role=2' ?>" class="hvr-grow-shadow"><?php echo ucfirst(PHARAOH_APP)  ; ?>er</a></li>
							<li class="divider"></li><li><a class="bg-info">User option</a></li><li class="divider"></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=removeuser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Restrict user</a></li>
							<li><a href="<?php echo'/index.php?control=UserManager&action=adduser&username='.$userdetails['username'].'&email='.$userdetails['email'].'' ?>" class="text-info hvr-grow-shadow">Allow user</a></li>
							</ul>
							</div><?php } ?>
        		            </td>
        		            <td>
                    <?php if($userdetails['restrict'] == 0) {
                        echo '<b><p class="text-success">Active</p></b>'; }
                        else{
                        echo '<b><p class="text-danger">Restricted</p></b>';}
                        ?>
        		            </td> 
                            </tr>
							<?php 
                            $i++; }  
                            ?>
                         </tbody></table>
                     </div>
                  </div>
               </div>
			</div> 
		  </div> 
     
        <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
    </div>
</div><!-- container -->
<link rel="stylesheet" href="/Assets/Modules/UserManager/css/usermanager.css">

