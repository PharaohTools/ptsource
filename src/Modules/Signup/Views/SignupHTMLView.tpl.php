<div class="container">

        <?php if($pageVars["route"]["action"] == "login"){ ?>
            <div class="col-sm-8 col-md-9 clearfix main-container">
                <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
                <div class="row clearfix no-margin">
                    <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                        Login
                    </h5>
                    <form class="form-horizontal custom-form" action="/index.php?control=Signup&action=submit" method="post">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label text-left">User Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="username" placeholder="User Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword3" class="col-sm-2 control-label text-left">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-info">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
                <p>
                    ---------------------------------------<br/>
                    Visit www.pharaohtools.com for more
                </p>

            </div>
        <?php }?>




    </div>

</div><!-- /.container -->
