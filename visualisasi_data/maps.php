<head>
    <title>Spot your Spotify</title>
</head>
<?php

  function console_log( $data ){
      echo '<script>';
      echo 'console.log('. json_encode( $data ) .')';
      echo '</script>';
    }

$servername = "localhost";
$dbname = "ratnad01_spotify";
$last = 100000;
// Create connection
$conn = new mysqli($servername,"ratnad01_visdat", "visdat", $dbname); 
  //mysqli_select_db($conn,$dbname); 
   
  // Check connection 
  if ($conn->connect_error) { 
      die("Connection failed: " . $conn->connect_error); 
  } 
  //echo "Connected successfully";
  $date = '2018-05-04'; //masih dummy krn di sql ga ada, harusnya pake current date --> $date = date("Y-m-d");

  function getTrendData($indate) {
    $trendarray = array();
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
      $country = $value;
      $result = $GLOBALS['conn']->query("SELECT title, artist FROM `$country` WHERE `position`=1 AND `date`='$indate' LIMIT 1"); 
      if ($result->num_rows > 0) { 
          // output data of each row 
          $iter = 0; 
          while($row = $result->fetch_assoc()) {
              $trendarray += array($key => "".utf8_encode ($row["artist"])." - ".utf8_encode ($row["title"]));
          } 
        }
    }

    return $trendarray;
  }

  $trendingdata = getTrendData($date);

?>

<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
<link href="Datedropper3-master/datedropper.min.css" rel="stylesheet">
<link href="maps-page.css" rel="stylesheet">
<link href="dist/semantic.css" media="all" rel="Stylesheet" type="text/css" />
<link href="dist/components/modal.css" media="all" rel="Stylesheet" type="text/css" />
<link href="dist/components/popup.css" media="all" rel="Stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400" rel="stylesheet">

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="dist/semantic.js"></script>
<script src="dist/components/modal.js"></script>
<script src="dist/components/popup.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>-->
<script src="Datedropper3-master/datedropper.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<script>

</script>
<style>
    [data-tooltip]::after{
        max-width: 360px;
        white-space: normal;
    }
    svg>g>g>g>g>rect[stroke="#ffffff"][stroke-width="1"] {
      stroke: white !important;
      stroke-width: 2.5px !important;
    }
    .ui.modal > .header{
        font-family: 'Montserrat', sans-serif;
        font-style: normal;
        font-weight: 400;
        background-color: #191414 !important;
        color: #1db954 !important;
    }

    .ui.modal > .content{
        font-family: 'Montserrat', sans-serif;
        font-style: normal;
        font-weight: 400;
        background-color: #191414 !important;
        color: #1db954 !important;
    }
