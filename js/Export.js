/* 
 * javascript file for XML export functions
 * 
 * created by Yvonne Lu 10-12-15
 */

$(function(){
    
   

    $('#content').on('click', '#exp_customer', function() {
        var dest="controller/GetCustomers.php";
        
         var jqxhr = $.post(dest, "", function(html) {                       
                    $(".noshow").show();
                    
                    $("#return_msg").html(html);
                    
                     })
                    .fail(function(x, e) {
                        $(".noshow").show();    
                        error_alert(x,e);
                        console.log("exp_customer error");
                    })    
                    .complete (function(){
                        $('.noshow').hide();
                        console.log("exp_customer finished");
                    }); 
        
    });
    
    $('#content').on('click', '#exp_product', function() {
        var dest="controller/GetCatalog.php";
        
        var jqxhr = $.post(dest, "", function(html) {                       
                    $(".noshow").show();
                    
                    $("#return_msg").html(html);
                    
                     })
                    .fail(function(x, e) {
                        $(".noshow").show();    
                        error_alert(x,e);
                        console.log("exp_product error");
                    })    
                    .complete (function(){
                        $('.noshow').hide();
                        console.log("exp_prodcut finished");
                    }); 
        
    });
    
    $('#content').on('submit', '#sub_cat_form', function() {
      
       
        return false;

    });
    
    $('#content').on('click', '#sub_cat', function() {
        var catalog = $('#catalog').val();
        var category = $('#category').val();
        var create_cat = $('#create_cat').is(':checked');
        if ((catalog.length<=0)||(category.length<=0)){
            alert("Catalog and Category Names Cannot Be Empty")
            return false;
        }
        //alert ("here!"+create_cat);
        var dest="controller/GetProducts.php?catalog="+catalog+"&category="+category+"&create_cat="+create_cat;
        
        var jqxhr = $.post(dest, "", function(html) {                       
                    $(".noshow").show();
                    
                    $("#return_msg").html(html);
                     })
                    .fail(function(x, e) {
                        $(".noshow").show();    
                        error_alert(x,e);
                        console.log("sub_cat error");
                    })    
                    .complete (function(){
                        $('.noshow').hide();
                        
                        console.log("sub_cat finished");
                    }); 
        
    });
    
    function error_alert(x, e) {
        if(x.status===0){
            alert('Form submission overwrite');
        }else if(x.status===404){
            alert('Requested URL not found.');
        }else if(x.status===401){
            alert('URL too long.');
        }else if(x.status===500){
            alert('Internel Server Error.');
        }else if(e==='parsererror'){
            alert('Error.\nParsing JSON Request failed.');
        }else if(e==='timeout'){
            alert('Request Time out.');
        }else {
            alert('Unknow Error.\n'+x.responseText);
        }
             
    }
});
