<div class="container" id="wrapper">
    <div id="page_sidebar" class="navbar-default col-sm-2 sidebar" role="navigation">
		<div class="sidebar-nav ">
			<ul class="nav in" id="side-menu">
				<li class="sidebar-search">
                    <button class="btn btn-info" id="hide_menu_button" type="button">
                        Hide Menu
                    </button>
                </li>
                <li>
                    <a href="/index.php?control=Index&action=show" class="hvr-bounce-in">
                        <i class="fa fa-dashboard hvr-bounce-in"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHome&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                        <i class="fa fa-home hvr-bounce-in"></i>  Repository Home
                    </a>
                </li>
                <li>
                    <a href="/index.php?control=RepositoryList&action=show"class="hvr-bounce-in">
                        <i class="fa fa-bars hvr-bounce-in"></i> All Repositories
                    </a>
                </li>
                
                
                <li>
                    <a href="index.php?control=FileBrowser&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-folder-open-o hvr-bounce-in"></i> File Browser
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                    </a>
                </li>
                <li>
                    <a href="index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                        <i class="fa fa-history hvr-bounce-in"></i> History <span class="badge"></span>
                    </a>
                </li>
            </ul>
        </div>

    </div>

    <div id="page_content" class="col-lg-9 well well-lg">

        <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

            <?php echo $this->renderLogs() ; ?>

            <div class="form-group col-sm-12 thin_padding">
                <div class="form-group col-lg-12 thin_padding">
                    <?php
                    switch ($pageVars["route"]["action"]) {
                        case "show" :
                            $stat = "Browsing Files From " ;
                            break ; }
                    ?>
                    <h3><?= $stat; ?> Repository <?php echo $pageVars["data"]["repository"]["project-name"] ; ?></h3>
                </div>

                <div class="form-group col-sm-12 thin_padding">
                    <div class="form-group col-lg-3 thin_padding" id="show_menu_wrapper">
                        <button class="btn btn-success" id="show_menu_button" type="button">
                            Show Menu
                        </button>
                    </div>
                    <div class="form-group col-lg-12 thin_padding" id="path_header">
                        <?php
                        $rootPath = str_replace($pageVars["data"]["relpath"], "", $pageVars["data"]["wsdir"]) ;
                        echo '<h3><a href="/index.php?control=FileBrowser&action=show&item='.
                            $pageVars["data"]["repository"]["project-slug"].'">'.$rootPath.'</a></h3>' ;

                        $act = '/index.php?control=FileBrowser&item='.$pageVars["data"]["repository"]["project-slug"].'&action=show' ;
                        ?>
                    </div>
                </div>

            </div>
            <div class="form-group col-sm-12 thin_padding">


                <?php
                if ($pageVars["route"]["action"]=="show") {
                    if ($pageVars["data"]["is_file"] == true) {
                    ?>

                    <div class="form-group col-sm-9">
                        <h4>File: <strong><?php echo $pageVars["data"]["relpath"] ; ?></strong></h4>
                    </div>
                    <div class="form-group col-sm-3">
                        <?php
                        if (isset($pageVars["data"]["current_branch"]) && $pageVars["data"]["current_branch"] != null) {
                            ?>
                            <h4>Branch : <strong><?php echo $pageVars["data"]["current_branch"] ; ?></strong></h4>
                        <?php
                        }
                        ?>
                    </div>

                    <?php
                    } else {
                        ?>

                        <div class="form-group col-sm-3 thin_padding">
                            <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                Select Branch
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" id="assigneelist" role="menu" aria-labelledby="dropdownMenu1">
                                <?php
                                foreach($pageVars["data"]["branches"] as $branch_name) {
                                    ?>
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="<?php echo $act ; ?>&identifier=<?php echo $branch_name ; ?>">
                                            <?= $branch_name ?>
                                        </a>
                                    </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <div class="form-group col-sm-9 thin_padding">
                            <?php
                            if (isset($pageVars["data"]["current_branch"]) && $pageVars["data"]["current_branch"] != null) {
                                ?>
                                <h4> Current Branch : <strong><?php echo $pageVars["data"]["current_branch"] ; ?></strong></h4>
                            <?php
                            }
                            ?>
                        </div>

                    <?php
                    }
                }
                ?>
            </div>

            <div class="form-group col-sm-12">
                <div id="editor_wrapper">
                     <?php
                    if ($pageVars["route"]["action"]=="show") {
                        if ($pageVars["data"]["is_file"] === true) {
                            echo '<div id="loader"><img alt="Loading" src="/Assets/Modules/FileBrowser/images/loading.gif" /></div>' ;
                            echo '<textarea id="editor">' ;
                            echo $pageVars["data"]["file"] ;
                            echo '</textarea>' ; }
                        else {
                            foreach ($pageVars["data"]["directory"] as $name => $isDir) {

                                $dirString = ($isDir) ? " - (D)" : "" ;
                                $trail = ($isDir) ? "/" : "" ;
                                echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].'&relpath='.$pageVars["data"]["relpath"].'">'.$pageVars["data"]["relpath"].'</a>' ;

                                $relativeString = str_replace($pageVars["data"]["wsdir"], "", $name) ;
                                $nameparts = explode(DS, $relativeString) ;

                                foreach ($nameparts as $namepart => $isSubDir) {
                                    echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].'&relpath='.$pageVars["data"]["relpath"].$name.
                                        $trail.'">'.$name.'</a>' ; }

                                echo $trail.$dirString.'<br />' ; } } }
                    ?>
                </div>
            </div>

            <div class="form-group col-sm-12">
                <hr />
                <p class="text-center">
                    Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
                </p>
            </div>

        </form>

    </div> <!-- /#page_content -->