</style>
<div class="ui fullscreen modal test">
    <i class="close icon"></i>
    <div class="header">
        <h1 id="countrypopup">
            <div class="ui mini image" style="margin-right: 1%">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Spotify_logo_without_text.svg/2000px-Spotify_logo_without_text.svg.png" alt="Spotify Logo">
            </div>
            Indonesia Spotify Chart - </h1>
            <h3 style="margin-top:-5px;">Click song's chart for detail</h3>
    </div>
    <div class="image content" style="padding-left: 3px; padding-top:0">

        <!--<div class="ui medium image">-->
        <div id="chart_div" style="height: 500px; width: 500px"></div>
        <!--</div>-->
        <div class="description"  style="margin-left: 2%">
            <div class="ui two column grid">
                <div class="stretched row">
                    <div class="column" style="width: 370px; padding-left: 0">
                        <!--<div class="ui segment" style="height: 100px">-->
                        <iframe src="https://open.spotify.com/embed/track/7KXjTSCq5nL1LoYtL7XAwS" width="100%" height="90" frameborder="0" allowtransparency="true" id="songplayer"></iframe>
                        <!--</div>-->
                        <div class="ui segment" style="height: 360px; margin-top:30px";>
                            <div class="ui icon" data-tooltip="Song with low duration tend to have fast tempo. Conversely, long duration song usually have slow tempo" style="margin-bottom: 0; text-align: right">
                                What is this?
                            </div>
                            <h3 style="margin-top: 0">Tempo and Duration</h3>
                            <div id="chart_div_2" style=" height:280px"></div>
                        </div>
                    </div>
                    <script>
                        $('.ui .icon').popup({
                            on:'click'
                        });
                    </script>
                    <style>
                        .tooltip-inner {
                            max-width: 350px;
                            /* If max-width does not work, try using width instead */
                            width: 350px;
                        }
                    </style>
                    <div class="column" style="width: 370px; padding-left: 0">
                        <div class="ui basic segment" style="height: 60px">
                            <!--                            <b><h3 id="artist" style="color:#fff; margin-top: -3.5%">Artist : </h3></b>-->
                            <h2 style="margin-top: -5%">
                                <div class="ui four column grid" style="margin-left: 2.5%; margin-right: 2.5%; margin-top: 0%">
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Tempo" style="margin-bottom: 0;">
                                            <i class="heartbeat icon"></i>
                                        </div>
                                        <h4 id="beat" style="margin-top: 0%; text-align: center">100 BPM</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Duration" style="margin-bottom: 0;">
                                            <i class="hourglass start icon"></i>
                                        </div>
                                        <h4 id="dur" style="margin-top: 0%; text-align: center">100 sec</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Energy" style="margin-bottom: 0;">
                                            <i class="battery three quarters icon"></i>
                                        </div>
                                        <h4 id="ener" style="margin-top: 0%; text-align: center">20</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Danceability" style="margin-bottom: 0;">
                                            <i class="grav icon"></i>
                                        </div>
                                        <h4 id="dance" style="margin-top: 0%; text-align: center">0.67</h4>
                                    </div>
                                </div>

                            </h2>
                            <!--                            <h2 style="margin-top: 0%"><i class="heartbeat icon"></i>-->
                            <!--                                <i class="hourglass start icon"></i>-->
                            <!--                                <i class="battery three quarters icon"></i>-->
                            <!--                                <i class="grav icon"></i>-->
                            <!--                            </h2>-->
                        </div>
                        <div class="ui segment" style="height: 360px; margin-top:45px";>
                            <div class="ui icon" data-tooltip="People tend to dance with song that have high energy which is loud, noisy, have high intensity" style="margin-bottom: 0; text-align: right">
                                What is this?
                            </div>
                            <h3 style="margin-top: 0">Energy and Danceability</h3>
                            <div id="chart_div_3" style=" height:280px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var indate1 = '2018-05-04'; //tanggal baru
    d = new Date("2018","05", "04");
    $tes = 1;
    $on = 1;
    var chart1;
    var d;
    var chart2;
    var testinginput1 = [];
    var testinginput2 = [];
    var testinginput3 = [];
    var saveSong =[];
    var saveBpm = [];
    var saveDur = [];
    var saveEner = [];
    var saveDance = [];
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            if ($on<= 0){

                var data = google.visualization.arrayToDataTable([
                    ['Duration', 'Tempo', {type: 'string' , role: 'tooltip', 'p': {'html': true}}],
                    <?php
                    $save1 = array();
                    $bpm = array();
                    $duration = array();
                    $energy = array();
                    $danceability = array();
                    $result = $conn->query("SELECT * FROM indonesia WHERE position <= 20 AND date = '2018-05-04'");
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $iter = 0;
                        while($row = $result->fetch_assoc()) {
                            $tooltip = '<div style="padding:5px 5px 5px 5px;"><h5>'.str_replace("'","\'",$row["title"]).'</h5><table> <tr> <td style="padding:5px 5px 5px 5px; margin-right: 5%">Duration</td> <td><b>'.
                                ( $row["duration"]/1000).' s</b></td> </tr><tr> <td style="padding:5px 5px 5px 5px;">Tempo</td><td><b>'.
                                $row["tempo"].
                                ' BPM</b></td> </tr> </table></div>';
                            if ($iter = count($result)-1) {
                                echo "[" .( $row["duration"]/1000). ", " . $row["tempo"]. ", '".$tooltip."'] ";
                            } else {

                                echo "[ " .( $row["duration"]/1000). ", " . $row["tempo"]. ", '".$tooltip."'], ";
                            }
                            $iter++;
                            $bpm[] = $row["tempo"];
                            $duration[] = $row["duration"]/1000;
                            $energy[] = $row["energy"];
                            $danceability[] = $row["danceability"];
                            $save1[] = $row["song_id"];
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                ]);
            } else {
//                var data = google.visualization.arrayToDataTable([
//                    ['Duration', 'Tempo', {type: 'string' , role: 'tooltip', 'p': {'html': true}}],
//                    testinginput1
//                ]);
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Duration');
                data.addColumn('number', 'Tempo');
                data.addColumn({type: 'string' , role: 'tooltip', 'p': {'html': true}});

                data.addRows(testinginput1);
                
            }

            var options = {
                title: 'Duration - Tempo',
                chartArea: {left:40, bottom: 40, top: 10, right: 10, width: '100%', height:'100%'},
                annotations: {
                    textStyle: {
                        // The color of the text.
                        color: 'white'
                    }
                },
                colors: ['#1db954'],
                height: '280',
//                width: '350',

                hAxis: {title: 'Duration',
                    showTextEvery: 0, slantedText: true, slantedTextAngle: 90, viewWindow:{min:0}
//                    viewWindowMode:'explicit',
//                    viewWindow: {
//
//                        min: 0,
//                        max : <?php //echo $last ?>
//                    }
                },
                vAxis: {title: 'Tempo',
                    minValue:0
//                    viewWindowMode:'explicit',
//                    viewWindow: {
//
//                        min: 0,
//                        max : <?php //echo $last ?>
//                    }
                },

                bar: {groupWidth: "10%"},
                legend: 'none',
                tooltip: { isHtml: true }
            };
            
            chart1 = new google.visualization.ScatterChart(document.getElementById('chart_div_2'));
            google.visualization.events.addListener(chart1, 'select', function() {
                chart.setSelection(chart1.getSelection());
                chart2.setSelection(chart1.getSelection());

                document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[chart1.getSelection()[0]["row"]];
                document.getElementById("beat").innerHTML = saveBpm[chart1.getSelection()[0]["row"]]+' BPM';
                document.getElementById("dur").innerHTML = saveDur[chart1.getSelection()[0]["row"]]+' s';
                document.getElementById("ener").innerHTML = saveEner[chart1.getSelection()[0]["row"]];
                document.getElementById("dance").innerHTML = saveDance[chart1.getSelection()[0]["row"]];
//                document.getElementById("artist").innerHTML = "Artist : "+ saveArtist[chart.getSelection()[0]["row"]];
                //                alert('The user selected ' + chart1.getSelection()[0]["column"] + chart1.getSelection()[0]["row"]);
            });
            chart1.draw(data, options);

        }

        google.charts.setOnLoadCallback(drawChart2);

            function drawChart2() {
            if ($on<=0){
                var data = google.visualization.arrayToDataTable([
                    ['Danceability', 'Energy', {type: 'string' , role: 'tooltip', 'p': {'html': true}}],
                    <?php

                    $save2 = array();
                    $bpm = array();
                    $duration = array();
                    $energy = array();
                    $danceability = array();
                    $result = $conn->query("SELECT * FROM indonesia WHERE position <= 20 AND date = '2018-05-04'");
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $iter = 0;
                        while($row = $result->fetch_assoc()) {
                            $tooltip = '<div style="padding:5px 5px 5px 5px;"><h5>'.str_replace("'","\'",$row["title"]).'</h5><table> <tr> <td style="padding:5px 5px 5px 5px; margin-right: 5%">Danceability</td> <td><b>'.
                                $row["danceability"].'</b></td> </tr><tr> <td style="padding:5px 5px 5px 5px;">Energy</td><td><b>'.
                                $row["energy"].
                                '</b></td> </tr> </table></div>';
                            if ($iter = count($result)-1) {
                                echo "[ " .( $row["danceability"]). ", " . $row["energy"]. ", '".$tooltip."'] ";
                            } else {

                                echo "[" .( $row["danceability"]). ", " . $row["energy"]. ", '".$tooltip."'], ";
                            }
                            $iter++;
                            $bpm[] = $row["tempo"];
                            $duration[] = $row["duration"]/1000;
                            $energy[] = $row["energy"];
                            $danceability[] = $row["danceability"];
                            $save2[] = $row["song_id"];
                        }

                    } else {
                        echo "0 results";
                    }
                    ?>
                ]);
            } else  {
                var data = new google.visualization.DataTable();
                data.addColumn('number', 'Danceability');
                data.addColumn('number', 'Energy');
                data.addColumn({type: 'string' , role: 'tooltip', 'p': {'html': true}});

                data.addRows(testinginput2);
            }

            var options = {
                title: 'Danceability - Energy',
                chartArea: {left:40, bottom: 40, top: 10,  right: 10, width: '100%', height:'100%'},
                annotations: {
                    textStyle: {
                        // The color of the text.
                        color: 'white'
                    }
                },
                colors: ['#1db954'],
                height: '280',
//                width: '350',
                hAxis: {title: 'Danceability',

                    showTextEvery: 0, slantedText: true, slantedTextAngle: 90, viewWindow:{min:0}

//                    viewWindowMode:'explicit',
//                    viewWindow: {
//
//                        min: 0,
//                        max : <?php //echo $last ?>
//                    }
                },
                vAxis: {title: 'Energy',
                    minValue:0
//                    viewWindowMode:'explicit',
//                    viewWindow: {
//                    min:0
////
////                        min: 0,
////                        max : <?php ////echo $last ?>
//                    }

                },

                legend: 'none',
                tooltip: { isHtml: true }
            };

            chart2 = new google.visualization.ScatterChart(document.getElementById('chart_div_3'));
            google.visualization.events.addListener(chart2, 'select', function() {
                chart.setSelection(chart2.getSelection());
                chart1.setSelection(chart2.getSelection());

                document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[chart2.getSelection()[0]["row"]];
                document.getElementById("beat").innerHTML = saveBpm[chart2.getSelection()[0]["row"]]+' BPM';
                document.getElementById("dur").innerHTML = saveDur[chart2.getSelection()[0]["row"]]+' s';
                document.getElementById("ener").innerHTML = saveEner[chart2.getSelection()[0]["row"]];
                document.getElementById("dance").innerHTML = saveDance[chart2.getSelection()[0]["row"]];
//                alert('The user selected ' + chart1.getSelection()[0]["column"] + chart1.getSelection()[0]["row"]);
            });
            chart2.draw(data, options);
        }

        if ($on<=0){
            var data = google.visualization.arrayToDataTable([
                ['Song Title', 'Number Stream'],
                <?php
                $save = array();
                $bpm = array();
                $duration = array();
                $energy = array();
                $danceability = array();
                $result = $conn->query("SELECT * FROM indonesia WHERE position <= 20 AND date = '2018-05-04'");
                if ($result->num_rows > 0) {
                    // output data of each row
                    $iter = 0;
                    while($row = $result->fetch_assoc()) {
                        if ($iter = count($result)-1) {

                            echo "[' " . str_replace("'","\'",$row["title"]). "', " . $row["num_stream"]. ",] ";
                        } else {
                            echo "[' " . str_replace("'","\'",$row["title"]). "', " . $row["num_stream"]. ",], ";
                        }
                        if ($last < $row["num_stream"]) {
                            $last = $row["num_stream"];
                        }
                        $save[] = $row["song_id"];
                        $bpm[] = $row["tempo"];
                        $duration[] = $row["duration"]/1000;
                        $energy[] = $row["energy"];
                        $danceability[] = $row["danceability"];
                        $iter++;
                    }
                } else {
                    echo "0 results";
                }
                ?>
            ]);
        } else  {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Song Title');
            data.addColumn('number', 'Number Stream');
            data.addRows(testinginput3);
        }

        var options = {
            title: 'Population of Largest U.S. Cities',
            chartArea: {left: 200, width: '100%', height:'100%'},
            hAxis: {
                viewWindowMode:'explicit',
                viewWindow: {

                    min: 0
                }
                // title: 'Total Population',
            },
            vAxis: {

                textStyle:{color: '#FFF'}
            },
            annotations: {
                textStyle: {
                    // The color of the text.
                    color: 'white'
                }
            },
            colors: ['#1db954'],
            height: '500',
            width: '500',
            backgroundColor: 'transparent',
            legend: { position: "none" }
        };

