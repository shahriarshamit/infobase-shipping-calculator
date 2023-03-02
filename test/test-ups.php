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
        "ShipperNumber": "' . $config['ups']['production']['account_number'] . '",
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
            "AccountNumber": "' . $config['ups']['production']['account_number'] . '"
          }
        }
      },
      "Service": {
        "Code": "08",
        "Description": "UPS Worldwide Expedited"
      },
      "NumOfPieces": "' . $postData['quantity'] . '",
      "Package": {
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
      },
      "ShipmentRatingOptions": {
        "NegotiatedRatesIndicator": "Y"
      }
    }
  }
}';

$ups_header = [
    'accept' => 'application/json',
    'Authorization' => 'Basic dU5iR0EzdHliVVFod3ZJbzNhbkFPejZEWjRoSXVlR1dtNWpQTjRTT2tORldBQWRTOjB5bjV1Z1pwakFvcUxGemF6OWp6dERkWXRDbVdVeHVNb2FvSzRvdHg5VmFnMTV5eVlXMHNkZ0JWQWxPSHJFR1I='
];
$ups_payload = [
    'grant_type' => 'client_credentials',
];
$auth = new Auth('ups', 'production', 'POST', $config);
$ups_auth = $auth->makeRequest($ups_header, $ups_payload);

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

testData($response);

//$total_charge = 0.00;

