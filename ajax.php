<?php
  include("connect.php");

  $table = isset($_POST['table']);
  $action = isset($_POST['action']);
  $batchId = isset($_POST['batchId']);

  echo $table."<br/>";

  // $batchId = $_POST['batchId'];
  // $name = $_POST['name'];
  // $pounds = $_POST['pounds'];
  // $ounces = $_POST['ounces'];
  // $percent = $_POST['percentage'];

  // $query = "INSERT INTO fermentables (batchId,name,pounds,ounces,percent)
  // VALUES (".$batchId.",'".$name."',".$pounds.",".$ounces.",".$percent.");";


	if ($table == 'fermentTable'){
    $batchId = $_POST['batchId'];
    $name = $_POST['name'];
    $pounds = $_POST['pounds'];
    $ounces = $_POST['ounces'];
    $percent = $_POST['percentage'];

    if($action == 'add'){
      $query = "INSERT INTO fermentables (batchId,name,pounds,ounces,percent)
      VALUES (".$batchId.",'".$name."',".$pounds.",".$ounces.",".$percent.");";
    } else if ($action == 'update'){
      echo "action update <br/>";

    } else if ($action == 'delete'){
      echo "action delete <br/>";
    }
  }
	else{
	//give an error message that you are not writing to the database
      echo "Danger! Danger! unknown add will robinson <br/>";
	}

  if ($conn->query($query) === TRUE) {
    echo "successfully input into database";
  } else {
      echo "Well shit :/ <br/>" . $query . "<br>" . $conn->error;
  }
  $conn->close();
?>