document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[0];
                document.getElementById("beat").innerHTML = saveBpm[0]+' BPM';
                document.getElementById("dur").innerHTML = saveDur[0]+' s';
                document.getElementById("ener").innerHTML = saveEner[0];
                document.getElementById("dance").innerHTML = saveDance[0];
        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        google.visualization.events.addListener(chart, 'select', function() {

            document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[chart.getSelection()[0]["row"]];
            document.getElementById("beat").innerHTML = saveBpm[chart.getSelection()[0]["row"]]+' BPM';
            document.getElementById("dur").innerHTML = saveDur[chart.getSelection()[0]["row"]]+' s';
            document.getElementById("ener").innerHTML = saveEner[chart.getSelection()[0]["row"]];
            document.getElementById("dance").innerHTML = saveDance[chart.getSelection()[0]["row"]];
//            $on++;
            drawChart1();
            drawChart2();
            chart1.setSelection(chart.getSelection());
            chart2.setSelection(chart.getSelection());
//            alert('The user selected ' + chart.getSelection()[0]["column"] + chart.getSelection()[0]["row"]);
        });
        chart.draw(data, options);
    }
    $(function(){
//        $("#test").click(function(){
//            drawBasic();
//            $tes++;
//            $(".test").modal('show');
//        });
        $(".test").modal({

            blurring: true,
            closable: true
        });
    });
