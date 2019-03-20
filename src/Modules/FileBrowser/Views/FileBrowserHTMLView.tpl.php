<div class="container" id="wrapper">

    <div id="page_content" class="col-lg-12 well well-lg">
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

                    <?php
                    if (in_array($pageVars["data"]["repository"]["project-type"], 'raw')) {
                        ?>

                        <li>
                            <a href="/index.php?control=VersionQuery&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa fa-folder-open-o hvr-bounce-in"></i> Versions
                            </a>
                        </li>

                        <?php
                    }
                    ?>

                    <?php
                    if (in_array($pageVars["data"]["repository"]["project-type"], 'git')) {
                        ?>


                        <li>
                            <a href="/index.php?control=RepositoryCharts&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>" class="hvr-bounce-in">
                                <i class="fa fa-bar-chart-o hvr-bounce-in"></i> Charts
                            </a>
                        </li>
                        <li>
                            <a href="/index.php?control=RepositoryHistory&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                                <i class="fa fa-history fa-fw hvr-bounce-in"></i> History <span class="badge"></span>
                            </a>
                        </li>
                        <li>
                            <a href="/index.php?control=RepositoryPullRequests&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                                <i class="fa fa-code fa-fw hvr-bounce-in"></i> Pull Requests <span class="badge"></span>
                            </a>
                        </li>
                        <li>
                            <a href="/index.php?control=RepositoryReleases&action=show&item=<?php echo $pageVars["data"]["repository"]["project-slug"] ; ?>"class="hvr-bounce-in">
                                <i class="fa fa-code fa-fw hvr-bounce-in"></i> Releases <span class="badge"></span>
                            </a>
                        </li>

                        <?php
                    }
                    ?>

                </ul>
            </div>

        </div>

        <?php if (!isset($act)) $act = null ; ?>
        <form class="form-horizontal custom-form" action="<?= $act ; ?>" method="POST">

            <?php echo $this->renderLogs() ; ?>

            <div class="col-sm-12 thin_padding">
                <div class="col-lg-12 thin_padding">
                    <?php
                    switch ($pageVars["route"]["action"]) {
                        case "show" :
                            $stat = "Browsing Files From " ;
                            break ;
                    }
                    ?>
                    <h2><?= $stat; ?> Repository <?php echo $pageVars["data"]["repository"]["project-name"] ; ?></h2>
                </div>

            </div>
            <div class="col-sm-12 thin_padding">
                <?php

                if ($pageVars["data"]['repository']['project-type'] == 'git') {
                    if ($pageVars["route"]["action"]=="show") {
                        if ($pageVars["data"]["is_file"] == true) {
                            ?>

                            <?php

                                if (isset($pageVars["data"]["current_branch"]) && $pageVars["data"]["current_branch"] != null) {
                                    ?>
                                    <div class="col-sm-12">
                                        <h4>File: <strong><?php echo $pageVars["data"]["relpath"] ; ?></strong></h4>
                                    </div>
                                    <div class="col-sm-12">
                                        <h4>Branch : <strong><?php echo $pageVars["data"]["current_branch"] ; ?></strong></h4>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-sm-12">
                                        <h4>File: <strong><?php echo $pageVars["data"]["relpath"] ; ?></strong></h4>
                                    </div>
                                    <?php
                                }
                                ?>

                            <?php
                        } else {
                            ?>

                            <div class="col-sm-12">
                                <button class="button_std btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
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
                            <div class="col-sm-12">
                                <?php
                                if (isset($pageVars["data"]["identifier"]) && $pageVars["data"]["identifier"] != null) {
                                    ?>
                                    <h4> Current Branch : <strong><?php echo $pageVars["data"]["identifier"] ; ?></strong></h4>
                                    <?php
                                }
                                ?>
                            </div>

                            <?php
                        }
                    }
                }
                ?>
            </div>

            <div class="col-sm-12">
                <div id="editor_wrapper">
                     <?php


                    if ($pageVars["route"]["action"]=="show") {
                        if (isset($pageVars["data"]["code_file_extension"]) && $pageVars["data"]["code_file_extension"] != 'txt') {
                            echo '<div class="col-sm-12">' ;
                            echo '    <h3>Displaying Code as <strong>'.$pageVars["data"]["code_file_extension"].'</strong>: </h3>' ;
                            echo '    <div id="loader"><img alt="Loading" src="/Assets/Modules/FileBrowser/images/loading.gif" /></div>' ;
                            echo '<textarea id="editor">' ;
                            echo $pageVars["data"]["code_file"] ;
                            echo '</textarea>' ;
                            echo '</div>' ;
                        } else if (isset($pageVars["data"]["image_file_extension"]) && $pageVars["data"]["image_file_extension"] != null) {
                                $base64 = base64_encode($pageVars["data"]['image_file']);
                                $image_file_data =  'data:' . $pageVars["data"]["image_file_mime"] . ';base64,' . $base64 ;
                                ?>
                                <div class="col-sm-12">
                                    <h3>Displaying File as Image: </h3><img class="file_browser_image" src="<?php echo $image_file_data; ?>" alt="Image File" />
                                </div>
                            <?php
                        } else if (strlen($pageVars["data"]["raw_file"]) > 0) {
                            echo '<div class="col-sm-12">' ;
                            echo '    <h3>Displaying File as <strong>Plain Text</strong>: </h3>' ;
                            echo '    <div id="loader"><img alt="Loading" src="/Assets/Modules/FileBrowser/images/loading.gif" /></div>' ;
                            echo '<textarea id="editor">' ;
                            echo $pageVars["data"]["raw_file"] ;
                            echo '</textarea>' ;
                            echo '</div>' ;
                        }
                        showTheFileBrowserDialogue($pageVars) ;
                    }

                    ?>

                </div>

            </div>

        </form>

    </div> <!-- /#page_content -->

