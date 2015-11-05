<?php define ('TOP_DIR', '../'); //top directory for includes
require_once TOP_DIR.'include/globaldef.php';
require_once TOP_DIR.'model/ExpModel.php';

/* class for exporting to Party entity
 * <entity entity-name="Party">
      <field name="partyId"></field>
      <field name="partyTypeId"></field>
      <field name="preferredCurrencyUomId"></field> <!--USD-->
      <field name="statusId"></field> <!--PARTY_ENABLED-->
      <field name="createdDate"></field>
      <field name="createdByUserLogin"></field> <!--admin-->
      <field name="lastModifiedDate"></field>
      <field name="lastModifiedByUserLogin" type="id-vlong"></field>
 </entity>
 */
class Party {
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
    public function updateInfo($partyId){
       $this->fields["partyId"]=$partyId;
       $this->fields["partyTypeId"]= "PARTY_GROUP";
       $this->fields["preferredCurrencyUomId"]="USD";
       $this->fields["statusId"]="PARTY_ENABLED";
       date_default_timezone_set("America/Phoenix"); 
       $datestr=date("Y-m-d")." ".date("H:i:s").".000";
       $this->fields["createdDate"]=$datestr;
       $this->fields["createdByUserLogin"]="yvonne123";
       $this->fields["lastModifiedDate"]=$datestr;
       $this->fields["lastModifiedByUserLogin"]="yvonne123";
    }
    public function write_party(){
        // echo "in write_party now<br>";
        
        fwrite($this->fh, "<Party ");
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
         if (array_key_exists("partyId",$this->fields)){
            return $this->fields["partyId"];
        }else {
            return "";
        }
    }    
        
    
    
}
/*
<entity entity-name="PartyGroup">
      <field name="partyId" type="id-ne"></field>
      <field name="groupName" type="name"></field>
      <field name="groupNameLocal" type="name"></field>
      <field name="comments" type="comment"></field>
 </entity>*/
