<h1>
    <a href="/">
        Phrankinsense - Pharaoh Tools
    </a>
    <br/>
    -------------------
</h1>

<p>

    The home page for a single build
</p>

<p>
-------------------------------------------------------------
</p>

<p>
    Build Status Currently:
    <br/>
    ---------------------------------------
</p>
<p>
    Build Plugins/features/monitors:
    <br/>
    ---------------------------------------
</p>
<p>
    Build Status:
    <br/>
    ---------------------------------------
</p>
<?php

foreach ($pageVars["build_history"] as $build_history) {
  if ($moduleInfo["hidden"] != true) {
    echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
  }
}

?>

<p>
---------------------------------------<br/>
phrankinsense
</p>