<?php

/* 
 * Get/Verify Catalog and Category names
 */

define ('TOP_DIR', '../'); //top directory for includes

//get names from file expected format:  catalog,category
$file = fopen(TOP_DIR.'include/catalog.csv', "r") or die("Unable to open catalog.csv!");
$names=fgetcsv($file);
fclose($file);

echo "<h3>Please Enter Catalog Name and Category Name</h3><hr><br>";
?>
<form id="sub_cat_form">
  Catalog:&nbsp;&nbsp;&nbsp;
  <input type="text" id="catalog" name="catalog" value="<?php echo $names[0];?>">
  <br><br>
  Category:&nbsp;&nbsp;
  <input type="text" id="category" name="category" value="<?php echo $names[1];?>">
  <br><br>
  <input type="checkbox" name="create_cat" id="create_cat" value="yes" checked> Create Catalog and Category<br>
  <br><br>
  <input type="submit" id="sub_cat" value="Export Products">
</form>