</div>

<?php
if ($pageVars["route"]["action"]=="show") {
    if ($pageVars["data"]["is_file"] == true) {
        ?>
        <link rel="stylesheet" href="/Assets/Modules/FileBrowser/css/filebrowser.css">
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/lib/codemirror.js"></script>
        <link rel="stylesheet" href="/Assets/Modules/FileBrowser/js/CodeMirror/lib/codemirror.css">
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/htmlembedded/htmlembedded.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/javascript/javascript.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/xml/xml.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/css/css.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/clike/clike.js"></script>
        <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/php/php.js"></script>
        <?php if (isset($pageVars["data"]["file_extension"]) && $pageVars["data"]["file_extension"] != null) { ?>
                <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/<?php echo $pageVars["data"]["file_extension"] ; ?>/<?php echo $pageVars["data"]["file_extension"] ; ?>.js"></script>
            <?php
            }

            if (isset($pageVars["data"]["file_mode"]) && $pageVars["data"]["file_mode"] != null) {
                $jsmode = "mode: '{$pageVars["data"]["file_mode"]}'," ;
            }
//            if (isset($pageVars["data"]["file_mode"]) && $pageVars["data"]["file_mode"] != null) {
                $readonlystring = "readOnly: true," ;
//            }
        ?>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#loader').hide();
                $('#editor').show();
                var eob = document.getElementById("editor") ;
                var editor = CodeMirror.fromTextArea(eob, {
                    <?php echo $readonlystring."\n" ; ?>
                    <?php echo $jsmode."\n" ; ?>
                    lineNumbers: true
                });
                cm = document.getElementsByClassName("CodeMirror-code");
                cms = $('.CodeMirror') ;

                cml = $('.CodeMirror-line') ;
                console.log(cml.length, editor.lineCount()) ;
                lines = editor.lineCount();
                line_size = cml.first().css('height') ;
                line_size = parseInt(line_size, 10);
                sh = line_size * lines ;

                console.log("osh:", sh) ;
                if (sh > 4000) {
                    cms.css('height', '4000px') ;
                    console.log("set height:", '4000px') ; }
                else {
                    cms.css('height', sh+'px') ;
                    console.log("set height:", sh+'px') ; }
                console.log(cms.css('height'))
            });
        </script>

<?php
    }
}
?>