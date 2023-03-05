<?php

require_once 'init.php';

if (array_key_exists('cal', $_POST) && $_POST['cal']['process'] === 'calculate'):
    $postData = $_POST['cal'];
    $fedexValue = processFedex($postData);
    $upsValue = processUps($postData);
    $emsValue = processEms($postData);
    $result = $fedexValue['result'] . $upsValue['result'] . $emsValue['result'];
    echo json_encode(['output' => $result]);
endif;
