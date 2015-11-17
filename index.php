<?php
//include_once ("view/Export_main.php")
?>
<!doctype html>
<html lang="en">
    <head>
      <meta charset="utf-8">
      <title>Stockwell Scientific</title>
      <?php include_once ("include/top.php");?>



    </head>
    <body>
        <div id="header">
            Export To OFBIZ
        </div>
        <div id="loading_msg" class="noshow">Processing..... </div>
        <div id="current_status" class="noshow"></div>

        <div id="content">   
            <div class="center">

                <p>Please select one of the following functions:</p>

                <button id="exp_customer" class="basic_button">Export Customers</button> &nbsp;&nbsp;&nbsp;
                <button id="exp_product" class="basic_button">Export Products</button>
                <!--
                <a class="basic_button" href="view/Export_Customer.php">Export Customer</a>&nbsp;&nbsp;
                <a class="basic_button" href="view/Export_Products.php">Export Products</a>-->


            </div>
            
            <?php /*date_default_timezone_set("America/Phoenix");   
            $datestr=date("Y-m-d")." ".date("H:i:s").".000";
                    echo $datestr."<br>";
                    $datestr1=date("Y-m-d")." ".date("G:i:s").".000";
                    echo $datestr1."<br>";
                    $datestr2=date("Y-m-d")." ".date("h:i:s").".000";
                    echo $datestr2."<br>";*/
                    ?>
            <div id="return_msg"></div>
        </div>
       
        <?php include_once ("include/footer.php");?>
    </body>
</html>

