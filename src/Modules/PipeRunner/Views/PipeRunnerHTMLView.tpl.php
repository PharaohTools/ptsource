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
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-search"></i> Pipeline Home
                </a>
                <a href="/index.php?control=BuildList&action=show" class="list-group-item">
                    <i class="fa fa-user"></i> All Pipelines
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-folder-open-o"></i> Workspace
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> Monitors <span class="badge">6</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-bar-chart-o"></i> History <span class="badge">3</span>
                </a>
                <a href="#" class="list-group-item">
                    <i class="fa fa-envelope"></i> Run Now
                </a>
            </div>
        </div>

        <div class="col-sm-8 col-md-9 clearfix main-container">
            <h2 class="text-uppercase text-light"><a href="/"> Phrankinsense - Pharaoh Tools </a></h2>
            <div class="row clearfix no-margin">
                <h3><a class="lg-anchor text-light" href="#">Executing Pipeline <?php echo $pageVars["data"]["pipeline"]["project_title"]["value"] ; ?> <i style="font-size: 18px;" class="fa fa-chevron-right"></i></a></h3>
                <h5 class="text-uppercase text-light" style="margin-top: 15px;">
                    <a href="/index.php?control=BuildHome&action=show&item=<?php echo $pageVars["data"]["pipeline"]["project_slug"]["value"] ; ?>"></a>
                </h5>
                <form class="form-horizontal custom-form">

                    <div class="form-group">
                        <div class="col-sm-10">
                            <div id="updatable">
                                Starting Pipeline Execution...
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                        console.log("one") ;
                        done = false ;
                        max = 0 ;
                        while (done == false && max < 30) {
                            window.setTimeout(updatePage, 3000) //wait 3 seconds before continuing
                            max = max + 1 ; }

                        function updatePage()
                        {
                            item = $("#item").val();
                            url = "/index.php?control=PipeRunner&action=service&item=" + item ;
                            $.ajax({
                                url: url,
                                success: function(data) {
                                    $('#updatable').html(data); },
                                complete: function() {
                                    // Schedule the next request when the current one's complete
                                    setTimeout(updatePage, 5000); }
                            });}
                    </script>

                    <?php
                        foreach ($pageVars["data"]["pipeline"]["steps"] as $one_build_step) {
                            echo '<div class="form-group">' ;
                            echo '  <label for="inputPassword3" class="col-sm-2 control-label text-left">'.$one_build_step["title"].'</label>' ;
                            echo '  <div class="col-sm-10">' ;
                            echo '      <p>'.$one_build_step["title"].'</p>';
                            echo '      <p>Step Type: '.$one_build_step["type"]."</p>";
                            echo '      <textarea class="form-control">'.$one_build_step["value"].'</textarea>';
                            echo '  </div>';
                            echo '</div>'; }
                    ?>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger" id="end-now">End Now</button>
                            </div>
                        </div>
                        <div class="col-sm-offset-2 col-sm-8">
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" id="close-complete">Close Execution Screen</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <p>
                ---------------------------------------<br/>
                Visit www.pharaohtools.com for more
            </p>

        </div>

    </div>
</div><!-- /.container -->