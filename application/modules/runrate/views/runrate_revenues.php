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
              <button id="btn-save">Save</button>
              <div id="revenueTbl" class="handsontable"></div>
      </div>
  

  </div>
</div>

              <script >

              	var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];	
				var data = $.ajax({
				    type: "GET",
				    url: "./runrate/handsonjson",
				    async: false
				}).responseText;

				var objData = JSON.parse(data);

                var data1 = objData.data;

                //var container1 = $('#revenueTbl');
             var container1 = document.getElementById('revenueTbl'),
	                save = document.getElementById('btn-save'),
              hot;
               

                hot = new Handsontable(container1,{
                  data: data1,
                  minSpareRows: 0,
                  colHeaders: true,
                  rowHeaders: true,
                  contextMenu: false,
                  manualColumnResize: false,
                  formulas: true,
                  groups: objData.group,
                  fixedColumnsLeft: 2,
                  fixedRowsTop: 1,
                  afterRender: function () {
                  // colspan = container1.find('tbody').find('tr:first-child').find("td").css({"font-weight":"bold","width":"100%"}).attr("nowrap","nowrap");
                   // container1.find('tbody').find('tr').find("td:first").hide();
                  }
                });


                Handsontable.Dom.addEvent(save, 'click', function() {

                  console.log(hot.getData());
    // save all cell's data
  /*  ajax('scripts/json/save.json', 'GET', JSON.stringify({data: hot.getData()}), function (res) {
      var response = JSON.parse(res.response);

      if (response.result === 'ok') {
        exampleConsole.innerText = 'Data saved';
      }
      else {
        exampleConsole.innerText = 'Save error';
      }
    });*/
  });

          

              </script>
  



</body></html>