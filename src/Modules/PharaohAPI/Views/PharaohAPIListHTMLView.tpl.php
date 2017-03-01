<div class="container" id="wrapper">
    <div class="col-lg-9">
        <?php

            $mn = $this->getModuleName() ;
            if (isset($steps[$mn]["enabled"]) && $steps[$mn]["enabled"] == "on") {
                foreach ($pageVars["data"]["report_list"]["reports"] as $reportHash => $reportDetail) {

                    $dir = $reportDetail["Report_Directory"];
                    if (substr($dir, -1) != DS) { $dir = $dir . DS ; }
                    $indexFile = $reportDetail["Index_Page"];
                    $reportTitle = $reportDetail["Report_Title"];

                    echo '<a href="index.php?control=PharaohAPI&action=report&item=' ;
                    echo $pageVars["data"]["pipe"]["project-slug"].'">' ;
                    echo '  '.$reportTitle ;
                    echo '</a>' ;

                } }

        ?>
    </div>
    <hr>
    <p class="text-center">
        Visit <a href="http://www.pharaohtools.com">www.pharaohtools.com</a> for more
    </p>
</div>