<?php
  include('session.php');
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Beer</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!--Custom CSS -->
		<link href="css/custom.css" rel="stylesheet">

    <style type="text/css">
    /*div{
      background: #CCC;
      border: thin white solid;
    }*/
    </style>

    <!-- jQuery -->
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">

      function addRow(table){
        // return "adding row to " + table;
        var cloneRow = $('#' + table + ' tbody tr').first().html();
        // alert(cloneRow);
        $('#' + table + ' tbody tr').last().after('<tr>' + cloneRow + '</tr>');
        $('#' + table + ' tbody tr').last().find('input').val("");
      }
      function toggleRow(table,thisbutton){
        $(thisbutton).parents('tr').find('#iEdit').toggle();
        //alert($(thisbutton).parents('tr').find('#iEdit').html());
        $(thisbutton).parents('tr').find('#iAction').toggle();
      }
      function saveRow(table,thisbutton){
        var row = $(thisbutton).parents('tr');
        if (table == "fermentTable"){
          // make variable for each part of save
          var id = $(row).find('input[name=iId]').val();
          var name = $(row).find('input[name=iName]').val();
          var pounds = $(row).find('input[name=iPounds]').val();
          var ounces = $(row).find('input[name=iOunces]').val();
          var percentage = $(row).find('input[name=iPercent]').val();
          //alert(percentage);
          var batchId = <?php echo $_GET["id"]; ?>;
          if(id != null){
            // Post to ajax.php as an update
            $.ajax({
              url: 'ajax.php',
              method: 'POST',
              data: {batchId: batchId, table: 'fermentables', action: 'update', id: id, name: name, pounds: pounds, ounces: ounces, percentage: percentage}
            }).done(function(data){
              toggleRow(table,thisbutton);
              console.log(data);
            }).error(function(jqXHR, textStatus, errorThrown){
              console.log(jqXHR);
              console.log(textStatus);
              console.log(errorThrown);
            });
          } else{
            // Post to ajax.php as an addition
            $.ajax({
              url: 'ajax.php',
              method: 'POST',
              data: {batchId: batchId, table: 'fermentables', action: 'add', id: id, name: name, pounds: pounds, ounces: ounces, percentage: percentage}
            }).done(function(data){
              toggleRow(table,thisbutton);
              console.log(data);
            }).error(function(jqXHR, textStatus, errorThrown){
              console.log(jqXHR);
              console.log(textStatus);
              console.log(errorThrown);
            });
          }
        }
      }

      function deleteRow(table,thisbutton){
        var row = $(thisbutton).parents('tr');
        if (table == "fermentTable"){
          // make variable for each part of save
          var id = $(row).find('input[name=iId]').val();
          var name = $(row).find('input[name=iName]').val();
          var pounds = $(row).find('input[name=iPounds]').val();
          var ounces = $(row).find('input[name=iOunces]').val();
          var percentage = $(row).find('input[name=iPercent]').val();
          //alert(percentage);
          var batchId = <?php echo $_GET["id"]; ?>;

          // Post to ajax.php
          $.ajax({
            url: 'ajax.php',
            method: 'POST',
            data: {batchId: batchId, table: 'fermentables', action: 'delete', id: id, name: name, pounds: pounds, ounces: ounces, percentage: percentage}
          }).done(function(data){
            toggleRow(table,thisbutton);
            console.log(data);
          }).error(function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
          });
        }
      }
    </script>

  </head>
  <body>
    <?php
    // ID for beer from query
    $BeerId = $_GET["id"];
    // include connection to datatbase
    include("connect.php");

    //include menu.php
    include("menubar.php");
    ?>
    <div class="container">
      <div class='row'>
        <div class='col-md-12'>
          <?php
          //Batch data
          $batchSql = "SELECT * FROM batch WHERE batchId = $BeerId";
          $batchResult = $conn->query($batchSql);

          //Create Batch Vars
          $bvName = "";
          $bvBatchSize = 0;
          $bvBatchId = 0;
          $bvBatchDate = 66;

          if ($batchResult->num_rows > 0) {
            // output data of each row
            while($row = $batchResult->fetch_assoc()) {
              //Set Batch Vars
              $bvName = $row["batchName"];
              $bvBatchSize = $row["batchSize"];
              $bvBatchId = $row["batchId"];
              $bvBatchDate = strtotime($row["batchDate"]);

              echo"<div class='page-header'><h1>Batch ".$bvBatchId.": Post to Database</h1>";
            }
          } else {
            echo "<div class='alert alert-warning' role='alert'>Invalid Batch ID";
          }
          ?></div>
          <!-- alert goes here<br/>
          <hr/> -->
          <form action='../beerdev/test.php' method='get'>
            <div class='row form-group'>
              <div class='col-md-7 form-inline'>
              <label class="control-label" for='switchNumber'>Batch Number: </label>
              <input id='switchNumber' type ='text' name='id' class='form-control' placeholder='Batch Number' />
              <button id='switchBatchLink' type='submit' value='Switch Batch' class='btn btn-info btn-md'>Switch Batch</button>
              <!-- Below make script for generating link for button above-->
              </div>
            </div>
          </form>
          <hr/>
          <div class='col-md-12'>
            <?php
            // put SQL ferm data for batch into a 2d array
            $fermRows = 0;
            $fermArray = array(); //Define Fermentable Array
            //ferm data
            $fermSql = "SELECT * FROM fermentables WHERE batchId = $BeerId";
            $fermResult = $conn->query($fermSql);
            if ($fermResult->num_rows > 0) {
                // output data of each row
                while($row = $fermResult->fetch_assoc()) {
                  //push array of data into fermArray
                  array_push($fermArray,array($row["fermId"],$row["name"],$row["pounds"],$row["ounces"],$row["percent"]));
                }
            }

            //build input table
            echo "<h2>Fermentables</h2>".
            "<table id='fermentTable' class='table table-hover table-striped'>".
            "<thead><th class='hidden-sm hidden-xs'><div class='col-md-4'>Name</div><div class='col-md-2'>Pounds</div><div class='col-md-2'>Ounces</div><div class='col-md-2'>Percentage</div><div class='col-md-2'></div></th></thead>".
              "<tbody>";
                // populate table
                $fermArrayCount = count($fermArray);
                while($fermRows < $fermArrayCount){
                  if($fermRows < $fermArrayCount){
                    echo "<tr><td>".
                    //populate from array

                      "<div class='hidden'>".
                        "<input class='' type='text' name='iId' class='form-control' value='".$fermArray[$fermRows][0]."' placeholder='fermId'/>".
                      "</div>".
                      "<div class='col-md-4'>".
                        "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='iName'>Name</label>".
                        "<input class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='iName' class='form-control' value='".$fermArray[$fermRows][1]."' placeholder='Name'/>".
                      "</div>".
                      "<div class='col-md-2'>".
                        "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='iPounds'>Pounds</label>".
                        "<input class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='iPounds' class='form-control' value='".$fermArray[$fermRows][2]."'placeholder='Pounds'/>".
                      "</div>".
                      "<div class='col-md-2'>".
                        "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='iOunces'>Ounces</label>".
                        "<input class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='iOunces' class='form-control' value='".$fermArray[$fermRows][3]."'placeholder='Ounces'/>".
                      "</div>".
                      "<div class='col-md-2'>".
                        "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='iPercent'>Percent</label>".
                        "<input class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='iPercent' class='form-control' value='".$fermArray[$fermRows][4]."'placeholder='Percentage'/>".
                      "</div>".
                      "<div class='col-md-2'>".
                        // "<span class='col-xs-10 col-lg-4'></span>".
                        // "<span class='col-xs-2 col-lg-4'>".
                          "<div id='iEdit' class='btn-group' role='group' aria-label='...'>".
                            "<button type='button' class='btn btn-xs btn-info' onclick='toggleRow(\"fermentTable\",this)'>Edit</button>".
                          "</div>".
                          "<div id='iAction' class='btn-group' style='display:none' role='group' aria-label='...'>".
                            "<button type='button' class='btn btn-xs btn-info' onclick='saveRow(\"fermentTable\",this)'>Save</button>".
                            "<button type='button' class='btn btn-xs btn-info' onclick='toggleRow(\"fermentTable\",this)'>Delete</button>".
                            "<button type='button' class='btn btn-xs btn-info' onclick='toggleRow(\"fermentTable\",this)'>Cancel</button>".
                          "</div>".
                        // "</span>".
                      "</div>".
                    "</td></tr>";
                  }
                  $fermRows++;
                }
            echo "</tbody></table>";
            echo "<a href='#' onclick='addRow(\"fermentTable\");'>Add Row</a>"
            ?>

            <!-- HOPs -->
            <?php
            // put SQL ferm data for batch into a 2d array
            $hopRows = 0;
            $hopArray = array(); //Define Fermentable Array
            //hop data
            $hopSql = "SELECT * FROM hops WHERE batchId = $BeerId ORDER BY minutes DESC";
            $hopResult = $conn->query($hopSql);
            if ($hopResult->num_rows > 0) {
                // output data of each row
                while($row = $hopResult->fetch_assoc()) {
                  //push array of data into hopArray
                  array_push($hopArray,array($row["name"],$row["ounces"],$row["minutes"],$row["usedFor"],$row["form"],$row["alphaAcid"]));
                }
            }
            if(count($hopArray) > 10){
              $hopRowMax = count($hopArray);
            } else $hopRowMax = 10;
            //build input table
            echo "<h2>Hops</h2>".
            "<table class='table table-hover table-striped'>".
              "<th class='hidden-sm hidden-xs'><div class='col-md-2'>Name</div><div class='col-md-2'>Amount</div><div class='col-md-2'>Time</div><div class='col-md-2'>Use</div><div class='col-md-2'>Form</div><div class='col-md-2'>Alpha Acid</div></th>".
              "<tbody>";
                // populate table
                $hopArrayCount = count($hopArray);
                while($hopRows < $hopRowMax){
                  if($hopRows < $hopArrayCount){
                    echo "<tr><td>".
                    //populate from array
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hName$hopRows'>Name</label>".
                      "<input id='hName$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hName$hopRows' class='form-control' value='".$hopArray[$hopRows][0]."' placeholder='Name'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hAmount$hopRows'>Amount</label>".
                      "<input id='hAmount$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hAmount$hopRows' class='form-control' value='".$hopArray[$hopRows][1]."' placeholder='Amount'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hTime$hopRows'>Time</label>".
                      "<input id='hTime$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hTime$hopRows' class='form-control' value='".$hopArray[$hopRows][2]."' placeholder='Time'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hUse$hopRows'>Use</label>".
                      "<input id='hUse$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hUse$hopRows' class='form-control' value='".$hopArray[$hopRows][3]."' placeholder='Use'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hForm$hopRows'>Form</label>".
                      "<input id='hForm$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hForm$hopRows' class='form-control' value='".$hopArray[$hopRows][4]."' placeholder='Form'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hAlphaAcid$hopRows'>Alpha Acid</label>".
                      "<input id='hAlphaAcid$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hAlphaAcid$hopRows' class='form-control' value='".$hopArray[$hopRows][5]."' placeholder='Alpha Acid'/>".
                    "</div>".
                    "</td></tr>";
                    //echo $hopArray[$hopRows][0]." : ".$hopArray[$hopRows][1]." : ".$hopArray[$hopRows][2]." : ".$hopArray[$hopRows][3]."<br/>";
                    $hopRows++;
                  } else{
                    //populate with blank row
                    echo "<tr><td>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hName$hopRows'>Name</label>".
                      "<input id='hName$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hName$hopRows' class='form-control' value='' placeholder='Name'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hAmount$hopRows'>Amount</label>".
                      "<input id='hAmount$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hAmount$hopRows' class='form-control' value='' placeholder='Amount'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hTime$hopRows'>Time</label>".
                      "<input id='hTime$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hTime$hopRows' class='form-control' value='' placeholder='Time'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hUse$hopRows'>Use</label>".
                      "<input id='hUse$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hUse$hopRows' class='form-control' value='' placeholder='Use'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hForm$hopRows'>Form</label>".
                      "<input id='hForm$hopRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type ='text' name='hForm$hopRows' class='form-control' value='' placeholder='Form'/>".
                    "</div>".
                    "<div class='col-md-2'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='hAlphaAcid$hopRows'>Alpha Acid</label>".
                      "<input class='col-lg-12 col-md-12 col-sm-8 col-xs-6' id='hAlphaAcid$hopRows' type ='text' name='hAlphaAcid$hopRows' class='form-control' value='' placeholder='Alpha Acid'/>".
                    "</div>".
                    "</td></tr>";
                    //echo "blank row<br/>";
                    $hopRows++;
                  }
                }
            echo "</tbody></table>";
            ?>

            <!-- YEAST -->
            <?php
            // put SQL ferm data for batch into a 2d array
            $yeastRows = 0;
            $yeastArray = array(); //Define Fermentable Array
            //yeast data
            $yeastSql = "SELECT * FROM yeast WHERE batchId = $BeerId";
            $yeastResult = $conn->query($yeastSql);
            if ($yeastResult->num_rows > 0) {
                // output data of each row
                while($row = $yeastResult->fetch_assoc()) {
                  //push array of data into yeastArray
                  array_push($yeastArray,array($row["name"],$row["tempLow"],$row["tempHigh"]));
                }
            }
            if(count($yeastArray) > 2){
              $yeastRowMax = count($yeastArray);
            } else $yeastRowMax = 2;
            //build input table
            echo "<h2>Yeast</h2>".
            "<table class='table table-hover table-striped'>".
            "<th class='hidden-sm hidden-xs'><div class='col-md-6'>Yeast Name</div><div class='col-md-3'>Yeast Low Temp</div><div class='col-md-3'>Yeast High Temp</div></th>".
              "<tbody>";
                // populate table
                $yeastArrayCount = count($yeastArray);
                while($yeastRows < $yeastRowMax){
                  if($yeastRows < $yeastArrayCount){
                    echo "<tr><td>".
                    //populate from array
                    "<div class='col-md-6'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yName$yeastRows'>Name</label>".
                      "<input id='yName$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yName$yeastRows' class='form-control' value='".$yeastArray[$yeastRows][0]."' placeholder='Name'/>".
                    "</div>".
                    "<div class='col-md-3'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yTempLow$yeastRows'>Low Temp</label>".
                      "<input id='yTempLow$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yTempLow$yeastRows' class='form-control' value='".$yeastArray[$yeastRows][1]."' placeholder='Yeast Low Temp'/>".
                    "</div>".
                    "<div class='col-md-3'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yTempHigh$yeastRows'>High Temp</label>".
                      "<input id='yTempHigh$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yTempHigh$yeastRows' class='form-control' value='".$yeastArray[$yeastRows][2]."' placeholder='Yeast High Temp'/>".
                    "</div>".
                    "</td></tr>";
                    //echo $yeastArray[$yeastRows][0]." : ".$yeastArray[$yeastRows][1]." : ".$yeastArray[$yeastRows][2]." : ".$yeastArray[$yeastRows][3]."<br/>";
                    $yeastRows++;
                  } else{
                    //populate with blank row
                    echo "<tr><td>".
                    "<div class='col-md-6'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yName$yeastRows'>Name</label>".
                      "<input id='yName$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yName$yeastRows' class='form-control' value='' placeholder='Name'/>".
                    "</div>".
                    "<div class='col-md-3'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yTempLow$yeastRows'>Low Temp</label>".
                      "<input id='yTempLow$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yTempLow$yeastRows' class='form-control' value='' placeholder='Yeast Low Temp'/>".
                    "</div>".
                    "<div class='col-md-3'>".
                      "<label class='hidden-lg hidden-md col-sm-4 col-xs-6' for='yTempHigh$yeastRows'>High Temp</label>".
                      "<input id='yTempHigh$yeastRows' class='col-lg-12 col-md-12 col-sm-8 col-xs-6' type='text' name='yTempHigh$yeastRows' class='form-control' value='' placeholder='Yeast High Temp'/>".
                    "</div>".
                    "</td></tr>";

                    //echo "blank row<br/>";
                    $yeastRows++;
                  }
                }
            echo "</tbody></table>";
            ?>
          </div>
          <div class='col-md-12'>
            <a class="btn btn-lg btn-primary btn-block" href="#" id="postLink">Post Data to Database</a>
            button goes here
          </div>
        </div>
      </div>
    </div>
    <?php

      //Close Connection
      $conn->close();
    ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <!--Highcharts-->
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/stock/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/modules/solid-gauge.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script text="text/javascript">
      //$('#iAction3').hide();

    </script>

  </body>
</html>