</script>
<!-- HTML -->
<div id="container">
  <div style="display: flex; align-items: center; justify-content: center;">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Spotify_logo_without_text.svg/2000px-Spotify_logo_without_text.svg.png" alt="Spotify Logo" width="4%">
    <p style="font-weight: bold; font-size: 40px; margin-left: 20px; color: #1ED760">Spot Your Spotify</p>
  </div>
  <div id="pickdate">
<!--    <h2>Spotify's #1 Around The Globe</h2>-->
    <div style="display: flex; align-items: center; margin-top: 0.5%; margin-bottom: 0.5%">
     <h2 style="margin-bottom: 0">Pick date</h2>
     <input type="text" height="0%" id="trenddate" data-large-mode="true" data-lock="to" name="indate"/>
   </div>
  </div>
  <div id="chartdiv"></div>
  <div id="maphistory" style="margin-top:0"></div>
</div>

<script>

var testinginput ={};
var onn = 0;

var mapData = {};

function getKeyExisted(object, value) {
  for(var key in object) {
    //console.log(object[key], value);
    if (object[key][0] == value) return key;
  }
}

function getSongAndColor(object) {
  var history = {};
  console.log("GETSONGCOLOR HISTORY AWAL", history);
  console.log("GETSONGCOLOR MAPDATA", object);
  for(var key in object) {
    console.log("GETSONGCOLOR OBJECT[KEY]", object[key]);
    var song = object[key][0];
    if (!(history[song])) {
      console.log("TAMBAHIN LEGEND");
      history[song] = object[key][1];
    }
  }
  console.log("history", history);
  return history; //history maksudnya legend
}
var historyData;
//Print legend (salah inget 'legend' jadi 'history', maaf namanya jad aneh)
function getMapHistory() {
  var mapHistoryToWrite = "";
  console.log("MASUK BIKIN LEGEND", mapHistoryToWrite);
  console.log("MAP DATA BIKIN LEGEND", mapData);
  var i = 0;
  historyData = getSongAndColor(mapData);
  var countryName = ["ID","AU","BR","CA","GB","JP","MX","SE","TR","US"];
  mapHistoryToWrite += '<div id="maphistory" style="margin-top:0">';

  for (key in historyData) {
    if (historyData.hasOwnProperty(key)) {
      if (i === 0) {
        mapHistoryToWrite += '<div style="display: table-row;">'
      }
      testingg = [];
      for (key1 in mapData) {
          if(mapData[key1][1]==historyData[key]){
              testingg.push(key1);
          }
      }
      console.log(testingg);
      mapHistoryToWrite += '<div style="display: table-cell;">\
          <div class="historyItem" onmouseover="bigImg(this)" onmouseout="normalImg(this)" tes='+ testingg+' id='+String(historyData[key]).substring(1) +'>\
            <div class="historyColor" style="background-color:' + historyData[key] + '"></div>\
            <p class="historyFont" style="margin-top:0">' + key + '</p>\
          </div>\
        </div>'
      if (i === 2) {
        mapHistoryToWrite += '</div>'
        i = 0;
      } else {
        i++;
      }
    }
  }
  mapHistoryToWrite += '</div>';

  return mapHistoryToWrite;
}
//change hovernya disini

