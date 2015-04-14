<div class="container" id="wrapper">
    <div class="navbar-default col-sm-2 sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
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
                        <i class="fa fa-cogs fa-fw hvr-bounce-in"></i> Configure PTBuild</a>
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
            </ul>
        </div>
    </div>

  <div class="col-lg-9">
     <div class="well well-lg">
        <h2 class="text-uppercase text-light"><a href="/"> PTBuild - Pharaoh Tools</a></h2>
        <hr>
        <div class="row clearfix no-margin">
       
            <!--
            <h3>
                <a class="lg-anchor text-light" href="/index.php?control=BuildList&action=show">
                    Build List <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a>
            </h3>
            -->
               
            <h2 class="text-info">User Profile</h2>
              <div class="col-md-12 alert alert-info">  
                <div class="col-md-4">
                    <label>Name :<strong class="text-success"> 
                    <?php foreach ($pageVars as $key => $data) { echo "$data->username"; } ?>
 					</strong></label>
                    <label>Email :<strong class="text-success">
                    <label><?php foreach ($pageVars as $key => $data) { echo "$data->email"; } ?>
 					</strong></label>
             		<label>Role :<strong class="text-success">
                    <label><?php foreach ($pageVars as $key => $data) { echo "$data->role";	} ?></strong></label>
                    <br/>
              <!--      <a href="#" class="btn btn-success">Update Details</a> -->
                    <br /><br/>
                
                   																																																			
                     <div class="col-md-12">
                        <a href="#" class="btn btn-social btn-facebook">
                            <i class="fa fa-facebook"></i>&nbsp; Facebook</a>
                        <a href="#" class="btn btn-social btn-google">
                            <i class="fa fa-google-plus"></i>&nbsp; Google</a>
                        <a href="#" class="btn btn-social btn-twitter">
                            <i class="fa fa-twitter"></i>&nbsp; Twitter </a>
                        <a href="#" class="btn btn-social btn-linkedin">
                            <i class="fa fa-linkedin"></i>&nbsp; Linkedin </a>  
             	</div> 
              </div></div></div></div>        
        <hr>
                <p class="text-center">
                Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
            </p>
    </div>
</div><!-- container -->
<link rel="stylesheet" href="/index.php?control=AssetLoader&action=show&module=UserManager&type=css&asset=usermanager.css">

