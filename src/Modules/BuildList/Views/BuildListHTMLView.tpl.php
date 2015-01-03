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