<?php

function processEms($postData = []) {
    global $config, $auth;
    
    $country_codes = array_keys($config['ems']['area']);
    $weight_scale = array_keys($config['ems']['charge']);
    
    if (!in_array($postData['country'], $country_codes)) {
        $return = ['status' => 'success', 'amount' => '0.00', 'message' => 'Country not available'];
    } elseif (!in_array($postData['weight'], $weight_scale)) {
        $return = ['status' => 'success', 'amount' => '0.00', 'message' => 'Package weight is over limit'];
    } else {
        $selected_zone = $config['ems']['area'][$postData['country']];
        $selected_weight = $config['ems']['charge'][$postData['weight']];
        $total_charge = $selected_weight[$selected_zone];
        $amount = number_format($total_charge, 2, ".", ",");
        $return = ['status' => 'success', 'amount' => $amount, 'message' => 'Country not available'];
    }
    return $return;
}
