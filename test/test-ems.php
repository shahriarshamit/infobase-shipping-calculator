<?php

require_once __DIR__ . '/../init.php';

$postData = [
    "process" => "calculate",
    "country" => "BD",
    "city" => "Dhaka",
    "zip" => "1200",
    "quantity" => "1",
    "weight" => "20",
    "length" => "4",
    "width" => "12",
    "height" => "5"
];

$country_codes = array_keys($config['ems']['area']);
$weight_scale = array_keys($config['ems']['charge']);
if (!in_array($postData['country'], $country_codes)) {
    echo 'Country not available';
} elseif (!in_array($postData['weight'], $weight_scale)) {
    echo 'Package weight is over limit';
} else {
    $selected_zone = $config['ems']['area'][$postData['country']];
    $selected_weight = $config['ems']['charge'][$postData['weight']];
    $total_charge = $selected_weight[$selected_zone];
    var_dump($total_charge);
}
