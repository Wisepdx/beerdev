<?php
   	include("connect.php");

   	//?? $link=Connection();

	//possible variables from POST
	$postType=$_POST["postType"];
	$batchId=$_POST["batchId"];
	$batchName=$_POST["batchName"];
	$batchSize=$_POST["batchSize"];
	$targetTemp=$_POST["targetTemp"];
	$currentTemp=$_POST["currentTemp"];
	$ambientTemp=$_POST["ambientTemp"];
	$peltStatus=$_POST["peltStatus"];
	$tempDiff=$_POST["tempDiff"];


	if ($postType == 1){
      echo "Post Type 1";
      //write data to the batch table
      $query = "INSERT INTO `batch` (`batchId`,`batchName`,`batchSize`)
      VALUES ('".$batchId."','".$batchName."','".$batchSize."')";
	}elseif($postType == 2){
      echo "Post Type 2";
      //write data to the sensor_data table
      $query = "INSERT INTO `sensor_data` (`batchId`,`targetTemp`, `currentTemp`,`ambientTemp`,`peltStatus`,`tempDiff`)
      VALUES ('".$batchId."','".$targetTemp."','".$currentTemp."', '".$ambientTemp."','".$peltStatus."','".$tempDiff."')";
   	}
	else{
	//give an error message that you are not writing to the database
      echo "error";
	}

   	mysql_query($query,$link);
	mysql_close($link);

   	header("Location: index.php");
?>
