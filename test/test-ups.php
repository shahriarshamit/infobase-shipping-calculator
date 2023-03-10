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
    "height" => "55",
    "ups" => "1"
];

$ups_header = [
    'accept' => 'application/json',
    'Authorization' => 'Basic ' . $config['ups']['production']['accounts'][$postData['ups']]['account_token']
];
$ups_payload = [
    'grant_type' => 'client_credentials',
];
$auth = new Auth('ups', 'production', 'POST', $config);
$ups_auth = $auth->makeRequest($ups_header, $ups_payload);

$ups_services = [
    ['07', 'UPS Worldwide Express'],
    ['08', 'UPS Worldwide Expedited'],
    ['11', 'UPS Standard'],
    ['54', 'UPS Worldwide Express Plus'],
    ['65', 'UPS Saver'],
];

for ($a = 0; $a < count($ups_services); $a++) {
    $request = '{
  "RateRequest": {
    "Request": {
      "TransactionReference": {
        "CustomerContext": "Verify Success response",
        "TransactionIdentifier": "?"
      }
    },
    "Shipment": {
      "Shipper": {
        "Name": "' . $config['sender']['company'] . '",
        "ShipperNumber": "' . $config['ups']['production']['accounts'][$postData['ups']]['account_number'] . '",
        "Address": {
          "AddressLine": [],
          "City": "' . $config['sender']['city'] . '",
          "PostalCode": "' . $config['sender']['postal_code'] . '",
          "CountryCode": "' . $config['sender']['country_code'] . '"
        }
      },
      "ShipTo": {
        "Name": "Ship To",
        "Address": {
          "AddressLine": [],
          "City": "' . $postData['city'] . '",
          "PostalCode": "' . $postData['zip'] . '",
          "CountryCode": "' . $postData['country'] . '"
        }
      },
      "ShipFrom": {
        "Name": "' . $config['sender']['company'] . '",
        "Address": {
          "AddressLine": [],
          "City": "' . $config['sender']['city'] . '",
          "PostalCode": "' . $config['sender']['postal_code'] . '",
          "CountryCode": "' . $config['sender']['country_code'] . '"
        }
      },
      "PaymentDetails": {
        "ShipmentCharge": {
          "Type": "01",
          "BillShipper": {
            "AccountNumber": "' . $config['ups']['production']['accounts'][$postData['ups']]['account_number'] . '"
          }
        }
      },
      "Service": {
        "Code": "' . $ups_services[$a][0] . '",
        "Description": "' . $ups_services[$a][0] . '"
      },
      "ShipmentTotalWeight": {
        "UnitOfMeasurement": {
          "Code": "LBS",
          "Description": "Pounds"
        },
        "Weight": "' . ( $postData['weight'] * $postData['quantity'] ) . '"
      },
      "NumOfPieces": "' . $postData['quantity'] . '",
      "Package": [';
    for ($b = 0; $b < $postData['quantity']; $b++) {
        $request .= '{
          "PackagingType": {
            "Code": "02",
            "Description": "Packaging"
          },
          "Dimensions": {
            "UnitOfMeasurement": {
              "Code": "CM",
              "Description": "Centimeters"
            },
            "Length": "' . $postData['length'] . '",
            "Width": "' . $postData['width'] . '",
            "Height": "' . $postData['height'] . '"
          },
          "PackageWeight": {
            "UnitOfMeasurement": {
              "Code": "KGS",
              "Description": "KGS"
            },
            "Weight": "' . $postData['weight'] . '"
          },
          "OversizeIndicator": "X",
          "MinimumBillableWeightIndicator": "X"
        }';
        $request .= (($b < $postData['quantity']) ? ',' : '' );
    }
    $request .= '],
      "ShipmentRatingOptions": {
        "NegotiatedRatesIndicator": "Y"
      }
    }
  }
}';

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $config['ups']['sandbox']['request']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, 300);
    curl_setopt($curl, CURLOPT_ENCODING, "");
    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $ups_auth['access_token'],
        'Content-Type: application/json',
        'accept: application/json',
        'transactionSrc: testing'
    ]);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_POST, TRUE);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
    $response = json_decode(curl_exec($curl));
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    testData($response, false, false);

    //$ratedShipment = $output['response']->RateResponse;
    //echo 'ups' . ':' . $ups_services[$a][0] . ' => ' . $ratedShipment->RatedShipment->TotalCharges->MonetaryValue;
}

//$total_charge = 0.00;

