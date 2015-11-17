<?php

/* 
 * database manipulation class for getting export information for Ofbiz
 * 
 * created by Yvonne Lu 10-9-15
 */

class EXPmodel {
    //odbc connection id
    public $cnx;
    
    //current dsn is passed in depending on whether software is in 
    //testing or production stage
    public function __construct($cur_dsn)
    {
       
       
        //connect to foxpro
        $dsn = $cur_dsn;
        
        $this->cnx= odbc_connect($dsn,"","");
        
        if( ! $this->cnx ) {
            $this->Error_handler( "Model:", "Error in odbc_connect");
            odbc_close( $this->cnx);
        }
       
        
    }
    
    function __destruct() {
       odbc_close( $this->cnx);
       
    }
    
    function Error_handler( $msg) {
    	echo "$msg \n";
        if ($this->cnx) {
            odbc_close( $this->cnx);
        }
        exit();
    }
    
    public function exportCustomers(&$detail_count){
        
    $two_D_array = array(array());
    
    
    $query="SELECT CUSTNO, COMPANY, CONTACT, ADDRESS1, ADDRESS2, ADDRESS3, "
            ."CITY, STATE, ZIP, COUNTRY, PHONE, FAXNO, not DELETED() FROM arcust01 ORDER BY CUSTNO";
                
            
    $cur=odbc_exec($this->cnx, $query);
        
    $row=0; 
    if( ! $cur ) {
        $this->Error_handler( "exportCustomers:  Error in odbc_exec( no cursor returned ) "  );
     } else {

        // get # of headings
        $nfields = odbc_num_fields($cur); 
                
               
        //get contents
        while(odbc_fetch_row($cur)) { 
                                 
            $name= $this->_string_sanitize(trim(odbc_result($cur, 2)));
            $address1=$this->_string_sanitize(trim(odbc_result($cur, 4)));
            $address2=$this->_string_sanitize(trim(odbc_result($cur, 5)));
            
            //filter out customer names that are blanks, contains "*"
            if ((strlen($name)==0) || (strpos($name, "*")!== FALSE)) {
                //not a valid company if company name is blank or contains *
                continue;
            }
            if ((stripos($address1, "closed"))||(stripos($address1,"out of business"))){
                //account closed or out of business
                //don't ask me why this is part of an address
                continue;
            }
            if ((stripos($address2, "closed"))||(stripos($address2,"out of business"))){
                //account closed or out of business
                //don't ask me why this is part of an address
                continue;
            }
            //filter out customer names that does not contain any
            //alphabets (such as "..1")
            if (!(preg_match('/[a-zA-Z]/', $name)))
            {
                continue;
            }
            
            for($j = 1; $j <= $nfields; $j++) {
                $value =  $this->_string_sanitize(trim(odbc_result($cur, $j)));
                if ($j===8){
                    //santitize state
                    $value=$this->_sanitize_state($value);
                    //echo "address1=".$address1." state=".$value."<br>";
                }
                if (($j===11)||($j===12)){
                    //for phone and fax numbers
                    $value=$this->_sanitize_phonenum($value);
                }
                $two_D_array[$row][$j] = $value;
                
            }
            $row++;
           
        }
     }
     $detail_count = $row;
     return $two_D_array;
                       
        
    }
    
    public function exportProducts(&$detail_count){
        $two_D_array = array(array());
         
        $query="SELECT ITEM, DESCRIP, not DELETED() FROM arinvt01 ORDER BY ITEM";
          
        $cur=odbc_exec($this->cnx, $query);
        $row=0; 
        if( ! $cur ) {
            $this->Error_handler( "exportProducts:  Error in odbc_exec( no cursor returned ) "  );
         } else {

            // get # of headings
            $nfields = odbc_num_fields($cur); 


            //get contents
            while(odbc_fetch_row($cur)) { 

                //varify product name
                $name= $this->_string_sanitize(trim(odbc_result($cur, 2)));
                if (!($this->_name_varify($name))){
                    //echo $name." bad<br>";
                    continue;
                }
                for($j = 1; $j <= $nfields; $j++) {
                    
                    $value =  $this->_string_sanitize(trim(odbc_result($cur, $j)));
                    $two_D_array[$row][$j] = $value;

                }
                $row++;

            }
     }
     $detail_count = $row;
     return $two_D_array;
        
    }
    
    //filter out blanks,name that contains DISCONTINUED, OBSOLETE
    // or DO NOT USE
    //returns true if string is a valid name
    function _name_varify($s) {
        if (strlen(trim($s))>0){
            $r1= stripos($s,"DISCONTIN"); //some discontinued comments were misspelled
            $r2= stripos($s, "OBSOLETE");
            $r3= stripos($s, "DO NOT USE");
            $r4 = stripos($s, "Disconinued");
            $r5 = stripos($s, "DISCOUNTINUED");
            $r6 = stripos($s, "DELETED"); 
            $r7 = stripos($s, "NOT AVAILABLE"); 
            $r8 = stripos($s, "DICOUNTINUED"); 
            //echo $s." ".$r1." ".$r2." ".$r3."<br>";
            if (($r1===false)&&($r2===false)&&($r3===false)&&($r4===false)&&
                    ($r5===false)&&($r6===false)&&($r7===false)&&($r8===false)){
           
                return true;
            }else {
                
                return false;
            }
        }
       
        return false;
         
    }
    
    function _string_sanitize($s) {
    
        $result = preg_replace("/[&<>=,'\"\/]/", " ", $s);
        return $result;
    }
    
    //state is valid if it is 2 characters
    //that does not contain anything but letters
    function _sanitize_state($s) {
       
        $result="";
        if ((trim(strlen($s))!==2)||(preg_match("/[^a-zA-Z]/", $s))){
            return $result;
        }else {
            return strtoupper($s);
        }
        
    }
    
    //returns area code, phone number, extension
    //separate by '-'
    function _sanitize_phonenum($s) {
        
        //echo $s."  preg match: ";
        $result="";
        //contains at least one number
        preg_match_all ("/\d+/", $s, $tokens);
        if (count($tokens[0])>0){
            if (strlen($tokens[0][0])>2){
                for ($i=0; $i<count($tokens[0]); $i++){
                    if (strlen($tokens[0][$i])>0){
                        $result.=$tokens[0][$i];
                        if ($i<(count($tokens[0])-1)){
                            $result.='-';
                        }
                    }
                }
            }
           
        }
        /*
        if (preg_match("/\d/", $s)>0){
            $tokens = preg_split("/[ -\/]/", $s);
            for ($i=0; $i<count($tokens); $i++){
                if ($i===0){
                    //check that area code or the first part of phone number
                    //is valid
                    if (strlen($tokens[$i])!==3){
                        continue;
                    }
                }
                if (strlen($tokens[$i])>0){
                    $result.=$tokens[$i];
                    if ($i<(count($tokens)-1)){
                        $result.='-';
                    }
                }
            }

            //$result = str_replace('/', '-', $s);
        }*/
       
       
        //echo $result."<br>";
        
        return $result;
    }
}

