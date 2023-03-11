<?php

function processUps($postData = []) {
    global $config, $auth;

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
    $ups_rates = [];
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
        $url = $config['ups']['production']['request'];
        $header = [
            'Authorization: Bearer ' . $ups_auth['access_token'],
            'Content-Type: application/json',
            'accept: application/json',
            'transactionSrc: testing'
        ];

        $output = curlRequest($url, $header, $request);
        if (property_exists($output['response'], 'RateResponse')) {
            $ratedShipment = $output['response']->RateResponse;
            $ratedShipment->description = $ups_services[$a][1];
            array_push($ups_rates, $ratedShipment);
        }
    }

    if ($output['status'] === 200) {
        $ratePanel = '';
        for ($c = 0; $c < count($ups_rates); $c++) {
            $ratePanel .= resultPanel('ups', $ups_rates[$c]->description, $ups_rates[$c]->RatedShipment->TotalCharges->MonetaryValue);
        }
        $return = ['status' => 'success', 'result' => $ratePanel, 'message' => ''];
    } else {
        $return = ['status' => 'exception', 'result' => '', 'message' => $output['response']];
    }
    return $return;
}
