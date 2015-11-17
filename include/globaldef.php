<?php

/* 
 * global definiation file
 */

define ('RUN_STATUS', 'TEST');

if (strcmp(RUN_STATUS, 'TEST')==0){
    //under development globals
    include_once("test_names.php");
}else {
    //running on server
    include_once("server_names.php");
}

