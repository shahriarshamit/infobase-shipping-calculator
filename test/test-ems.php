<?php

require_once __DIR__ . '/../init.php';

$postData = [
    "process" => "calculate",
    "country" => "US",
    "city" => "Beaverton",
    "zip" => "97123",
    "quantity" => "2",
    "weight" => "30",
    "length" => "55",
    "width" => "55",
    "height" => "55"
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
    $total_charge = $selected_weight[$selected_zone] * $postData['quantity'];
    var_dump($total_charge);
}
