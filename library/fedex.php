<?php

function processFedex($postData = []) {
    global $config, $auth;

    $fedex_header = [];
    $fedex_payload = [
        'grant_type' => 'client_credentials'
    ];
    $auth = new Auth('fedex', 'production', 'POST', $config);
    $fedex_auth = $auth->makeRequest($fedex_header, $fedex_payload);

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
          "shipTimestamp": "' . date('Y-m-d') . '",
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
            "PREFERRED", "ACCOUNT"
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
          ],
          "customsClearanceDetail": {
            "commodities": [
              {
                "name": "DOCUMENTS",
                "numberOfPieces": ' . $postData['quantity'] . ',
                "description": "CLOTHING",
                "countryOfManufacture": "",
                "harmonizedCode": "",
                "harmonizedCodeDescription": "",
                "itemDescriptionForClearance": "",
                "weight": {
                  "units": "KG",
                  "value": ' . $postData['weight'] . '
                },
                "quantity": ' . $postData['quantity'] . ',
                "quantityUnits": "",
                "unitPrice": {
                  "currency": "JYE",
                  "amount": null,
                  "currencySymbol": ""
                },
                "unitsOfMeasures": [
                  {
                    "category": "",
                    "code": "",
                    "name": "",
                    "value": "",
                    "originalCode": ""
                  }
                ],
                "excises": [
                  {
                    "values": [
                      ""
                    ],
                    "code": ""
                  }
                ],
                "customsValue": {
                  "currency": "JYE",
                  "amount": 1,
                  "currencySymbol": ""
                },
                "exportLicenseNumber": "",
                "partNumber": "",
                "exportLicenseExpirationDate": "",
                "getcIMarksAndNumbers": ""
              }
            ]
          }
        }
      }';
    $url = $config['fedex']['production']['request'];
    $header = [
        'Authorization: Bearer ' . $fedex_auth['access_token'],
        'Content-Type: application/json'
    ];

    $output = curlRequest($url, $header, $request);
    if ($output['status'] === 200) {
        $rateReply = $output['response']->output->rateReplyDetails;
        $amount = number_format($rateReply[0]->ratedShipmentDetails[0]->totalNetFedExCharge, 2, ".", ",");
        $return = ['status' => 'success', 'amount' => $amount, 'message' => ''];
    } else {
        $return = ['status' => 'exception', 'amount' => '0.00', 'message' => $output['response']];
    }
    return $return;
}
