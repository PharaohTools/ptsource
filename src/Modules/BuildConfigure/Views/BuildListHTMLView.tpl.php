<h1>
    <a href="/">
        Phrankinsense - Pharaoh Tools
    </a>
    <br/>
    -------------------
</h1>

<p>

    A list of builds in a page
</p>

<p>
-------------------------------------------------------------
</p>

<p>
    Build Lists:
</p>

<p>
---------------------------------------
</p>

<h5>
    <a href="/index.php?control=BuildHome&action=show&item=some_build_1">-Build Home for some_build 1-</a>
</h5>
<h5>
    <a href="/index.php?control=BuildHome&action=show&item=some_build_2">-Build Home for some_build 2-</a>
</h5>
<h5>
    <a href="/index.php?control=BuildHome&action=show&item=some_build_3">-Build Home for some_build 3-</a>
</h5>
<?php

foreach ($pageVars["build"] as $build) {
  if ($moduleInfo["hidden"] != true) {
    echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
  }
}

?>

<p>
---------------------------------------<br/>
phrankinsense
</p>