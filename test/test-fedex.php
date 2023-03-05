<?php

require_once __DIR__ . '/../init.php';

$postData = [
    "process" => "calculate",
    "country" => "US",
    "city" => "Beaverton",
    "zip" => "97123",
    "shipping" => date('Y-m-d'),
    "quantity" => "2",
    "weight" => "30",
    "length" => "55",
    "width" => "55",
    "height" => "55"
];

$request = '{
  "accountNumber": {
    "value": "' . $config['fedex']['production']['account_number'] . '"
  },
  "requestedShipment": {
    "shipper": {
      "address": {
        "city": "' . $config['sender']['city'] . '",
        "postalCode": "' . $config['sender']['postal_code'] . '",
        "countryCode": "' . $config['sender']['country_code'] . '"
      }
    },
    "recipient": {
      "address": {
        "city": "' . $postData['city'] . '",
        "postalCode": "' . $postData['zip'] . '",
        "countryCode": "' . $postData['country'] . '"
      }
    },
    "shipTimestamp": "' . $postData['shipping'] . '",
    "pickupType": "USE_SCHEDULED_PICKUP",
    "packagingType": "YOUR_PACKAGING",
    "shippingChargesPayment": {
      "payor": {
        "responsibleParty": {
          "accountNumber": {
            "value": "' . $config['fedex']['production']['account_number'] . '"
          },
          "address": {
            "countryCode": "' . $config['sender']['country_code'] . '"
          }
        }
      }
    },
    "rateRequestType": [
      "ACCOUNT"
    ],
    "preferredCurrency": "JYE",
    "requestedPackageLineItems": [
      {
        "groupPackageCount": ' . $postData['quantity'] . ',
        "physicalPackaging": "YOUR_PACKAGING",
        "insuredValue": {
          "currency": "JYE",
          "currencySymbol": null,
          "amount": 0
        },
        "weight": {
          "units": "KG",
          "value": ' . $postData['weight'] . '
        },
        "dimensions": {
          "length": "' . $postData['length'] . '",
          "width": "' . $postData['width'] . '",
          "height": "' . $postData['height'] . '",
          "units": "CM"
        }
      }
    ]
  }
}';

$fedex_header = [];
$fedex_payload = [
    'grant_type' => 'client_credentials'
];
$auth = new Auth('fedex', 'production', 'POST', $config);
$fedex_auth = $auth->makeRequest($fedex_header, $fedex_payload);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $config['fedex']['production']['request']);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_TIMEOUT, 300);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $fedex_auth['access_token'],
    'Content-Type: application/json'
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
$response = json_decode(curl_exec($curl));
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

testData($response);

$total_charge = 0.00;
