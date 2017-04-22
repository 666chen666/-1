<?php
$weather = simplexml_load_file('./weather.xml');
//var_dump($weather);
//$city=[];
foreach($weather as $wendy){
    $cityname = $wendy['cityname'];
    $tem2 = $wendy['tem2'];
    $tem1 = $wendy['tem1'];
    $stateDetailed= $wendy['stateDetailed'];
    if($cityname=='成都') {
        $city[] = [
            'cityname' => (string)$cityname,
            'tem2' => (string)$tem2,
            'tem1' => (string)$tem1,
            'stateDetailed' => (string)$stateDetailed,
        ];
    }
}
var_dump($city);