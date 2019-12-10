<!DOCTYPE html>
<html lang="en" xmlns:margin-top="http://www.w3.org/1999/xhtml">
<link href="dist/semantic.css" media="all" rel="Stylesheet" type="text/css" />
<link href="dist/components/modal.css" media="all" rel="Stylesheet" type="text/css" />
<link href="https://fonts.googleapis.com/css?family=Montserrat:400" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<?php
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
echo "Connected successfully";
?>
<style>
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
<body>
<button class="ui button yellow create_btn" type="button" id="test">Create</button>
<div class="ui fullscreen modal test">
    <i class="close icon"></i>
    <div class="header">
        <h1>
            <div class="ui mini image" style="margin-right: 1%">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/19/Spotify_logo_without_text.svg/2000px-Spotify_logo_without_text.svg.png" alt="Spotify Logo">
            </div>
             Indonesia Spotify Chart</h1>
    </div>
    <div class="image content">

        <!--<div class="ui medium image">-->
            <div id="chart_div" style="height: 500px; width: 500px"></div>
        <!--</div>-->
        <div class="description"  style="margin-left: 2%">
            <div class="ui two column grid">
                <div class="stretched row">
                    <div class="column">
                        <!--<div class="ui segment" style="height: 100px">-->
                            <iframe src="https://open.spotify.com/embed/track/7KXjTSCq5nL1LoYtL7XAwS" width="100%" height="90" frameborder="0" allowtransparency="true" id="songplayer"></iframe>
                        <!--</div>-->
                        <div class="ui segment" style="height: 350px; margin-top:10%";>
                            <div class="ui icon" data-tooltip="Shit in shit Shit in SHit" style="margin-bottom: 0; text-align: right">
                                what is this shit?
                            </div>
                            <h3 style="margin-top: 0">Tempo and Duration</h3>
                            <div id="chart_div_2" style="width:350px; height:280px"></div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="ui basic segment" style="height: 60px">
<!--                            <b><h3 id="artist" style="color:#fff; margin-top: -3.5%">Artist : </h3></b>-->
                            <h2 style="margin-top: -2%">
                                <div class="ui four column grid" style="margin-left: 2.5%; margin-right: 2.5%; margin-top: 0%">
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="" style="margin-bottom: 0;">
                                            <i class="heartbeat icon"></i>
                                        </div>
                                        <h4 id="beat" style="margin-top: 0%; text-align: center">100 BPM</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Shit in shit Shit in SHit" style="margin-bottom: 0;">
                                            <i class="hourglass start icon"></i>
                                        </div>
                                        <h4 id="dur" style="margin-top: 0%; text-align: center">100 s</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Shit in shit Shit in SHit" style="margin-bottom: 0;">
                                            <i class="battery three quarters icon"></i>
                                        </div>
                                        <h4 id="ener" style="margin-top: 0%; text-align: center">20</h4>
                                    </div>
                                    <div class="column" style="text-align: center">
                                        <div class="ui icon" data-tooltip="Shit in shit Shit in SHit" style="margin-bottom: 0;">
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
                        <div class="ui segment" style="height: 350px; margin-top:15%";>
                            <div class="ui icon" data-tooltip="Shit in shit Shit in SHit" style="margin-bottom: 0; text-align: right">
                                what is this shit?
                            </div>
                            <h3 style="margin-top: 0">Energy and Danceability</h3>
                            <div id="chart_div_3" style="width:350px; height:280px"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="actions">-->
        <!--<div class="ui black deny button">-->
            <!--Nope-->
        <!--</div>-->
        <!--<div class="ui positive right labeled icon button">-->
            <!--Yep, that's me-->
            <!--<i class="checkmark icon"></i>-->
        <!--</div>-->
    <!--</div>-->
