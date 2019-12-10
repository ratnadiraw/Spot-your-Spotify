<?php

  function console_log( $data ){
//      echo '<script>';
//      echo 'console.log('. json_encode( $data ) .')';
//      echo '</script>';
    }

  //   //$date = date("Y-m-d H:i:s",strtotime(str_replace('/','-',$date)));
  //   $date = date("Y-m-d");
  //   console_log($date);
  
  // // for ($i = 0; $i < 10; $i++) {

  // // }
  // $sql = "select title from indonesia where position=1 and date='2018-01-01'";
  // $result = mysqli_query($db, $sql);

  // if ($result === TRUE) {
  //     console_log("YEEYY");
  // } else {
  //   console_log("NOOOO");
  // }

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
//  echo "Connected successfully";
  $date = '2018-01-01'; //masih dummy krn di sql ga ada, harusnya pake current date --> $date = date("Y-m-d");

  function getTrendData($indate) {
    $trendarray = [];
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
//      echo "" . $key . " " . $value;
      $country = $value;
      $result = $GLOBALS['conn']->query("SELECT title, artist FROM `$country` WHERE `position`=1 AND `date`='$indate' LIMIT 1"); 
      if ($result->num_rows > 0) { 
          // output data of each row 
          $iter = 0; 
          while($row = $result->fetch_assoc()) {
              $trendarray += array($key => "".$row["artist"]." - ".$row["title"]);
          } 
      } else { 
//          echo "". $value . " 0 results". "\n";
      }
    }

    foreach ($trendarray as $key => $value) {
//      echo "" . $key . " " . $value;
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
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="Datedropper3-master/datedropper.js"></script>
<script src="https://www.amcharts.com/lib/3/ammap.js"></script>
<script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/light.js"></script>

<!-- Chart code -->
<script>

</script>

<!-- HTML -->
<div id="container">
  <div id="pickdate">
   <h2>Pick date</h2>
   <input type="text" height="0%" id="trenddate" data-large-mode="true" data-lock="to" name="indate"/>
  </div>
  <div id="chartdiv"></div>
  <div id="maphistory"></div>
</div>

<script>

var testinginput ={};
var onn = 0;

var mapData = {};
// var firstData = {
//   "AU": "as long as u love me",
//   "BR": "memelord",
//   "CA": "CA",
//   "GB": "memelord",
//   "ID": "as long as u love me",
//   "JP": "as long as u love me",
//   "MX": "asjdkasdhjksa sjdaks",
//   "SE": "SEEEEEE",
//   "TR": "as long as u love me",
//   "US": "United States",
//   "ZA": "South Africaaaaaa!"
// }

// Object.prototype.getKey = function(value) {
//   console.log("masuk sini");
//   var object = this;
//   for(var key in object){
//      console.log(object[key], value);
//      if(object[key] == value) return key;
//   }
// };

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

//Print legend (salah inget 'legend' jadi 'history', maaf namanya jad aneh)
function getMapHistory() {
  var mapHistoryToWrite = "";
  console.log("MASUK BIKIN LEGEND", mapHistoryToWrite);
  console.log("MAP DATA BIKIN LEGEND", mapData);
  var i = 0;
  var historyData = getSongAndColor(mapData);
  mapHistoryToWrite += '<div id="maphistory">';

  for (key in historyData) {
    if (historyData.hasOwnProperty(key)) {
      if (i === 0) {
        mapHistoryToWrite += '<div style="display: table-row;">'
      }

      mapHistoryToWrite += '<div style="display: table-cell;">\
          <div class="historyItem">\
            <div class="historyColor" style="background-color:' + historyData[key] + '"></div>\
            <p class="historyFont">' + key + '</p>\
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

function drawMap() {
  var colorList = [
    "#62E390",
    "#40DD78",
    "#1ED760",
    "#1AD358",
    "#16CD4E",
    "#12C744",
    "#0ABE33",
    "#0C732B",
    "#06611D",
    "#043C17",
    "#02240A" ];

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

  console.log("mapData",mapData);
  //bentuknya:
  //mapdata = { "ID": ['namalagu', 'warna'], "AU": ... }

  var mapAreas = Object.keys(mapData).map(function(key, index){
    return { "id": key, "color" : mapData[key][1] };
  });

  console.log("mapAreas", mapAreas);
  //bentuknya:
  //mapareas = { "ID": "warnanya", "AU": ... }

  var map = AmCharts.makeChart( "chartdiv", {
    "type": "map",
    "theme": "light",
    //"colorSteps": 10,

    "dataProvider": {
      "map": "worldLow",
      "areas": mapAreas
    },

    "areasSettings": {
      "autoZoom": true,
      "unlistedAreasAlpha": 0.1,
      "rollOverColor": "#F870A1",
      "selectedColor": "#F870A1"
    },


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
          console.log("map id", event.mapObject.id);
      }
  });
}

$('input').dateDropper({
    dropBackgroundColor: "#1ED760",
  });


//CHANGE DATEPICKER DISINI YG BELUM BISA
$('input').change(function() {
  function legendRewrite() {
    console.log("SEBELUM HAPUS");
    $('#maphistory').empty();
    console.log("SESUDAH HAPUS");
    $('#maphistory').append(getMapHistory());
  }

  console.log("AAAAAAAAAAAAAA");
  var rawdate = $(this).val();
  //console.log("CHANGEDATE", jQuery.type(rawdate), rawdate);

  var arr = rawdate.split('/');
  var indate1 = '' + arr[2] + '-' + arr[0] + '-' + arr[1]; //tanggal baru
  console.log("DATEEEE", indate1);

  console.log("YAAY");
    $.ajax({
        type: "POST",
        url: "updatedateajax.php",
        data: {indate: indate1},
        success: function (result) {
        console.log("SUCCESS", result);
        //alert("SUCCESS:"+ result);
//        for(var key in result) {
//            console.log(key);
//            console.log(result[key]);
//        }
        testinginput = JSON.parse(result);
        onn++;
        drawMap();
        legendRewrite();
        console.log("onn update", onn);
        //console.log(result)
        
    }
    }).done(function(result){
    });

    drawMap();
    legendRewrite();
    console.log("onn luar", onn);


  //Ajax buat ganti data map
//  $.ajax({
//    //header: { 'Content-Type': 'application/json' },
//    type: "POST",
//    url: "updatedateajax.php",
//    data: JSON.stringify({"indate": indate1}),//$('#trenddate').serialize(),
//    dataType: "json",
//    success: function (data) {
//        alert("SUCCESS:");
//        for(var key in data) {
//            console.log(key);
//            console.log(data[key]);
//        }
//    },
//    error: function (data) {
//        alert("ERROR: ");
//        // for(var key in data) {
//        //     $('#msgid').append(key);
//        //     $('#msgid').append('=' + data[key] + '<br />');
//        // }
//    }
//  });

  // $.post('updatedateajax.php', {indate: indate1});
  // var data = {
  //     "action": "getTrendDataAjax",
  //     "indate": indate1
  // };

  // $.post("updatedateajax.php", data, function(res) {
  //     console.log("POST JQUERY", data);

  // });

  // data = $(this).serialize() + "&" + $.param(data);
  //   $.ajax({
  //     type: "POST",
  //     dataType: "json",
  //     url: "updatedateajax.php", //Relative or absolute path to response.php file
  //     data: data,
  //     success: function(data) {
  //       // $(".the-return").html(
  //       //   "Favorite beverage: " + data["favorite_beverage"] + "<br />Favorite restaurant: " + data["favorite_restaurant"] + "<br />Gender: " + data["gender"] + "<br />JSON: " + data["json"]
  //       // );

  //       alert("Form submitted successfully.\nReturned json: " + data["json"]);
  //     }
  //   });
    //return false;
});

$(document).ready(function() {
    drawMap();
    $('#maphistory').append(getMapHistory());
});
</script>