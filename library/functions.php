<?php

function curlRequest($url = '', $header = [], $request = []) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 300);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    $response = json_decode(curl_exec($curl));
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    return [
        'status' => $status,
        'response' => $response
    ];
}

function resultPanel($service = '', $packageName = '', $packagePrice = '') {
    $panel = '<div class="panel panel-default col-sm-4">';
    $panel .= '<div class="calHead">';
    $panel .= '<img src="' . IMAGES . 'logo-' . $service . '.png" class="img-responsive" />';
    $panel .= '<h5>' . $packageName . '</h5>';
    $panel .= '</div>';
    $panel .= '<button class="calButton" onclick="copyToClipboard(this)" data-value="' . number_format((float) $packagePrice, 2, '.', ',') . '">';
    $panel .= '<div class="calBody" data-toggle="tooltip" data-placement="bottom" title="Copy to Clipboard">';
    $panel .= '<i class="fa fa-jpy"></i>&nbsp;' . number_format((float) $packagePrice, 2, '.', ',');
    $panel .= '</div>';
    $panel .= '</button>';
    $panel .= '</div>';
    return $panel;
}

function testData($data, $encode = false, $stop = true) {
    if ($encode === false) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    } else {
        echo '<pre>';
        echo htmlspecialchars($data);
        echo '</pre>';
    }
    if ($stop === TRUE) {
        die;
    }
}
