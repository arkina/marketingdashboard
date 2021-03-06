<!DOCTYPE html>
<!-- saved from url=(0050)http://handsontable.github.io/handsontable-ruleJS/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Marketing Dashboard(Runrate)</title>

  <!-- Jqtreetable -->
 
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.theme.default.css">

  <!-- handsontable v1 -->
  
  <!--link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/handsontable.full.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/handsontable.formula.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/github.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/font-awesome.min.css">
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/handsontable.full.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/lodash.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/underscore.string.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/moment.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/numeral.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/numeric.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/md5.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/jstat.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/formula.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/parser.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/ruleJS.js"></script>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/handsontable.formula.js"></script>
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php //echo base_url();?>assets/handsontable/samples.css">
  <script src="<?php echo base_url();?>assets/handsontable/samples.js"></script>
  <script src="<?php echo base_url();?>assets/handsontable/highlight.pack.js"></script-->


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-3.3.6/css/bootstrap-theme.min.css">

</head>
<body style="">

<div class="container-fluid">
  <div class="row">

      <div class="col-sm-12 col-md-12  main">
              <h2>Runrate</h2>
              
           
                <a href="./revenues_01/download">Download</a>

                  <table id="revenueTbl">
                  <thead id="first-head">
                    <?php echo $header;?>
                    
                  </thead>
                  <tbody id="first-body">
                    <?php echo $body;?>
                  </tbody>
                    <thead>
                    <?php echo $footer;?>
                    
                  </thead>
                   </table>


      </div>
  

  </div>
</div>

<script data-jsfiddle="common" src="<?php echo base_url();?>assets/jquery-1.10.2.js"></script>
<script src="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.js"></script>
<script src="<?php echo base_url();?>assets/bootstrap-3.3.6/js/bootstrap.min.js" ></script>
 <script >


 Date.prototype.yyyymmdd = function() {
   var yyyy = this.getFullYear().toString();
   var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = this.getDate().toString();
   return yyyy +"-"+ (mm[1]?mm:"0"+mm[0])+"-"+ (dd[1]?dd:"0"+dd[0]); // padding
  };

   Date.prototype.date_sub = function(x) {
  
   return this.setDate(this.getDate() + x);
  };


   function get_post_JSON_Obj(link,type,data){
        var res = $.ajax({type: type, url: link, data:data, async: false }).responseText;
        return JSON.parse(res);
   }
function Left(str, n){
  if (n <= 0)
      return "";
  else if (n > String(str).length)
      return str;
  else
      return String(str).substring(0,n);
}
function Right(str, n){
    if (n <= 0)
       return "";
    else if (n > String(str).length)
       return str;
    else {
       var iLen = String(str).length;
       return String(str).substring(iLen, iLen - n);
    }
}

   function get_month_name(m){
     var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']; 
     return monthNames[parseInt(m-1)];
   }       


    $("#revenueTbl").treetable({ expandable: true });
			




              </script>
  



</body></html>