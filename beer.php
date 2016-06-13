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

                  echo
                  "<div class='page-header'>".
                  "<h1>".$bvName."</h1>".
                  "</div>";
              }
          } else {
              echo "<div class='alert alert-warning' role='alert'>Invalid Batch ID</div>";
          }
          ?>

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li role="presentation"><a href="#style" aria-controls="style" role="tab" data-toggle="tab">Style</a></li>
            <li role="presentation"><a href="#ingredients" aria-controls="ingredients" role="tab" data-toggle="tab">Ingredients</a></li>
            <li role="presentation" class="active"><a href="#charts" aria-controls="charts" role="tab" data-toggle="tab">Charts</a></li>
          </ul>
          <!-- Tab panes -->
          <div class="tab-content">

            <!-- Style Tab -->

            <div role="tabpanel" class="tab-pane" id="style">
              <p>This page contains data relating to the chosen batch. If this page is the current batch it will be generated with available data.</p>

              <?php
              //style data
              $styleSql = "SELECT * FROM style WHERE batchId = $BeerId";
              $styleResult = $conn->query($styleSql);
              $mashTime = 0;
              $boilTime = 0;

              if ($styleResult->num_rows > 0) {

                echo "<h3>Style</h3>
                <table class='table table-condensed table-hover table-striped'>
                  <thead>
                    <th>Style Name</th>
                    <th>Orig Gravity</th>
                    <th>Final Gravity</th>
                    <th>ABV</th>
                  </thead>";

                  // output data of each row
                  while($row = $styleResult->fetch_assoc()) {
                    $mashTime = $row["mashTime"];
                    $boilTime = $row["boilTime"];
                    echo "<tr>".
                      "<td>".$row["name"]."</td>".
                      "<td>".$row["oGravity"]."</td>".
                      "<td>".$row["fGravity"]."</td>".
                      "<td>".$row["abv"]." %</td>".
                      "</tr>";
                  }
                  echo "</table>";
              }
              ?>
              <h3>Style Details</h3>
              <table class='table table-condensed table-hover table-striped'>
                <thead>
                  <th>Batch Name</th>
                  <th>ID</th>
                  <th>Brew Date</th>
                  <th>Brew Size</th>
                  <th>Mash Time</th>
                  <th>Boil Time</th>
                </thead>
                <tr>
                  <td><?php echo $bvName; ?></td>
                  <td><?php echo $bvBatchId; ?></td>
                  <td>XXX<?php $bvBatchDate; ?></td>
                  <td><?php if ($bvBatchSize > 0){echo $bvBatchSize." Gallons";}else{} ?></td>
                  <td><?php if ($mashTime > 0){echo $mashTime." min";}else{} ?></td>
                  <td><?php if ($boilTime > 0){echo $boilTime." min";}else{} ?></td>
                </tr>
              </table>
            </div>

            <!--  Ingredients Tab -->

            <div role="tabpanel" class="tab-pane" id="ingredients">
              <?php
              //ferm data
              $fermSql = "SELECT * FROM fermentables WHERE batchId = $BeerId";
              $fermResult = $conn->query($fermSql);
              if ($fermResult->num_rows > 0) {

                echo "<h3>Fermentables</h3>
                <table class='table table-condensed table-hover table-striped'>
                  <thead>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>%</th>
                  </thead>";

                  // output data of each row
                  while($row = $fermResult->fetch_assoc()) {
                    $lbs = $row["pounds"];
                    $oz = $row["ounces"];
                    $pct = $row["percent"];
                    echo "<tr>".
                      "<td>".$row["name"]."</td>";
                    if (($lbs != null) || ($oz != null)){
                      echo "<td>".$lbs." lbs. ".$oz." oz.</td>";
                    } else{
                      echo "<td></td>";
                    }
                    if ($pct == 0){
                      echo "<td></td>";
                    }  else{
                      echo "<td>".$row["percent"]." </td>";
                    }
                    echo "</tr>";

                  }
                  echo "</table>";
              }
              ?>
              <?php
              //hop data
              $hopSql = "SELECT * FROM hops WHERE batchId = $BeerId ORDER BY minutes DESC";
              $hopResult = $conn->query($hopSql);
              if ($hopResult->num_rows > 0) {

                echo "<h3>Hops</h3>
                <table class='table table-condensed table-hover table-striped'>
                  <thead>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Time</th>
                    <th>Use</th>
                    <th>Form</th>
                    <th>Alpha %</th>
                  </thead>";

                  // output data of each row
                  while($row = $hopResult->fetch_assoc()) {
                    $oz = $row["ounces"];
                    $min = $row["minutes"];
                    $aa = $row["alphaAcid"];
                    echo "<tr>".
                      "<td>".$row["name"]."</td>";
                    if ($oz != null){
                      echo "<td>".$oz." oz.</td>";
                    } else{
                      echo "<td></td>";
                    }
                    if ($min != null){
                      echo "<td>".$min." min.</td>";
                    } else{
                      echo "<td></td>";
                    }
                    echo "<td>".$row["usedFor"]."</td>";
                    echo "<td>".$row["form"]."</td>";

                    if ($aa == 0){
                      echo "<td></td>";
                    }  else{
                      echo "<td>".$aa." %</td>";
                    }
                    echo "</tr>";

                  }
                  echo "</table>";
              }
              ?>
              <?php
              //yeast data
              $yeastSql = "SELECT * FROM yeast WHERE batchId = $BeerId";
              $yeastResult = $conn->query($yeastSql);
              if ($yeastResult->num_rows > 0) {

                echo "<h3>Yeast</h3>
                <table class='table table-condensed table-hover table-striped'>
                  <thead>
                    <th>Name</th>
                    <th>Temp Range</th>
                  </thead>";

                  // output data of each row
                  while($row = $yeastResult->fetch_assoc()) {
                    echo "<tr>".
                      "<td>".$row["name"]."</td>";
                    echo "<td>".$row["tempLow"]." - ".$row["tempHigh"]."</td>";
                    echo "</tr>";

                  }
                  echo "</table>";
              }
              ?>
            </div>

            <!-- Charts Tab -->

            <div role="tabpanel" class="tab-pane active" id="charts">
              <div class='col-md-12'>
                <h3>Temp History Chart</h3>
                <div id="TempContainer" style="min-width: 310px; margin: 0 auto"></div>
                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#TempModal">Open Table Data</button>
                <!-- Modal -->
                <div class="modal fade" id="TempModal" role="dialog">
                  <div class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Temperature Data</h4>
                      </div>
                      <div class="modal-body">
                        <table id='TempData' class='table table-condensed table-hover table-striped'>
                          <?php
                            //Arrays for Chart
                            $tempArray = array();
                            $currentArray = array();
                            $ambientArray = array();

                            //Vars for charts
                            $numOverTarget = 0;
                            $numUnderTarget = 0;
                            $numInTarget = 0;
                            $numTotal = 0;

                            $peltHeat = 0;
                            $peltCool = 0;
                            $peltOff = 0;

                            $highAmbient = 0.00;
                            $lowAmbient = 100.00;
                            $highCurrent = 0.00;
                            $lowCurrent = 100.00;

                            $startDate;
                            $endDate;

                            //Table of Sensor data (temp)
                            $sensorSql = "SELECT * FROM sensor_data where batchId = $BeerId ORDER BY timeStamp ASC";
                            $sensorResult = $conn->query($sensorSql);
                            if ($sensorResult->num_rows > 0) {
                                echo "<thead><tr><th>Time Stamp</th>
                                          <th>Current Temp</th>
                                          <th>Ambient Temp</th>
                                          <th>Target Temp</th>
                                          </tr></thead>";

                                // output data of each row
                                while($row = $sensorResult->fetch_assoc()) {
                                    //convert string to time
                                    $dt = strtotime($row["timeStamp"]);
                                    //convert to milliseconds
                                    $dt = $dt*1000;
                                    //set tempDiff to var
                                    $td = $row["tempDiff"];
                                    //set targetTemp to var
                                    $tt = $row["targetTemp"];
                                    $tth = $tt+$td;
                                    $ttl = $tt-$td;
                                    //set currentTemp to var
                                    $ct = $row["currentTemp"];
                                    //set ambientTemp to var
                                    $at = $row["ambientTemp"];
                                    //set Pelt Status to var
                                    $peltStat = $row["peltStatus"];

                                    //set date range
                                    if($startDate == null){
                                      $startDate = date("F j, Y, g:i a",($dt/1000));
                                    } else {
                                      $endDate = date("F j, Y, g:i a",($dt/1000));
                                    }

                                    // Add to Arrays
                                    $tempArray[] = array($dt,$ttl,$tth);
                                    $currentArray[] = array($dt,floatval($ct));
                                    $ambientArray[] = array($dt,floatval($at));

                                    // Increment Pelt Counts
                                    if ($peltStat > 0){
                                      if ($peltStat = 1){
                                        $peltCool++;
                                      } else {
                                        $peltHeat++;
                                      }
                                    }else{
                                      $peltOff++;
                                    }

                                    // Increment Over/Under/In Target Range Counts
                                    if (($ct <= $tth) && ($ct >= $ttl)){
                                      $numInTarget++;
                                    } else if ($ct > $tth){
                                      $numOverTarget++;
                                    } else if ($ct < $ttl){
                                      $numUnderTarget++;
                                    }

                                    // Increment Total row count
                                    $numTotal++;

                                    // Check/Set Stat Vars
                                    if ($ct > $highCurrent){$highCurrent = $ct;}
                                    if ($ct < $lowCurrent){$lowCurrent = $ct;}
                                    if ($at > $highAmbient){$highAmbient = $at;}
                                    if ($at < $lowAmbient){$lowAmbient = $at;}

                                    // write out table row
                                    echo "<tr>".
                                      "<td>".date("F j, Y, g:i a",($dt/1000))."</td>".
                                      "<td>". $ct."</td>".
                                      "<td>". $at."</td>".
                                      "<td>". $tt."</td>".
                                      "</tr>";
                                }
                                echo "<table id='Pelt' class='table table-condensed table-hover table-striped'>";
                                echo "<thead><tr><th>Name</th><th>Cool</th><th>Off</th><th>Heat</th></thead>";
                                echo "<tr><td>Pelt Status</td><td>".$peltCool."</td><td>".$peltOff."</td><td>".$peltHeat."</td></tr></table>";
                                echo "<br>";
                                echo "<table id='Target' class='table table-condensed table-hover table-striped'>";
                                echo "<thead><tr><th>Total</th><th>Over Target</th><th>On Target</th><th>Under Target</th></thead>";
                                echo "<tr><td>".$numTotal."</td><td>".$numOverTarget."</td><td>".$numInTarget."</td><td>".$numUnderTarget."</td></tr></table>";
                            } else {
                                echo "No sensor data available";
                            }
                          ?>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!--End of Modal-->
              </div>
              <div class='col-md-4'>
                <h3>Heat/Cool Frequency</h3>
                <div id="PeltPie" style="height: 200px; margin: 0 auto"></div>
              </div>
              <div class='col-md-4'>
                <h3>Temperature Stability</h3>
                <div id="TempStab" style="height: 200px;margin: 0 auto"></div>
              </div>
              <div class='col-md-4'>
                <h3>Statistics</h3>
                <div class='row'>
                  <div class='col-md-12'>
                    <table class='table table-condensed table-striped'>
                      <tr><td>Start Date</td><td><?php echo $startDate; ?></td></tr>
                      <tr><td>End Date</td><td><?php echo $endDate; ?></td></tr>
                      <tr><td>Highest Ambient Temp</td><td><?php echo $highAmbient; ?></td></tr>
                      <tr><td>Lowest Ambient Temp</td><td><?php echo $lowAmbient; ?></td></tr>
                      <tr><td>Highest Current Temp</td><td><?php echo $highCurrent; ?></td></tr>
                      <tr><td>Lowest Current Temp</td><td><?php echo $lowCurrent; ?></td></tr>
                    </table>
                  </div>
                </div>
              </div>
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

    <!-- Chart Script:   table-->
    <script type='text/javascript'>//<![CDATA[
      $(function () {
          //$('#TempContainer').highcharts({
          $('#TempContainer').highcharts('StockChart',{
            chart: {
              //type: 'arearange'
          },
          rangeSelector: {
              buttons: [{
                  type: 'hour',
                  count: 1,
                  text: '1h'
              }, {
                  type: 'day',
                  count: 1,
                  text: '1d'
              }, {
                  type: 'day',
                  count: 2,
                  text: '2d'
              }, {
                  type: 'day',
                  count: 3,
                  text: '3d'
              }, {
                  type: 'all',
                  count: 1,
                  text: 'All'
              }],
              selected: 4,
              inputEnabled: false
          },
          credits: {
              enabled: false
          },
          title: {
              text: ''
          },

          tooltip: {
              valueSuffix: '°F'
          },
          xAxis: {
              gapGridLineWidth: 0
          },
          yAxis: {
            gridLineColor: '#ECECEC',
            minorGridLineColor: '#FAFAFA',
            minorTickInterval: 'auto',
            height: '100%',
            offset: 0,
            title:{
              text: 'Temperature'
            }
          },
          series: [
          {
              name: 'Target Temp Range',
              type: 'arearange',
              data: <?php echo json_encode($tempArray); ?>
          },
          {
              name: 'Current Temp',
              type: 'line',
              data: <?php echo json_encode($currentArray); ?>
          },
          {
              name: 'Ambient Temp',
              type: 'line',
              data: <?php echo json_encode($ambientArray); ?>
          }
          ]
          });
      });
      //]]>
    </script>
    <script>
      $(function () {
        Highcharts.setOptions({
            colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
        });

        $('#PeltPie').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            credits: {
                  enabled: false
              },
            data: {
              table: 'Pelt',
              switchRowsAndColumns: true
              //,endRow: 1
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
        });
      });
    </script>
    <script>
      $(function () {

        Highcharts.chart('TempStab', {
          chart: {
              type: 'column'
          },
          title:{text: ''},
          xAxis: {
              categories: [
                  'Temperature'
              ],
              crosshair: true
          },
          credits: {
                enabled: false
            },
          yAxis: {
              min: 0,
              max: 100,
              title: {
                  text: 'Percentage'
              }
          },
          tooltip: {
              headerFormat: '<span style="font-size:10px; font-weight: bold;">{point.key}</span><table>',
              pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                  '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
              footerFormat: '</table>',
              shared: true,
              useHTML: true
          },
          plotOptions: {
              column: {
                  pointPadding: 0.2,
                  borderWidth: 0
              }
          },
          series: [{
              name: 'Under',
              data: [<?php echo round($numUnderTarget/$numTotal*100); ?>]
              //data: [<?php echo $numUnderTarget; ?>]

          }, {
              name: 'In Range',
              data: [<?php echo round($numInTarget/$numTotal*100); ?>]
              //data: [<?php echo $numInTarget; ?>]

          },{
              name: 'Over',
              data: [<?php echo round($numOverTarget/$numTotal*100); ?>]
              //data: [<?php echo $numOverTarget; ?>]

          }]
        });
      });
    </script>


  </body>
</html>