</div>

<link rel="stylesheet" href="/Assets/Modules/FileBrowser/css/filebrowser.css" />


<?php
if ($pageVars["route"]["action"]=="show") {
    if ($pageVars["data"]["is_file"] == true) {
        ?>


        <?php if (isset($pageVars["data"]["code_file_extension"]) && $pageVars["data"]["code_file_extension"] != null) { ?>
            <link rel="stylesheet" href="/Assets/Modules/FileBrowser/js/CodeMirror/lib/codemirror.css" />
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/lib/codemirror.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/htmlmixed/htmlmixed.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/htmlembedded/htmlembedded.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/javascript/javascript.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/xml/xml.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/css/css.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/clike/clike.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/php/php.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/addon/display/autorefresh.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/addon/display/fullscreen.js"></script>
            <link rel="stylesheet" href="/Assets/Modules/FileBrowser/js/CodeMirror/addon/display/fullscreen.css" />
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/php/php.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/php/php.js"></script>
            <script src="/Assets/Modules/FileBrowser/js/CodeMirror/mode/<?php echo $pageVars["data"]["code_file_extension"] ; ?>/<?php echo $pageVars["data"]["code_file_extension"] ; ?>.js"></script>
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
                    lineNumbers: true,
                    autoRefresh:true,
                    extraKeys: {
                    "F11": function(cm) {
                        cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                    },
                    "Esc": function(cm) {
                        if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                    }
                }
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

function showTheFileBrowserDialogue($pageVars) {

    if (isset($pageVars['data']['identifier'])) {
        $idstring = '&identifier='.$pageVars['data']['identifier'] ;
    } else {
        $idstring = '' ;
    }

    $rootPath = str_replace($pageVars["data"]["relpath"], "", $pageVars["data"]["wsdir"]) ;
    $html = '
                                        <div id="config_panels" class="fullRow">
                                            <div class="fullRow">
                                                <h3>Browse</h3>
                                            </div>
                                            <div class="fullRow">
                                                <div id="common_panel" class="directory_choice_panel common_panel">
                                                ' ;
    echo $html ;

    $rootPath = str_replace($pageVars["data"]["relpath"], "", $pageVars["data"]["wsdir"]) ;
    $rootBase = basename($rootPath) ;
    $rootRel = dirname($pageVars["data"]["relpath"]) ;
    $rootRelParts = explode('/', $pageVars["data"]["relpath"]) ;
    $rootFull = $rootBase.DS.$rootRel ;
    $href_parent = '/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].$idstring ;
    $href = $href_parent . '&relpath='.$rootRel ;
    echo '<a href="'.$href_parent.'">'.$rootBase.'</a> / ' ;
    $total_parts = count($rootRelParts) ;
    $rels = '';
    for ($i = 0; $i < $total_parts ; $i++) {
        $rels = $rels . $rootRelParts[$i].'/' ;
        $href = $href_parent . '&relpath='.$rels ;
        echo '<a href="'.$href.'">'.$rootRelParts[$i].'</a>' ;
        if ($i < ($total_parts-1)) {
            echo ' / ' ;
        }
    }

    $html = '   </div>
          <div id="directory_panel" class="directory_choice_panel directory_panel">' ;

    echo $html ;

    if ($pageVars["data"]['repository']['project-type'] == 'raw') {
//var_dump($pageVars["data"]["directory"]) ;
        foreach ($pageVars["data"]["directory"] as $name => $isDir) {

            $mod_time = isset($isDir['mtime']) ? date('d/m/Y H:i:s', $isDir['mtime']) : "N/A" ;
            $access_time = isset($isDir['atime']) ? date('d/m/Y H:i:s', $isDir['atime']) : "N/A" ;
            $dirString = (is_array($isDir)) ? "&nbsp;&nbsp; - &nbsp;&nbsp;<i class='fa fa-folder-open-o hvr-grow-shadow'></i> Modified: {$mod_time}, Accessed: {$access_time}" : "&nbsp;&nbsp; - &nbsp;&nbsp;<i class=\"fa fa-file hvr-grow-shadow\"></i> Modified: {$mod_time}, Accessed: {$access_time}" ;
            $trail = ($isDir) ? "/" : "" ;
//            echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].$idstring.'&relpath='.$pageVars["data"]["relpath"].'">'.$pageVars["data"]["relpath"].'</a>' ;

            $relativeString = str_replace($pageVars["data"]["wsdir"], "", $name) ;
            $nameparts = explode(DS, $relativeString) ;

            echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].$idstring.'&relpath='.$pageVars["data"]["relpath"].$relativeString.
                $trail.'">'.$relativeString.'</a>' ;

            echo $trail.$dirString.'<br />' ; }

    } else {

        foreach ($pageVars["data"]["directory"] as $name => $isDir) {

            $dirString = ($isDir) ? '&nbsp;&nbsp; - &nbsp;&nbsp;<i class="fa fa-folder-open-o hvr-grow-shadow"></i>' : '&nbsp;&nbsp; - &nbsp;&nbsp;<i class="fa fa-file hvr-grow-shadow"></i>' ;
            $trail = ($isDir) ? "/" : "" ;
//            echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].$idstring.'&relpath='.$pageVars["data"]["relpath"].'">'.$pageVars["data"]["relpath"].'</a>' ;

            $relativeString = str_replace($pageVars["data"]["wsdir"], "", $name) ;
            $nameparts = explode(DS, $relativeString) ;

            foreach ($nameparts as $namepart => $isSubDir) {
                echo '<a href="/index.php?control=FileBrowser&action=show&item='.$pageVars["data"]["repository"]["project-slug"].$idstring.'&relpath='.$pageVars["data"]["relpath"].$name.
                    $trail.'">'.$name.'</a>' ; }

            echo $trail.$dirString.'<br />' ; }


    }


    $html = '    
   
                </div>
            </div>
        </div> ' ;

    echo $html ;

}

?>