</div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $tes = 1;
    $on = 0;
    var chart1;
    var chart2;
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBasic);

    function drawBasic() {

        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart1);
        function drawChart1() {
            if ($on>=0){

                var data = google.visualization.arrayToDataTable([
                    ['Duration', 'Tempo', {type: 'string' , role: 'tooltip', 'p': {'html': true}}],
                    <?php
                    $save1 = array();
                    $bpm = array();
                    $duration = array();
                    $energy = array();
                    $danceability = array();
                    $result = $conn->query("SELECT * FROM amerika WHERE position <= 20 AND date = '2018-01-01'");
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $iter = 0;
                        while($row = $result->fetch_assoc()) {
                            $tooltip = '<div style="padding:5px 5px 5px 5px;"><h5>'.$row["title"].'</h5><table> <tr> <td style="padding:5px 5px 5px 5px; margin-right: 5%">Duration</td> <td><b>'.
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
                var data = google.visualization.arrayToDataTable([
                    ['Age', 'Weight'],
                    [ 8,      12]
                ]);
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
                width: '350',

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
                var saveSong = [<?php
                    $iter = 0;
                    foreach ($save1 as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveBpm = [<?php
                    $iter = 0;
                    foreach ($bpm as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveDur = [<?php
                    $iter = 0;
                    foreach ($duration as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveEner = [<?php
                    $iter = 0;
                    foreach ($energy as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveDance = [<?php
                    $iter = 0;
                    foreach ($danceability as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
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
            if ($on>=0){

                var data = google.visualization.arrayToDataTable([
                    ['Danceability', 'Energy', {type: 'string' , role: 'tooltip', 'p': {'html': true}}],
                    <?php

                    $save2 = array();
                    $bpm = array();
                    $duration = array();
                    $energy = array();
                    $danceability = array();
                    $result = $conn->query("SELECT * FROM amerika WHERE position <= 20 AND date = '2018-01-01'");
                    if ($result->num_rows > 0) {
                        // output data of each row
                        $iter = 0;
                        while($row = $result->fetch_assoc()) {
                            $tooltip = '<div style="padding:5px 5px 5px 5px;"><h5>'.$row["title"].'</h5><table> <tr> <td style="padding:5px 5px 5px 5px; margin-right: 5%">Danceability</td> <td><b>'.
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
            } else {
                var data = google.visualization.arrayToDataTable([
                    ['Age', 'Weight'],
                    [ 8,      12]
                ]);
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
                width: '350',
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
                var saveSong = [<?php
                    $iter = 0;
                    foreach ($save1 as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveBpm = [<?php
                    $iter = 0;
                    foreach ($bpm as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveDur = [<?php
                    $iter = 0;
                    foreach ($duration as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveEner = [<?php
                    $iter = 0;
                    foreach ($energy as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                var saveDance = [<?php
                    $iter = 0;
                    foreach ($danceability as $sav){
                        echo "'".$sav."', ";
                    }
                    ?> 'tes'];
                document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[chart2.getSelection()[0]["row"]];
                document.getElementById("beat").innerHTML = saveBpm[chart2.getSelection()[0]["row"]]+' BPM';
                document.getElementById("dur").innerHTML = saveDur[chart2.getSelection()[0]["row"]]+' s';
                document.getElementById("ener").innerHTML = saveEner[chart2.getSelection()[0]["row"]];
                document.getElementById("dance").innerHTML = saveDance[chart2.getSelection()[0]["row"]];
//                alert('The user selected ' + chart1.getSelection()[0]["column"] + chart1.getSelection()[0]["row"]);
            });
            chart2.draw(data, options);
        }

        if ($tes>0){
            var data = google.visualization.arrayToDataTable([
                ['Song Title', 'Number Stream',],
                <?php

                $save = array();
                $bpm = array();
                $duration = array();
                $energy = array();
                $danceability = array();
                $result = $conn->query("SELECT * FROM amerika WHERE position <= 20 AND date = '2018-01-01'");
                if ($result->num_rows > 0) {
                    // output data of each row
                    $iter = 0;
                    while($row = $result->fetch_assoc()) {
                        if ($iter = count($result)-1) {

                            echo "[' " . $row["title"]. "', " . $row["num_stream"]. ",] ";
                        } else {

                            echo "[' " . $row["title"]. "', " . $row["num_stream"]. ",], ";
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
            var data = google.visualization.arrayToDataTable([
                ['City', '2010 Population',],
                ['New York City, NY', 8175000],
                ['Los Angeles, CA', 3792000],
                ['Chicago, IL', 2695000],
                ['Houston, TX', 2099000]
            ]);
        }

        var options = {
            title: 'Population of Largest U.S. Cities',
            chartArea: {left: 200, width: '100%', height:'100%'},
            hAxis: {
                viewWindowMode:'explicit',
                viewWindow: {

                    min: 0,
                    max : <?php echo $last ?>
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

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
//        function selectHandler() {
//            var selectedItem = chart.getSelection()[0];
//
//            if (selectedItem) {
//                var topping = data.getValue(selectedItem.row, 0);
//                chart1.setSelection([{"row":chart.getSelection()["column"],"column":chart.getSelection()["row"]}]);
////                orgchart.setSelection(table.getSelection());
//                document.getElementById("songplayer").src="https://open.spotify.com/embed/track/5k38wzpLb15YgncyWdTZE4";
//                alert('The user selected ' + topping + selectedItem.row + chart.getSelection()[0]["column"] +chart1.title);
//                $on++;
//                drawChart1();
//            }
//        }
//
//        google.visualization.events.addListener(chart, 'select', selectHandler);
        google.visualization.events.addListener(chart, 'select', function() {
            var saveSong = [<?php
                $iter = 0;
                foreach ($save1 as $sav){
                    echo "'".$sav."', ";
                }
                ?> 'tes'];
            var saveBpm = [<?php
                $iter = 0;
                foreach ($bpm as $sav){
                    echo "'".$sav."', ";
                }
                ?> 'tes'];
            var saveDur = [<?php
                $iter = 0;
                foreach ($duration as $sav){
                    echo "'".$sav."', ";
                }
                ?> 'tes'];
            var saveEner = [<?php
                $iter = 0;
                foreach ($energy as $sav){
                    echo "'".$sav."', ";
                }
                ?> 'tes'];
            var saveDance = [<?php
                $iter = 0;
                foreach ($danceability as $sav){
                    echo "'".$sav."', ";
                }
                ?> 'tes'];
            document.getElementById("songplayer").src="https://open.spotify.com/embed/track/"+ saveSong[chart.getSelection()[0]["row"]];
            document.getElementById("beat").innerHTML = saveBpm[chart.getSelection()[0]["row"]]+' BPM';
            document.getElementById("dur").innerHTML = saveDur[chart.getSelection()[0]["row"]]+' s';
            document.getElementById("ener").innerHTML = saveEner[chart.getSelection()[0]["row"]];
            document.getElementById("dance").innerHTML = saveDance[chart.getSelection()[0]["row"]];
            $on++;
            drawChart1();
            drawChart2();
            chart1.setSelection(chart.getSelection());
            chart2.setSelection(chart.getSelection());
//            alert('The user selected ' + chart.getSelection()[0]["column"] + chart.getSelection()[0]["row"]);
        });
        chart.draw(data, options);
    }
    $(function(){
        $("#test").click(function(){
            drawBasic();
            $tes++;
            $(".test").modal('show');
        });
        $(".test").modal({

            blurring: true,
            closable: true
        });
    });
</script>
<script src="dist/semantic.js"></script>
<script src="dist/components/modal.js"></script>
</html>