class PartyGroup {
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
    }
    function updateInfo ($partyId, $groupName){
        $this->fields["partyId"]=$partyId;
        $this->fields["groupName"]=$groupName;
        $this->fields["groupNameLocal"]=$groupName;
        $this->fields["comments"]="";
        
    }
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
    public function write_party(){
        // echo "in write_party now<br>";
       
        
        fwrite($this->fh, "<PartyGroup ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
    
}
//PartyRole
//<PartyRole partyId="10" roleTypeId="CUSTOMER" lastUpdatedStamp="2015-10-08 11:34:00.005" 
//lastUpdatedTxStamp="2015-10-08 11:33:59.944" createdStamp="2015-10-08 11:34:00.005" 
//createdTxStamp="2015-10-08 11:33:59.944"/>
class PartyRole {
    private $fields = array();
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
    }
    function updateInfo ($partyId, $roleTypeId, $date_stamp){
        $this->fields["partyId"]=$partyId;
        $this->fields["roleTypeId"]=$roleTypeId;
        $this->fields["lastUpdatedStamp"]=$date_stamp;
        $this->fields["lastUpdatedTxStamp"]=$date_stamp;
        $this->fields["createdStamp"]=$date_stamp;
        $this->fields["createdTxStamp"]=$date_stamp;  
    }
    function __destruct() {
       unset($this->fields);
       fclose($this->fh);
       
    }
    public function write_party(){
        // echo "in write_party now<br>";
       
        
        fwrite($this->fh, "<PartyRole ");
        foreach ($this->fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    
}

//The following class outputs a party's contact information
//the contactMechId is partid+contact type.  For example, party with id
//AAA, its fax number will have contactMechId of AAAFax
//  
//write fax number. This include records in the following entities:
//ContactMech
//PartyContactMech

/* Example data
 * <ContactMech contactMechId="YAAM1Fax" contactMechTypeId="TELECOM_NUMBER" lastUpdatedStamp="2015-10-28 11:26:24.555" 
 * lastUpdatedTxStamp="2015-10-28 11:26:21.331" createdStamp="2015-10-28 11:26:24.555" createdTxStamp="2015-10-28 11:26:21.331"/>
 * 
 * <PartyContactMech partyId="YAAM1" contactMechId="YAAM1Fax" fromDate="2015-10-28 11:26:24.563" roleTypeId="CUSTOMER" 
 * allowSolicitation="Y" extension="22" lastUpdatedStamp="2015-10-28 11:26:24.563" lastUpdatedTxStamp="2015-10-28 11:26:21.331" 
 * createdStamp="2015-10-28 11:26:24.563" createdTxStamp="2015-10-28 11:26:21.331"/>
 * 
 * <PartyContactMechPurpose partyId="YAAM1" contactMechId="YAAM1Fax" contactMechPurposeTypeId="FAX_NUMBER" 
 * fromDate="2015-10-28 11:26:24.567" lastUpdatedStamp="2015-10-28 11:26:24.567" lastUpdatedTxStamp="2015-10-28 11:26:21.331" 
 * createdStamp="2015-10-28 11:26:24.567" createdTxStamp="2015-10-28 11:26:21.331"/>
 * 
 * <TelecomNumber contactMechId="YAAM1Fax" areaCode="602" contactNumber="222-2222" lastUpdatedStamp="2015-10-28 11:26:24.559" 
 * lastUpdatedTxStamp="2015-10-28 11:26:21.331" createdStamp="2015-10-28 11:26:24.559" createdTxStamp="2015-10-28 11:26:21.331"/>
 * 
 */
class PartyTeleNum{
    private $c_fields = array(); //contactMech
    private $pc_fields = array(); //PartyContactMech
    private $pcp_fields = array(); //PartyContactMechPurpose
    private $d_fields = array(); //time stamps
    private $tele = array(); //telecomNumber
    private $fh;
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
       
    }
    //$type Fax or Phone
    function updateInfo ($partyId, $date_stamp, $num, $type){
        $token=  explode('-', $num);
       
        $area_code=$main=$ext="";
        $tcount=count($token);
        switch ($tcount){
            case 1:$main=$token[0];
                break;
            case 2: $main=$token[0].'-'.$token[1];
                break;
            case 3: 
                //could be area code-phone number or phone number-extension
                if (strlen($token[1])===4){
                    //phone number with extsion
                    $main=$token[0].'-'.$token[1];
                    $ext =$token[2];
                }else {
                    //area code-phone number
                    $area_code=$token[0];
                    $main     = $token[1].'-'.$token[2];
                }
                break;
            case 4:
                $area_code=$token[0];
                $main     =$token[1].'-'.$token[2];
                $ext      =$token[3];
                break;
            default:
                
        }
        //echo "tcount=".$tcount." num=".$num." area_code=".$area_code." main=".$main." ext=".$ext."<br><br>";
                
        
        $this->c_fields["contactMechId"]=$partyId.$type;
        $this->c_fields["contactMechTypeId"]="TELECOM_NUMBER";
        //$this->c_fields["infoString"]=$fax;
        
        
        $this->pc_fields["partyId"]=$partyId;
        $this->pc_fields["contactMechId"]=$this->c_fields["contactMechId"];       
        $this->pc_fields["fromDate"]=$date_stamp;
        $this->pc_fields["roleTypeId"]="CUSTOMER";
        $this->pc_fields["allowSolicitation"]="Y";
        $this->pc_fields["extension"]=$ext;
        
        $this->pcp_fields["partyId"]=$partyId;
        $this->pcp_fields["contactMechId"]=$this->c_fields["contactMechId"]; 
        
        if (strpos($type, "FAX")===FALSE) {
            $this->pcp_fields["contactMechPurposeTypeId"]="PHONE_WORK";
        }else {
            $this->pcp_fields["contactMechPurposeTypeId"]="FAX_NUMBER";
        }
        $this->pcp_fields["fromDate"]=$date_stamp;

        
        $this->d_fields["lastUpdatedStamp"]=$date_stamp;
        $this->d_fields["lastUpdatedTxStamp"]=$date_stamp;
        $this->d_fields["createdStamp"]=$date_stamp;
        $this->d_fields["createdTxStamp"]=$date_stamp;  
       
        $this->tele["contactMechId"]=$this->c_fields["contactMechId"]; 
        $this->tele["areaCode"]=$area_code;
        $this->tele["contactNumber"]=$main;
        
    }
    function __destruct() {
       unset($this->c_fields);
       unset($this->pc_fields);
       unset($this->pcp_fields);
       unset($this->tele);
       unset($this->d_fields);
       fclose($this->fh);
       
    }
    public function write_party(){
        // echo "in write_party now<br>";
       
        
        fwrite($this->fh, "<ContactMech ");
        foreach ($this->c_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
       
        fwrite($this->fh, "/>".PHP_EOL);
        
        fwrite($this->fh, "<PartyContactMech ");
        foreach ($this->pc_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
        
        
        fwrite($this->fh, "<PartyContactMechPurpose ");
        foreach ($this->pcp_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
        
        
        fwrite($this->fh, "<TelecomNumber ");
        foreach ($this->tele as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    private function _write_dates() {
        
        foreach ($this->d_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        
        
    }
    
}
/* Example XML
<ContactMech contactMechId="YAAM3POST" contactMechTypeId="POSTAL_ADDRESS" 
 * lastUpdatedStamp="2015-10-28 11:26:22.819" lastUpdatedTxStamp="2015-10-28 11:26:21.331" 
 * createdStamp="2015-10-28 11:26:22.819" createdTxStamp="2015-10-28 11:26:21.331"/>
<PartyContactMech partyId="YAAM3" contactMechId="YAAM3POST" 
 * fromDate="2015-10-28 11:26:23.599" roleTypeId="CUSTOMER" lastUpdatedStamp="2015-10-28 11:26:23.599" 
 * lastUpdatedTxStamp="2015-10-28 11:26:21.331" createdStamp="2015-10-28 11:26:23.599" 
 * createdTxStamp="2015-10-28 11:26:21.331"/>
<PartyContactMechPurpose partyId="YAAM3" contactMechId="YAAM3POST" 
 * contactMechPurposeTypeId="BILLING_LOCATION" fromDate="2015-10-28 11:26:24.411" 
 * lastUpdatedStamp="2015-10-28 11:26:24.411" lastUpdatedTxStamp="2015-10-28 11:26:21.331" 
 * createdStamp="2015-10-28 11:26:24.411" createdTxStamp="2015-10-28 11:26:21.331"/>
<PostalAddress contactMechId="YAAM3POST" toName="testcust  testcust" address1="123 broadway" 
 * city="tempe" postalCode="85011" countryGeoId="USA" stateProvinceGeoId="AA" 
 * lastUpdatedStamp="2015-10-28 11:26:22.827" lastUpdatedTxStamp="2015-10-28 11:26:21.331" 
 * createdStamp="2015-10-28 11:26:22.827" createdTxStamp="2015-10-28 11:26:21.331"/>
*/
class PartyAddress{

    private $c_fields = array(); //contactMech
    private $pc_fields = array(); //PartyContactMech
    private $pcp_fields = array(); //PartyContactMechPurpose
    private $d_fields = array(); //time stamps
    private $post = array(); //postal address
    private $fh;
    private $geo_id=array(); //country geoid
    private $s_geo_id=array(); //state geoid
    public function __construct($exportfn)
    {
        $this->fh = fopen ($exportfn,"a");
        //read in ofbiz country geoid
        $geof=fopen(TOP_DIR."include/country_geoid.csv", "r");
        while(! feof($geof)){
            $line_array = fgetcsv($geof);
            $this->geo_id[trim($line_array[1])]=trim($line_array[0]);
        }
        fclose($geof);
        print_r($this->geo_id);
        
        //read in ofbiz state geoid
        $geof=fopen(TOP_DIR."include/state_geoid.txt", "r");
        while(! feof($geof)){
            $line = fgets($geof);
            if (trim(strlen($line)>0)){
                array_push($this->s_geo_id, trim($line));
            }
            sort($this->s_geo_id);
        }
        fclose($geof);
               
       
    }
    
    //$type BILL, GENERAL
    function updateInfo ($partyId, $date_stamp, $contact, $address, $city, $zip, 
            $state, $country, $type){
        
        $this->c_fields["contactMechId"]=$partyId.$type;
        $this->c_fields["contactMechTypeId"]="POSTAL_ADDRESS";
        
        $this->pc_fields["partyId"]=$partyId;
        $this->pc_fields["contactMechId"]=$this->c_fields["contactMechId"];       
        $this->pc_fields["fromDate"]=$date_stamp;
        $this->pc_fields["roleTypeId"]="CUSTOMER";
        $this->pc_fields["allowSolicitation"]="Y";
        
        $this->pcp_fields["partyId"]=$partyId;
        $this->pcp_fields["contactMechId"]=$this->c_fields["contactMechId"]; 
        
        if (strpos($type, "GENERAL")===FALSE) {
            $this->pcp_fields["contactMechPurposeTypeId"]="BILLING_LOCATION";
        }else {
            $this->pcp_fields["contactMechPurposeTypeId"]="GENERAL_LOCATION";
        }
        $this->pcp_fields["fromDate"]=$date_stamp;

        
        $this->d_fields["lastUpdatedStamp"]=$date_stamp;
        $this->d_fields["lastUpdatedTxStamp"]=$date_stamp;
        $this->d_fields["createdStamp"]=$date_stamp;
        $this->d_fields["createdTxStamp"]=$date_stamp;  
       
        
        $this->post["contactMechId"]=$this->c_fields["contactMechId"]; 
        $this->post["toName"]=$contact;
        $this->post["address1"]=$address;
        $this->post["city"]=$city;
        $this->post["postalCode"]=$zip; 
        $this->post["countryGeoId"]="";
        $this->post["stateProvinceGeoId"]="";
        
        //convert country to ofbiz geo code
        if (strlen($country)>0){
            if (key_exists($country, $this->geo_id)){
                $this->post["countryGeoId"]=$this->geo_id[$country];
                echo $this->post["countryGeoId"]."<br>";
            }
        }
        
        //make sure state is complied to ofbiz geo code
        //assume foreign country with blank state field because
        //info from sbt is not precise
        if (strlen($state)){
            if (in_array($state, $this->s_geo_id)) {
                if (strlen($this->post["countryGeoId"])===0){
                    $this->post["countryGeoId"]="USA";//assume is USA if state is valid
                }
                $this->post["stateProvinceGeoId"]=$state;
            }
        }
        
       
        
    }
    
    function __destruct() {
       unset($this->c_fields);
       unset($this->pc_fields);
       unset($this->pcp_fields);
       unset($this->post);
       unset($this->d_fields);
       unset($this->geo_id);
       fclose($this->fh);
       
    }
    
    public function write_party(){
        // echo "in write_party now<br>";
       
        
        fwrite($this->fh, "<ContactMech ");
        foreach ($this->c_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
       
        fwrite($this->fh, "/>".PHP_EOL);
        
        fwrite($this->fh, "<PartyContactMech ");
        foreach ($this->pc_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
        
        
        fwrite($this->fh, "<PartyContactMechPurpose ");
        foreach ($this->pcp_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
        
        
        fwrite($this->fh, "<PostalAddress ");
        foreach ($this->post as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        $this->_write_dates();
        fwrite($this->fh, "/>".PHP_EOL);
       
    }
    private function _write_dates() {
        
        foreach ($this->d_fields as $key => $value){
            $str=$key.'="'.$value.'" ';
            fwrite($this->fh, $str);
        }
        
        
    }
    
    //make sure zip code only contains number and '-'
    //otherwise, it is a foreign zip code
    private function _check_zip($s){
        if (preg_match("/[^\d-]/", $s)){
            return TRUE;
        }else {
            return FALSE;
        }
        
    }
    
}
?>
<?php

/* 
 * Get Customer Export File
 * 
 * created by Yvonne Lu 10-12-15
 * 
 */



$db = new EXPmodel($names['dsn']);


echo "GetCustomer.php called ";



$arr_cust = $db->exportCustomers($count);

if ($count>0){
    echo "Generating ".$count." records<br>";
    //erase previous export
    if (file_exists ($names['cust_xml'])){
        unlink($names['cust_xml']);
    }
    $fh = fopen ($names['cust_xml'], "a");
    fwrite($fh, '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL);
    fwrite($fh, '<entity-engine-xml>'.PHP_EOL);
    
    

    $cust       = new Party($names['cust_xml']);
    $cust_group = new PartyGroup($names['cust_xml']);
    $cust_role  = new PartyRole($names['cust_xml']);
    $cust_phone = new PartyTeleNum($names['cust_xml']);
    $cust_fax   = new PartyTeleNum($names['cust_xml']);
    $cust_addr   = new PartyAddress($names['cust_xml']);
    //$c_array = array();
    $s_array = array();
    //print_r($arr_cust);
    //echo "test address: ".$arr_cust[0][4]."<br>";
    //echo "test address: ".$arr_cust[2][4]."<br>";
    //1. custno, 2 company name, 3 contact, 4 address1, 5 address2, 6 address3,
    //7, city, 8 state, 9 zip, 10 country, 11 phone number, 12 fax number
    //
    foreach ($arr_cust as $k => $v) {
       
        
        $pid    = $v[1];
        $pname  = $v[2];
        $contact = $v[3];
        $addr   = trim($v[4].' '.$v[5].' '.$v[6]);
        $city   = $v[7];
        $state  = $v[8];
        $zip    = $v[9];
        $country= $v[10];
        /*
        if (strlen($country)>0){
            
            if (array_key_exists($country,$c_array)){
                
                $n = $c_array[$country];
                $c_array[$country]=++$n;
            }else {
                $c_array[$country]=1;
            }
           
            
        }*/
        $phone  = $v[11];
        $fax    = $v[12];
        
        //party
        $cust->updateInfo($pid);
        $cust->write_party();
        
        //party group
        $cust_group->updateInfo($pid, $pname);
        $cust_group->write_party();
        
        //party role
        $cust_role->updateInfo($pid, "BILL_TO_CUSTOMER", $cust->get_date());
        $cust_role->write_party();
        $cust_role->updateInfo($pid, "CUSTOMER", $cust->get_date());
        $cust_role->write_party();
        
        //address
        if (strlen($addr)>0){
            $cust_addr->updateInfo($pid, $cust->get_date(), $contact, $addr, 
                    $city, $zip, $state, $country, "BILLING");
            $cust_addr->write_party();
        }
        
        //phone number
        if (strlen($phone)>0){
            $cust_fax->updateInfo($pid, $cust->get_date(), $phone, "PHONE");
            $cust_fax->write_party();
        }
        //fax number
        if (strlen($fax)>0){
            $cust_fax->updateInfo($pid, $cust->get_date(), $fax, "FAX");
            $cust_fax->write_party();
        }
        /*
         $val_count=0;
         foreach ($v as $key => $val) {
             switch ($val_count) {
                case 0:
                    $cust->updateInfo($val);
                    $cust->write_party();
                    $pid=$val;
                break;
                case 1:
                    $cust_group->updateInfo($pid, $val);
                    $cust_group->write_party();
                    $cust_role->updateInfo($pid, "BILL_TO_CUSTOMER", $cust->get_date());
                    $cust_role->write_party();
                    $cust_role->updateInfo($pid, "CUSTOMER", $cust->get_date());
                    $cust_role->write_party();
                    break;
                default:
             }
            
             //echo $val."   ";
             $val_count++;
         }
         echo "<br>";
         * 
         */
         
         
       
    }
    fwrite($fh, '</entity-engine-xml>'.PHP_EOL);
    fclose($fh);
    /*
    $tfh = fopen("c:\users\lemon\documents\ofbiz\geo\sbt_c.txt", 'w');
    
    ksort($c_array);
    foreach ($c_array as $key => $val) {
        echo "$key = $val\n";
        fwrite($tfh, $key.PHP_EOL);
    }
    fclose($tfh);
    
    $sfh = fopen("c:\users\lemon\documents\ofbiz\geo\sbt_s.txt", 'w');
    
    ksort($s_array);
    foreach ($s_array as $key => $val) {
        echo "$key = $val\n";
        fwrite($sfh, $key.PHP_EOL);
    }
    fclose($sfh);*/
    
}else {
    echo "count=0<br>";
}


