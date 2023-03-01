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
