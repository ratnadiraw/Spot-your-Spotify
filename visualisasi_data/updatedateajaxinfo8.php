<?php

  session_start();
  $servername = "localhost"; 
  $dbname = "ratnad01_spotify";
  $last = 100000; 
  // Create connection 
$conn = new mysqli($servername,"ratnad01_visdat", "pabuaran", $dbname);
  //mysqli_select_db($conn,$dbname); 
   
  // Check connection 
  if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error); 
  }
  //echo "Connected successfully";

  $bar = $_POST['indate'];
$map = $_POST['map'];

  if ($bar) {
        $save1 = array();
        $result = $conn->query("SELECT * FROM ".$map." WHERE position <= 20 AND date = '".$bar."'");
        if ($result->num_rows > 0) {
            // output data of each row
            $iter = 0;
//            while($row = $result->fetch_assoc()) {
//                $tooltip = '<div style="padding:5px 5px 5px 5px;"><h5>'.str_replace("'","\'",$row["title"]).'</h5><table> <tr> <td style="padding:5px 5px 5px 5px; margin-right: 5%">Duration</td> <td><b>'.
//                    ( $row["duration"]/1000).' s</b></td> </tr><tr> <td style="padding:5px 5px 5px 5px;">Tempo</td><td><b>'.
//                    $row["tempo"].
//                    ' BPM</b></td> </tr> </table></div>';
//                if ($iter = count($result)-1) {
//                    echo "{ \"" .( $row["duration"]/1000). "\", \"" . $row["tempo"]. "\", \"".$tooltip."\"} ";
//                } else {
//
//                    echo "{ \"" .( $row["duration"]/1000). "\", \"" . $row["tempo"]. "\", \"".$tooltip."\"}, ";
//                }
//                $iter++;
//                $bpm[] = $row["tempo"];
//                $duration[] = $row["duration"]/1000;
//                $energy[] = $row["energy"];
//                $danceability[] = $row["danceability"];
//                $save1[] = $row["song_id"];
                while($row = $result->fetch_assoc()) {
                    $resulta[]=array($row["energy"]);
                }

                echo $a=json_encode($resulta, JSON_NUMERIC_CHECK);
//            }
        } else {
            echo $bar;
        };

  }

?>