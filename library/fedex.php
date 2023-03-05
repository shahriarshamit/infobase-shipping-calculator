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
        "shipTimestamp": "' . date('c') . '",
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
          "LIST", "ACCOUNT"
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
    $url = $config['fedex']['production']['request'];
    $header = [
        'Authorization: Bearer ' . $fedex_auth['access_token'],
        'Content-Type: application/json'
    ];

    $output = curlRequest($url, $header, $request);
    if ($output['status'] === 200) {
        $rateReply = $output['response']->output->rateReplyDetails;
        $ratePanel = '';
        for ($a = 0; $a < count($rateReply); $a++) {
            $ratePanel .= resultPanel('fedex', $rateReply[$a]->serviceName, $rateReply[$a]->ratedShipmentDetails[0]->totalNetFedExCharge);
        }
        $return = ['status' => 'success', 'result' => $ratePanel, 'message' => ''];
    } else {
        $return = ['status' => 'exception', 'result' => '', 'message' => $output['response']];
    }
    return $return;
}
