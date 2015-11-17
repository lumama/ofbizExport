<?php

/* 
 * Get Products Export File
 * 
 * created by Yvonne Lu 10-12-15
 */


define ('TOP_DIR', '../'); //top directory for includes
require_once TOP_DIR.'include/globaldef.php';
require_once TOP_DIR.'model/ExpModel.php';

//generates XML as follows:
//<ProdCatalog 
//prodCatalogId="10000" 
//catalogName="Stockwell" 
//useQuickAdd="Y" viewAllowPermReqd="N" 
//purchaseAllowPermReqd="N" lastUpdatedStamp="2015-11-11 15:44:54.378" 
//lastUpdatedTxStamp="2015-11-11 15:44:54.225" 
//createdStamp="2015-11-11 15:44:54.378" createdTxStamp="2015-11-11 15:44:54.225"/>
//
class catalog {
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
        
    }
    
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
     public function updateInfo($catalog_name, $category_name){
       $this->fields["prodCatalogId"]= $category_name;
       $this->fields["catalogName"]=$catalog_name;
       $this->fields["useQuickAdd"]="Y";
       $this->fields["viewAllowPermReqd"]="N";
       $this->fields["purchaseAllowPermReqd"]="N";
       date_default_timezone_set("America/Phoenix"); 
       $datestr=date("Y-m-d")." ".date("H:i:s").".000";
       $this->fields["lastUpdatedStamp"]=$datestr;
       $this->fields["lastUpdatedTxStamp"]=$datestr;
       $this->fields["createdStamp"]=$datestr;
       $this->fields["createdTxStamp"]=$datestr;
    }
    public function write(){
       
        
        fwrite($this->fh, "<ProdCatalog ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
    public function get_date() {
        if (array_key_exists("createdDate",$this->fields)){
            return $this->fields["createdDate"];
        }else {
            return "";
        }
    }
    
    public function get_id() {
         if (array_key_exists("prodCatalogId",$this->fields)){
            return $this->fields["prodCatalogId"];
        }else {
            return "";
        }
    }   
    
}
/*<ProductCategory productCategoryId="StockwellCatalog" 
 * productCategoryTypeId="CATALOG_CATEGORY" categoryName="Stockwell Products" 
 * lastUpdatedStamp="2015-11-11 16:01:42.989" lastUpdatedTxStamp="2015-11-11 16:01:42.867" 
 * createdStamp="2015-11-11 16:01:42.989" createdTxStamp="2015-11-11 16:01:42.867"/>
 */
class productCategory {
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
        
    }
    
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
     public function updateInfo($pcatid){
       $this->fields["productCategoryId"]= $pcatid;
       $this->fields["productCategoryTypeId"]="CATALOG_CATEGORY";
       $this->fields["categoryName"]="Stockwell Products";
       
       date_default_timezone_set("America/Phoenix"); 
       $datestr=date("Y-m-d")." ".date("H:i:s").".000";
       $this->fields["lastUpdatedStamp"]=$datestr;
       $this->fields["lastUpdatedTxStamp"]=$datestr;
       $this->fields["createdStamp"]=$datestr;
       $this->fields["createdTxStamp"]=$datestr;
    }
    public function write(){
       
        
        fwrite($this->fh, "<ProductCategory ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
}
/*
 * <ProductCategoryMember productCategoryId="10000" productId="000-ORING" 
 * fromDate="2015-11-12 00:00:00.0" lastUpdatedStamp="2015-11-12 13:37:50.421" 
 * lastUpdatedTxStamp="2015-11-12 13:37:50.385" createdStamp="2015-11-12 13:37:50.421" 
 * createdTxStamp="2015-11-12 13:37:50.385"/>
 */
class productCategoryMember{
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
        
    }
    
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
     public function updateInfo($pcatid, $pid){
       $this->fields["productCategoryId"]= $pcatid;
       $this->fields["productId"]=$pid;
      
       
       
       
       date_default_timezone_set("America/Phoenix"); 
       $datestr=date("Y-m-d")." ".date("H:i:s").".000";
       $this->fields["fromDate"]=$datestr;
       $this->fields["lastUpdatedStamp"]=$datestr;
       $this->fields["lastUpdatedTxStamp"]=$datestr;
       $this->fields["createdStamp"]=$datestr;
       $this->fields["createdTxStamp"]=$datestr;
    }
    public function write(){
       
        
        fwrite($this->fh, "<ProductCategoryMember ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
    public function get_date() {
        if (array_key_exists("createdDate",$this->fields)){
            return $this->fields["createdDate"];
        }else {
            return "";
        }
    }
    
}

/*
 * <Product productId="000M000" productTypeId="FINISHED_GOOD" 
 * internalName="Q-TIPS, WOOD SHAFT, 6 INCH, 10000" isVirtual="N" 
 * isVariant="N" billOfMaterialLevel="0" createdDate="2015-11-12 13:39:16.825" 
 * createdByUserLogin="yvonne123" lastModifiedDate="2015-11-12 13:39:16.825" 
 * lastModifiedByUserLogin="yvonne123" inShippingBox="N" lotIdFilledIn="Allowed"
 * lastUpdatedStamp="2015-11-12 13:39:16.825" 
 * lastUpdatedTxStamp="2015-11-12 13:39:16.794" 
 * createdStamp="2015-11-12 13:39:16.825" createdTxStamp="2015-11-12 13:39:16.794"/>
 */
class product {
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
        
    }
    
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
     public function updateInfo($pid, $name){
       $this->fields["productId"]= $pid;
       $this->fields["productTypeId"]="FINISHED_GOOD";
       $this->fields["internalName"]=$name;
       $this->fields["isVirtual"]="N";
       $this->fields["isVariant"]="N";
       $this->fields["billOfMaterialLevel"]=0;
       
       
       date_default_timezone_set("America/Phoenix"); 
       $datestr=date("Y-m-d")." ".date("H:i:s").".000";
       $this->fields["createdDate"]=$datestr;
       $this->fields["lastModifiedByUserLogin"]="yvonne123";
       $this->fields["inShippingBox"]="N";
       $this->fields["lotIdFilledIn"]="Allowed";
       
       $this->fields["lastUpdatedStamp"]=$datestr;
       $this->fields["lastUpdatedTxStamp"]=$datestr;
       $this->fields["createdStamp"]=$datestr;
       $this->fields["createdTxStamp"]=$datestr;
    }
    public function write(){
       
        
        fwrite($this->fh, "<Product ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
    public function get_date() {
        if (array_key_exists("createdDate",$this->fields)){
            return $this->fields["createdDate"];
        }else {
            return "";
        }
    }
    
    public function get_id() {
         if (array_key_exists("productId",$this->fields)){
            return $this->fields["productId"];
        }else {
            return "";
        }
    }   
    
}

/* 
 * Get Products Export File
 * 
 * created by Yvonne Lu 11-13-15
 * 
 */



$db = new EXPmodel($names['dsn']);


echo "GetProducts.php called ";


$catalog=$category="";
$create_cat=false;

//get catalog and category names
if (isset($_GET['catalog'])) {
    $catalog = trim($_GET['catalog']);
}
if (isset($_GET['category'])) {
    $category = trim($_GET['category']);
}

if (isset($_GET['create_cat'])) {
    $tmp = trim($_GET['create_cat']);
    if (strcmp($tmp, "true")===0){
        $create_cat=true;
    }
}

//this shouldn't happen because javascript checks for it
if ((strlen($catalog)===0)||(strlen($category)===0)){
    echo "Invalid Inputs<br>";
    return;
}


$arr_prod = $db->exportProducts($count);

if ($count>0){
    
    echo "Generating ".$count." records<br>";
    
    //erase previous export
    if (file_exists ($names['prod_xml'])){
        unlink($names['prod_xml']);
    }
    $fh = fopen ($names['prod_xml'], "a");
    fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL);
    fwrite($fh, '<entity-engine-xml>'.PHP_EOL);
    
    
    //create catalog
    if ($create_cat){
        //catalog
        $cat = new catalog($names['prod_xml']);
        $cat->updateInfo($catalog, $category);
        $cat->write();
        $pcat = new productCategory($names['prod_xml']);
        $pcat->updateInfo($category);
        $pcat->write();
        
    }
    
    $prod=new product($names['prod_xml']);
    $pcm = new productCategoryMember($names['prod_xml']);
    
    foreach ($arr_prod as $k => $v) {
        $pid    = $v[1];
        $pname  = $v[2];
        
        $prod->updateInfo($pid, $pname);
        $prod->write();
        $pcm->updateInfo($category, $pid);
        $pcm->write();
        
        
    }
    //print_r($arr_prod);
    
    fwrite($fh, '</entity-engine-xml>'.PHP_EOL);
    fclose($fh);
}