function bigImg(x) {
    a = x.getAttribute("tes");
    console.log(x.getAttribute("tes"));
    if (a.indexOf(",")==-1) {
        var x = document.getElementsByClassName("amcharts-map-area-"+a)
          x[0].setAttribute("fill-opacity", 0.8);
          x[0].setAttribute("stroke", "#0000");
    } else {
        var res = a.split(",");
        var i;
        for (i = 0; i < res.length; i++) { 
          var x = document.getElementsByClassName("amcharts-map-area-"+res[i])
          x[0].setAttribute("fill-opacity", 0.8);
          x[0].setAttribute("stroke", "#0000");
        }
    }
}

function normalImg(x) {
    a = x.getAttribute("tes");
    console.log(x.getAttribute("tes"));
    if (a.indexOf(",")==-1) {
        var x = document.getElementsByClassName("amcharts-map-area-"+a)
          x[0].setAttribute("fill-opacity", 1);
          x[0].setAttribute("stroke", "#ffff");
    } else {
        var res = a.split(",");
        var i;
        for (i = 0; i < res.length; i++) { 
          var x = document.getElementsByClassName("amcharts-map-area-"+res[i])
          x[0].setAttribute("fill-opacity", 1);
          x[0].setAttribute("stroke", "#ffff");
        }
    }
}

