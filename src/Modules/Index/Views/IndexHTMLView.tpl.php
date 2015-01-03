<h1>
    <a href="/">
        Phrankinsense - Pharaoh Tools
    </a> <br/>
    -------------------
</h1>

<p>

    Build and Monitoring Server  in PHP.
    <br/>
    Can be used to set up monitoring of any application feature in minutes.
    <br/>
    Create simple or complex build pipelines fully integrated with pharaoh tools
                          <br/>
    Using Convention over Configuration, a lot of common build tasks can be completed with little or
    no extra implementation work.
</p>

<p>
-------------------------------------------------------------
</p>

<h1>
    <a href="/index.php?control=BuildList&action=show">-Build List, Build List, Build List, Build List-</a>
</h1>

<p>
    Available Commands:
</p>

<p>
---------------------------------------
</p>
<?php

foreach ($pageVars["modulesInfo"] as $moduleInfo) {
  if ($moduleInfo["hidden"] != true) {
    echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
  }
}

?>

<p>
    ---------------------------------------<br/>
    Visit www.pharaohtools.com for more
</p>