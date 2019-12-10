<?php

session_start();
  $servername = "localhost"; 
  $dbname = "ratnad01_spotify";
  $last = 100000; 
  // Create connection 
  $conn = new mysqli($servername,"root", "", $dbname); 
  //mysqli_select_db($conn,$dbname); 
   
  // Check connection 
  if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error); 
  }

$bar = $_POST['indate'];

  if ($bar) {
    $return = $_POST;
    $countryarray = array(
    "AU" => "australia",
    "BR" => "brazil",
    "CA" => "canada",
    "GB" => "inggris",
    "ID" => "indonesia",
    "JP" => "jepang",
    "MX" => "mexico",
    "SE" => "swedia",
    "TR" => "turkey",
    "US" => "amerika");

    foreach ($countryarray as $key => $value) {
      //echo "" . $key . " " . $value;
      // console_log("Indate", $_POST["indate"]);
      $country = $value;
      $result = $GLOBALS['conn']->query("SELECT title, artist FROM `$country` WHERE `position`=1 AND `date`='$bar' LIMIT 1"); 
      if ($result->num_rows > 0) { 
          // output data of each row 
          $iter = 0; 
          while($row = $result->fetch_assoc()) {
              $return += array($key => "".$row["artist"]." - ".$row["title"]);
          }
      }
    }

    if ($return != $_POST) {
      unset($return['indate']);
      $output = json_encode($return);
      echo $output;
    } else {
      $emptyarray = $_POST;
      $emptyarray += array("empty" => "no data");
      $output = json_encode($emptyarray);
      echo $output;
    }
  }

?>