var colorList;
function drawMap() {
  colorList = [
    "#8dd3c7",
    "#fb8072",
    "#80b1d3",
    "#fdb462",
    "#b3de69",
    "#fccde5",
    "#bc80bd",
    "#bebada",
    "#ffffb3",
    "#d9d9d9"];

  // var firstData = {
  //   "AU": "as long as u love me",
  //   "BR": "memelord",
  //   "CA": "CA",
  //   "GB": "Great Britain",
  //   "ID": "Indonesia",
  //   "JP": "Japan",
  //   "MX": "asjdkasdhjksa sjdaks",
  //   "SE": "SEEEEEE",
  //   "TR": "Turkey",
  //   "US": "United States",
  //   "ZA": "South Africaaaaaa!"
  // }

  mapData = {};
  var firstData = {}; //bentuknya sama kyk firsdata yg dikomen
  console.log("DRAWMAP", firstData);

    var phparray;
    if (onn === 0){
        phparray = <?php echo json_encode($trendingdata) ?>;
        console.log("ONN AWAL", onn, phparray);
    } else {
        phparray = testinginput;
        console.log("ONN GANTI", onn, phparray);
    }
  $.each(phparray, function(key, value) { //isi firstdata dari database
      firstData[key] = value;
  });

  console.log("FIRSTDATA", firstData);

  var i = 0;
  Object.keys(firstData).map(function(key, index){
      //console.log("index", index);
      duplicateKey = getKeyExisted(mapData, firstData[key])
      if (duplicateKey) {
        //console.log("duplicateKey", duplicateKey);
        mapData[key] = mapData[duplicateKey]; //kalau lagunya ada yg sama, ambil warna yg udah ada
      } else {
        //console.log("warna baru");
        mapData[key] = [firstData[key], colorList[i]]; //lagunya ga ada yg sama
        i++;
      }
      duplicateKey = undefined;
  });
function getCountrySong(tes){
    if (tes === "ID"){
              return("Indonesia");
          } else if (tes  === "AU"){
              return("Australia");
          } else if (tes  === "BR"){
              return("Brazil");
          } else if (tes  === "CA"){
              return("Canada");
          } else if (tes  === "JP"){
              return("Jepang");
          } else if (tes  === "MX"){
              return("Mexico");
          } else if (tes  === "SE"){
              return("Swedia");
          } else if (tes  === "TR"){
              return("Turkey");
          } else if (tes  === "US"){
              return("Amerika");
          }
}
  console.log("mapData",mapData);
  //bentuknya:
  //mapdata = { "ID": ['namalagu', 'warna'], "AU": ... }

  var mapAreas = Object.keys(mapData).map(function(key, index){
    return { "id": key, "color" : mapData[key][1], "alpha" : 1 , "title" :getCountrySong(key), "description" : mapData[key][0], "balloonText" : "<h4><b>[[title]]</b></h4> [[description]]" };
  });

  console.log("mapAreas", mapAreas);
  //bentuknya:
  //mapareas = { "ID": "warnanya", "AU": ... }

  var map = AmCharts.makeChart( "chartdiv", {
    "type": "map",
    "theme": "light",

    "dataProvider": {
      "map": "worldLow",
      "areas": mapAreas
    },

    "areasSettings": {
    //   "autoZoom": true,
    "selectable":true,
      "unlistedAreasAlpha": 0.1,
      "rollOverColor": null,
    //   "rollOverOutlineAlpha" : 1,
    // "rollOverOutlineColor" : "#0000",
    // "rollOverOutlineThickness" : 20,
    
      "selectedColor": "#F870A1"
    },
// "graph": {
//         "fillAlphas": 1,
//         // overwrite alphas here:
//         "alphaField": "alpha",
//         "lineColor": "#000",
//         "lineThickness": 1},

    "export": {
      "enabled": true
    },

  } );

  //misal map diklik, baru ngeprint id map
  map.addListener("clickMapObject", function (event) {
    console.log("AAAAAAAAAAAAA");
    
      if (event.mapObject.id != undefined) { //&& chartData[event.mapObject.id] != undefined) {
          // chart.dataProvider = chartData[event.mapObject.id];
          // chart.clearLabels();
          // chart.addLabel("0", "!20", event.mapObject.title, "center", 16);
          // chart.validateData();
          var x = document.getElementsByClassName("amcharts-map-area-"+event.mapObject.id)
          x[0].setAttribute("fill", mapData[event.mapObject.id][1]);
          var y = document.getElementsByClassName("amcharts-description-div");
          y[0].style.visibility = "hidden";
        //   console.log("amcharts-map-area-"+event.mapObject.id)
        //   console.log(x[0].getAttribute("fill"));
// event.mapObject.selectedColor = x[0].getAttribute("fill");
          console.log(event.mapObject.id);
          $on++;
          var tesMap = "indonesia";
          var tesMap1 = "Indonesia";
          if (event.mapObject.id === "ID"){
           tesMap = "indonesia";
              tesMap1 = "Indonesia";
          } else if (event.mapObject.id  === "AU"){
              tesMap = "australia";
              tesMap1 = "Australia";
          } else if (event.mapObject.id  === "BR"){
              tesMap = "brazil";
              tesMap1 = "Brazil";
          } else if (event.mapObject.id  === "CA"){
              tesMap = "canada";
              tesMap1 = "Canada";
          } else if (event.mapObject.id  === "JP"){
              tesMap = "jepang";
              tesMap1 = "Jepang";
          } else if (event.mapObject.id  === "MX"){
              tesMap = "mexico";
              tesMap1 = "Mexico";
          } else if (event.mapObject.id  === "SE"){
              tesMap = "swedia";
              tesMap1 = "Swedia";
          } else if (event.mapObject.id  === "TR"){
              tesMap = "turkey";
              tesMap1 = "Turkey";
          } else if (event.mapObject.id  === "US"){
              tesMap = "amerika";
              tesMap1 = "Amerika";
          }
          var month = ["January", "February", "March", "April", "May", "June",
              "July", "August", "September", "October", "November", "December"][d.getMonth()-1];
              var days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
          var str = (d.getDate())+' ' + month + ' ' + d.getFullYear();
          document.getElementById("countrypopup").innerHTML = '<div class=\"ui mini image\" style=\"margin-right: 1%\"> <img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Spotify_logo_without_text.svg/2000px-Spotify_logo_without_text.svg.png\" alt=\"Spotify Logo\"> </div>'+ tesMap1+ ' Spotify Chart - '+days[d.getDay()]+', '+str;
          
          //console.log("onn luar", onn);
          console.log("YAAY");
          console.log(indate1);
          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
                  console.log("TES",result);
                  testinginput1 = JSON.parse(result);
                  //console.log("onn update", onn);

              }
          }).done(function(result){
          });
          console.log("TESTING")
          console.log(testinginput1)
          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo2.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
                  console.log(result);
                  testinginput2 = JSON.parse(result);
                  //console.log("onn update", onn);

              }
          }).done(function(result){
          });
          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo3.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
                  console.log(result);
                  testinginput3 = JSON.parse(result);
