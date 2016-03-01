<!DOCTYPE html>
<!-- saved from url=(0050)http://handsontable.github.io/handsontable-ruleJS/ -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title>Marketing Dashboard(Runrate)</title>
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/jquery-1.10.2.js"></script>

  <!-- handsontable v1 -->
  <script data-jsfiddle="common" src="<?php echo base_url();?>assets/handsontable/handsontable.full.js"></script>
  <link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/handsontable.full.css">
  <!-- ruleJS -->
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/handsontable.formula.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.theme.default.css">
  
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
  <script src="<?php echo base_url();?>assets/handsontable/samples.js"></script>
  <script src="<?php echo base_url();?>assets/handsontable/highlight.pack.js"></script>


  <script src="<?php echo base_url();?>assets/jqtreetable/jquery.treetable.js"></script>

  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/github.css">
  <link rel="stylesheet" media="screen" href="<?php echo base_url();?>assets/handsontable/font-awesome.min.css">


<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-3.3.6/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap-3.3.6/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="<?php echo base_url();?>assets/bootstrap-3.3.6/js/bootstrap.min.js" ></script>

  <!--link data-jsfiddle="common" rel="stylesheet" media="screen" href="<?php //echo base_url();?>assets/handsontable/samples.css"-->
</head>
<body style="">

<div class="container-fluid">
  <div class="row">

      <div class="col-sm-12 col-md-12  main">
              <h2>Runrate</h2>
              
           
                <a href="./revenues/dlTablexls">Download</a>

                  <table id="revenueTbl">
                  <thead>
                    <tr><th >REVENUE SUMMARY (in PHP 000s)</th></tr>
                    
                  </thead>
                  <tbody></tbody>
                  
                  </table>
                  

    
      </div>
  

  </div>
</div>


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

   html = get_post_JSON_Obj("./revenues/revTable","GET","");

   var d = new Date(); 
d.date_sub(-1);
var monthInt =parseInt(Right(Left(d.yyyymmdd(),7),2));

          
          var thead = "";
          for (i = 1; i <= monthInt; i++) { 
              thead += "<th>" +get_month_name(i) +" Rev</th>";
              thead += "<th>" +get_month_name(i) +" Bud</th>";
              thead += "<th>" +get_month_name(i) +" Var</th>";
              thead += "<th>" +get_month_name(i) +" %</th>";
          }

  $("#revenueTbl > thead > tr:first-child").append(thead);
   $("#revenueTbl > tbody").html(html.tbody);
   $("#revenueTbl > thead").append(html.thead);

    $("#revenueTbl").treetable({ expandable: true });
			




              </script>
  



</body></html>