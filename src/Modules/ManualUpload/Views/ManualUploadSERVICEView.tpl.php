<?php

if ($pageVars["route"]["action"]=="filedelete") {
?>
  <?php echo json_encode($pageVars["data"] ); ?>

<?php

} else {
?>

 <pre>
  <?php var_dump($pageVars["data"] ); ?>
</pre>

<?php

}