//            drawBasic();
                  //console.log("onn update", onn);

              }
          }).done(function(result){
          });
          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo4.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
                  saveSong = JSON.parse(result);
                  drawBasic();
                  console.log(saveSong[0]);

              }
          }).done(function(result){
          });
          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo5.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
                  saveBpm = JSON.parse(result);
                  console.log(saveSong[0]);

              }
          }).done(function(result){
          });

          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo6.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
                  saveDur = JSON.parse(result);

              }
          }).done(function(result){
          });

          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo7.php",
              data: {indate: indate1, map:tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
                  saveDance = JSON.parse(result);

              }
          }).done(function(result){
          });

          $.ajax({
              type: "POST",
              url: "updatedateajaxinfo8.php",
              data: {indate: indate1, map: tesMap},
              success: function (result) {
                  //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
                  saveEner = JSON.parse(result);
                  drawBasic();

              }
          }).done(function(result){
          });
              drawBasic();
              $tes++;
              $(".test").modal('show');
          console.log("map id", event.mapObject.id); //id negaranya
          console.log($('input').val()); //tanggal, format: mm/dd/yyyy
      }
  });
}

$('input').dateDropper({
    dropBackgroundColor: "#1ED760",
  });


//CHANGE DATEPICKER DISINI YG BELUM BISA
$('input').change(function() {
  function legendRewrite() {
    $('#maphistory').empty();
    $('#maphistory').append(getMapHistory());
  }

  var rawdate = $(this).val();
  //console.log("CHANGEDATE", jQuery.type(rawdate), rawdate);

  var arr = rawdate.split('/');
  indate1 = '' + arr[2] + '-' + arr[0] + '-' + arr[1]; //tanggal baru
     d = new Date(arr[2],arr[0], arr[1]);
  console.log("DATEEEE", indate1);

  console.log("YAAY");
    $.ajax({
        type: "POST",
        url: "updatedateajax.php",
        data: {indate: indate1},
        success: function (result) {
        //console.log("SUCCESS", result);

        testinginput = JSON.parse(result);
        onn++;
            drawMap();
            legendRewrite();
        //console.log("onn update", onn);
        //console.log(result)
        
    }
    }).done(function(result){
    });


    drawMap();
    legendRewrite();
    $on++;
    //console.log("onn luar", onn);
    console.log("YAAY");
    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
            console.log(result);
            testinginput1 = JSON.parse(result);
            //console.log("onn update", onn);

        }
    }).done(function(result){
    });
    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo2.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
            console.log(result);
            testinginput2 = JSON.parse(result);
            //console.log("onn update", onn);

        }
    }).done(function(result){
    });
    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo3.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
            console.log(result);
            testinginput3 = JSON.parse(result);
//            drawBasic();
            //console.log("onn update", onn);

        }
    }).done(function(result){
    });
    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo4.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
            saveSong = JSON.parse(result);
            drawBasic();
            console.log(saveSong[0]);

        }
    }).done(function(result){
    });

    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo5.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
            saveBpm = JSON.parse(result);
            console.log(saveSong[0]);

        }
    }).done(function(result){
    });

    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo6.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
            saveDur = JSON.parse(result);

        }
    }).done(function(result){
    });

    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo7.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
            saveDance = JSON.parse(result);

        }
    }).done(function(result){
    });

    $.ajax({
        type: "POST",
        url: "updatedateajaxinfo8.php",
        data: {indate: indate1, map: "indonesia"},
        success: function (result) {
            //console.log("SUCCESS", result);
//            alert(result);
//            console.log(result[0]);
console.log(result);
            saveEner = JSON.parse(result);
            drawBasic();

        }
    }).done(function(result){
    });
    
});

// $(document).ready(function() {
    
// });
$(document).ready(function(){
    drawMap();
    $('#maphistory').append(getMapHistory());
                                   
});
</script>
