<?php

function processUps($postData = []) {
    global $config, $auth;

    $ups_header = [
        'accept' => 'application/json',
        'Authorization' => 'Basic dU5iR0EzdHliVVFod3ZJbzNhbkFPejZEWjRoSXVlR1dtNWpQTjRTT2tORldBQWRTOjB5bjV1Z1pwakFvcUxGemF6OWp6dERkWXRDbVdVeHVNb2FvSzRvdHg5VmFnMTV5eVlXMHNkZ0JWQWxPSHJFR1I='
    ];
    $ups_payload = [
        'grant_type' => 'client_credentials',
    ];
    $auth = new Auth('ups', 'production', 'POST', $config);
    $ups_auth = $auth->makeRequest($ups_header, $ups_payload);

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
    $url = $config['ups']['production']['request'];
    $header = [
        'Authorization: Bearer ' . $ups_auth['access_token'],
        'Content-Type: application/json',
        'accept: application/json',
        'transactionSrc: testing'
    ];

    $output = curlRequest($url, $header, $request);
    if ($output['status'] === 200) {
        $ratedShipment = $output['response']->RateResponse->RatedShipment;
        $amount = number_format($ratedShipment->TotalCharges->MonetaryValue, 2, ".", ",");
        $return = ['status' => 'success', 'amount' => $amount, 'message' => ''];
    } else {
        $return = ['status' => 'exception', 'amount' => '0.00', 'message' => $output['response']];
    }
    return $return;
}
