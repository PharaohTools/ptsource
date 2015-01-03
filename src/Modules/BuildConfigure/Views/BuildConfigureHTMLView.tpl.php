<h1>
    <a href="/">
        Phrankinsense - Pharaoh Tools
    </a>
    <br/>
    -------------------
</h1>

<p>
    Build Configure:
</p>

<p>
---------------------------------------
</p>

<h5>
    <a href="/index.php?control=BuildHome&action=show&item=some_build_1">-Build Home for some_build 1-</a>
</h5>

<textarea cols="40" rows="10" class="styley">

</textarea>

<?php

foreach ($pageVars["build_steps"] as $build_step) {
  if ($build_step["hidden"] != true) {
    echo '<p>'.$moduleInfo["command"].' - '.$moduleInfo["name"]."</p>";
  }
}

?>
<h5>
    <a href="/index.php?control=BuildConfigure&action=save&item=some_build_1">-Save configuration of some_build 1-</a>
</h5>

<p>
---------------------------------------<br/>
phrankinsense
</p>