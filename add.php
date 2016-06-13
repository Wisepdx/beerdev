<?php
  include("connect.php");

	//GET possible variables
	$postType=isset($_GET["postType"]);
  $batchId=isset($_GET["batchId"]);
  $batchName=isset($_GET["batchName"]);
  $batchSize=isset($_GET["batchSize"]);
  $targetTemp=isset($_GET["targetTemp"]);
  $currentTemp=isset($_GET["currentTemp"]);
  $ambientTemp=isset($_GET["ambientTemp"]);
  $peltStatus=isset($_GET["peltStatus"]);
  $tempDiff=isset($_GET["tempDiff"]);

  if ($postType == 1){
  //BATCH DATA POST
      echo "Post Type 1";
      //set date for input
      $batchDate = date('Y-m-d');
      //write data to the batch table
      $query = "INSERT INTO `batch` (`batchId`,`batchName`,`batchSize`,`batchDate`)
      VALUES ('".$batchId."','".$batchName."','".$batchSize."','".$batchDate."')";
	}elseif($postType == 2){
  //SENSOR DATA POST
      echo "Post Type 2";
      //write data to the sensor_data table
      $query = "INSERT INTO `sensor_data` (`batchId`,`targetTemp`, `currentTemp`,`ambientTemp`,`peltStatus`,`tempDiff`)
      VALUES ('".$batchId."','".$targetTemp."','".$currentTemp."', '".$ambientTemp."','".$peltStatus."','".$tempDiff."')";
   	}
	else{
	//give an error message that you are not writing to the database
      echo "InsertError | ";
	}

  if ($conn->query($query) === TRUE) {
    echo "New record created successfully";
  } else {
      echo "Error: " . $query . "<br>" . $conn->error;
  }
  $conn->close();
?>
