<?php
// Current day Report call

$apiKey = "85667f70b57204637b33e9748b48d0a9";
$cityId = "2174003";
$googleApiUrl = "http://api.openweathermap.org/data/2.5/weather?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$ch = curl_init();

curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_URL, $googleApiUrl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_VERBOSE, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);

curl_close($ch);
$data = json_decode($response);

$currentTime = time();

//Calling Specific data from api

$temp = $data->main->temp;
$description = $data->weather[0]->description;
$feels_like = $data->main->feels_like;
$temp_min = $data->main->temp_min;
$temp_max = $data->main->temp_max;
$sunset = $data->sys->sunrise;
$sunrise = $data->sys->sunset;
$humidity = $data->main->humidity;

//Changing DateTime Output

$ts = $sunrise;
$dt = new DateTime('@' . $ts);
$dt->setTimezone(new DateTimeZone('Australia/Brisbane'));
$sunsetTime= $dt->format('H:i');

$ts = $sunset;
$dt = new DateTime('@' . $ts);
$dt->setTimezone(new DateTimeZone('Australia/Brisbane'));
$sunriseTime= $dt->format(' H:i');

//3 Day report call

$googleApiUrl = "http://api.openweathermap.org/data/2.5/forecast?id=" . $cityId . "&lang=en&units=metric&APPID=" . $apiKey;

$cl = curl_init();

curl_setopt($cl, CURLOPT_HEADER, 0);
curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($cl, CURLOPT_URL, $googleApiUrl);
curl_setopt($cl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($cl, CURLOPT_VERBOSE, 0);
curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($cl);

curl_close($cl);
$data2 = json_decode($response);

//Calling Specific data from api

$description2 = $data2->list[1]->weather[0]->description;
$temp2 = $data2->list[1]->main->temp;
$humidity2 = $data2->list[1]->main->humidity;

$description3 = $data2->list[2]->weather[0]->description;
$temp3 = $data2->list[2]->main->temp;
$humidity3 = $data2->list[2]->main->humidity;

$description4 = $data2->list[3]->weather[0]->description;
$temp4 = $data2->list[3]->main->temp;
$humidity4 = $data2->list[3]->main->humidity;

// Page HTML layout

echo "

<!DOCTYPE html>
<html>
<head>
<title>Weather Forecast</title>
<link href='https://fonts.googleapis.com/css2?family=Chivo:ital,wght@1,300&display=swap' rel='stylesheet'> 
<link href='https://fonts.googleapis.com/css2?family=Palanquin:wght@700&display=swap' rel='stylesheet'>

//CSS Code 

<style>
html{
      background: linear-gradient(to right, #f3f39e, #fafa51, #fa921b );
  }
  
  .Title {
      font-family: 'Palanquin', sans-serif;
      position: absolute;
      color: black;
      width: 100%;
      text-align: center;
  }
  
  .Title > h1 {
      text-align: center;
      font-size: 70px;
  }
  
  .Current {
      color: black;
      font-family: 'Chivo', sans-serif;
      margin-top: 8%;
      position: absolute;
      width: 100%;
      height: 45vh;
  }
  
  .Current > h1 {
      text-align: center;
      font-size: 45px;
      font-family: 'Palanquin', sans-serif;
  }
  
  .ThreeDay {
      color: black;
      font-family: 'Chivo', sans-serif;
      margin-top: 25%;
      position: absolute;
      width: 100%;
      height: 45vh;
  }
  
  .ThreeDay > h1 {
      text-align: center;
      font-size: 45px;
      font-family: 'Palanquin', sans-serif;
  }
  
  .ThreeDay h2 {
      font-size: 30px;
      font-family: 'Palanquin', sans-serif;
  }
  
  .content {
      font-size: 20px;
      line-height: 40px;
  }
  
  .ThreeDay > .Layout {
      width: 100%;
      display: flex;
      align-content: center;
      justify-content: center;
  }
  
  .Current > .Layout {
      width: 100%;
      display: flex;
      align-content: center;
      justify-content: center;
  }
  
  .ThreeDay ul {
      margin: 0 100px 0 100px;
  }
  
  .Current ul {
      margin: 0 150px 0 150px;
  }
</style>

</head>
<body>
<div class='Title'>
      <h1>Weather Forecast for Brisbane</h1>
</div>

<div class='Current'>
    <h1>Today's Forecast</h1>
    <div class='Layout'>
      <ul class='content'>
            <li>Weather description:   {$description}</li>
            <li>Temperature:   {$temp} &#176;</li>
            <li>Temperature feels like:   {$feels_like} &#176;</li> 
            <li>Temp min:   {$temp_min} &#176;</li>
      </ul>
      <ul class='content'> 
            <li>Temp max:   {$temp_max} &#176;</li> 
            <li>Sunrise:   {$sunriseTime} am</li> 
            <li>Sunset:   {$sunsetTime} pm</li>
            <li>Humidity:   {$humidity} %</li> 
      </ul>
    </div>
</div>

<div class='ThreeDay'>
    <h1>3 Day Forecast</h1>
    <div class='Layout'>
      <ul class='content'>
            <h2>Tomorrow</h2>
            <li>Weather description:   {$description2}</li>
            <li>Temperature:   {$temp2} &#176;</li>
            <li>Humidity:   {$humidity2} %</li> 
      </ul>
      <ul class='content'>
            <h2>Day 2</h2>
            <li>Weather description:   {$description3}</li>
            <li>Temperature:   {$temp3} &#176;</li>
            <li>Humidity:   {$humidity3} %</li> 
      </ul>
      <ul class='content'>
            <h2>Day 3</h2>
            <li>Weather description:   {$description4}</li>
            <li>Temperature:   {$temp4} &#176;</li>
            <li>Humidity:   {$humidity4} %</li> 
      </ul>
    </div>
</div>

</body>
</html> 

"
?>
