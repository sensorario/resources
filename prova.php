<?php

$array1 = array('SrNo' => 'xyzO' , 'AirlineCode' => '9E' , 'FlightNo' => '777');
$array2 = array('SrNo' => 'xyzR' , 'AirlineCode' => '6G' , 'FlightNo' => '546');
$array3 = array('SrNo' => 'abcO' , 'AirlineCode' => '5H' , 'FlightNo' => '423');
$array4 = array('SrNo' => 'abcR' , 'AirlineCode' => '2G' , 'FlightNo' => '420');

$collection = [
    $array1,
    $array2,
    $array3,
    $array4,
];

$newCollection = [];

passthru('clear');

foreach ($collection as $itemKey => $itemValue) {
    $key = substr($itemValue['SrNo'], 0, 3);
    if (!isset($newCollection[$key])) {
        $newCollection[$key] = [
            'onwards' => $itemValue,
        ];
    } else {
        $newCollection[$key]['return'] = $itemValue;
    }
}

echo json_encode($newCollection, JSON_PRETTY_PRINT);

$position = 0;
foreach ($newCollection as $itemKey => $itemValue) {
    $newCollection[++$position] = $itemValue;
    unset($newCollection[$itemKey]);
}

echo json_encode($newCollection, JSON_PRETTY_PRINT);

