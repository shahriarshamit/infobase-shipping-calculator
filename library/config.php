<?php

$config = [
    'sender' => [
        'company' => 'RMR HOLDINGS',
        'name' => 'Rasel Rahman',
        'address' => [
            'MINAMI HANYU3-20-10'
        ],
        'city' => 'SAITAMA',
        'country' => 'JAPAN',
        'country_code' => 'JP',
        'postal_code' => '3491134',
        'phone' => '08041952608',
        'email' => 'admin@buynowjapan.com'
    ],
    'fedex' => [
        'auth' => [
            'username' => 'buynowjp',
            'password' => 'rash1234A'
        ],
        'sandbox' => [
            'auth' => 'https://apis-sandbox.fedex.com/oauth/token',
            'request' => 'https://apis-sandbox.fedex.com/rate/v1/rates/quotes',
            'api_key' => 'l7c3bc60f7572644098c2bb3b1aee10f40',
            'api_secret' => '3b4bf7ff4aec41559800614425b6ae7d',
            'account_number' => '740561073'
        ],
        'production' => [
            'auth' => 'https://apis.fedex.com/oauth/token',
            'request' => 'https://apis.fedex.com/rate/v1/rates/quotes',
            'api_key' => 'l74d386b60dd5a448fa89c111326a010d8',
            'api_secret' => 'c94af9791bc540dab55ac09c9409c7d9',
            'account_number' => '606017669'
        ]
    ],
    'ups' => [
        'auth' => [
            'username' => 'rahman_rasel',
            'password' => 'rash@1234A'
        ],
        'sandbox' => [
            'auth' => 'https://wwwcie.ups.com/security/v1/oauth/token',
            'request' => 'https://wwwcie.ups.com/api/rating/v1/Rate',
            'api_key' => 'uNbGA3tybUQhwvIo3anAOz6DZ4hIueGWm5jPN4SOkNFWAAdS',
            'api_secret' => '0yn5ugZpjAoqLFzaz9jztDdYtCmWUxuMoaoK4otx9Vag15yyYW0sdgBVAlOHrEGR',
            'account_number' => 'E974Y8'
        ],
        'production' => [
            'auth' => 'https://onlinetools.ups.com/security/v1/oauth/token',
            'request' => 'https://onlinetools.ups.com/api/rating/v1/Rate',
            'api_key' => 'uNbGA3tybUQhwvIo3anAOz6DZ4hIueGWm5jPN4SOkNFWAAdS',
            'api_secret' => '0yn5ugZpjAoqLFzaz9jztDdYtCmWUxuMoaoK4otx9Vag15yyYW0sdgBVAlOHrEGR',
            'account_number' => 'E974Y8'
        ]
    ],
    'ems' => [
        'area' => [
            'KR' => 0,
            'TW' => 0,
            'CN' => 0,
            'IN' => 1,
            'ID' => 1,
            'KH' => 1,
            'SG' => 1,
            'LK' => 1,
            'TH' => 1,
            'NP' => 1,
            'PK' => 1,
            'BD' => 1,
            'PH' => 1,
            'BT' => 1,
            'BN' => 1,
            'VN' => 1,
            'HK' => 1,
            'MO' => 1,
            'MY' => 1,
            'MM' => 1,
            'MV' => 1,
            'MN' => 1,
            'LA' => 1,
            'AU' => 2,
            'CK' => 2,
            'SB' => 2,
            'NC' => 2,
            'NZ' => 2,
            'PG' => 2,
            'FJ' => 2,
            'CA' => 2,
            'PM' => 2,
            'MX' => 2,
            'AE' => 2,
            'IL' => 2,
            'IQ' => 2,
            'IR' => 2,
            'OM' => 2,
            'QA' => 2,
            'KW' => 2,
            'SA' => 2,
            'SY' => 2,
            'TR' => 2,
            'BH' => 2,
            'JO' => 2,
            'LB' => 2,
            'IS' => 2,
            'IE' => 2,
            'AZ' => 2,
            'AD' => 2,
            'IT' => 2,
            'UA' => 2,
            'GB' => 2,
            'EE' => 2,
            'AT' => 2,
            'NL' => 2,
            'GG' => 2,
            'MK' => 2,
            'CY' => 2,
            'GR' => 2,
            'HR' => 2,
            'SM' => 2,
            'JE' => 2,
            'CH' => 2,
            'SE' => 2,
            'ES' => 2,
            'SK' => 2,
            'SI' => 2,
            'CZ' => 2,
            'DK' => 2,
            'DE' => 2,
            'NO' => 2,
            'HU' => 2,
            'FI' => 2,
            'FR' => 2,
            'BG' => 2,
            'BY' => 2,
            'BE' => 2,
            'PL' => 2,
            'PT' => 2,
            'MT' => 2,
            'MC' => 2,
            'LV' => 2,
            'LT' => 2,
            'LI' => 2,
            'LU' => 2,
            'RO' => 2,
            'RU' => 2,
            'US' => 3,
            'UM' => 3,
            'AR' => 4,
            'UY' => 4,
            'EC' => 4,
            'SV' => 4,
            'GP' => 4,
            'CU' => 4,
            'CR' => 4,
            'CO' => 4,
            'JM' => 4,
            'CL' => 4,
            'TT' => 4,
            'PA' => 4,
            'PY' => 4,
            'BB' => 4,
            'GF' => 4,
            'BR' => 4,
            'VE' => 4,
            'PE' => 4,
            'HN' => 4,
            'MQ' => 4,
            'DZ' => 4,
            'UG' => 4,
            'EG' => 4,
            'ET' => 4,
            'GH' => 4,
            'GA' => 4,
            'KE' => 4,
            'CI' => 4,
            'SL' => 4,
            'DJ' => 4,
            'ZW' => 4,
            'SD' => 4,
            'SN' => 4,
            'TZ' => 4,
            'TN' => 4,
            'TG' => 4,
            'NG' => 4,
            'BW' => 4,
            'MG' => 4,
            'ZA' => 4,
            'MU' => 4,
            'MA' => 4,
            'RW' => 4,
            'RE' => 4
        ],
        'charge' => [
            '0.5' => ['1450', '1900', '3150', '3900', '3600'],
            '0.6' => ['1600', '2150', '3400', '4180', '3900'],
            '0.7' => ['1750', '2400', '3650', '4460', '4200'],
            '0.8' => ['1900', '2650', '3900', '4740', '4500'],
            '0.9' => ['2050', '2900', '4150', '5020', '4800'],
            '1' => ['2200', '3150', '4400', '5300', '5100'],
            '1.25' => ['2500', '3500', '5000', '5990', '5850'],
            '1.5' => ['2800', '3850', '5550', '6600', '6600'],
            '1.75' => ['3100', '4200', '6150', '7290', '7350'],
            '2' => ['3400', '4550', '6700', '7900', '8100'],
            '2.5' => ['3900', '5150', '7750', '9100', '9600'],
            '3' => ['4400', '5750', '8800', '10300', '11100'],
            '3.5' => ['4900', '6350', '9850', '11500', '12600'],
            '4' => ['5400', '6950', '10900', '12700', '14100'],
            '4.5' => ['5900', '7550', '11950', '13900', '15600'],
            '5' => ['6400', '8150', '13000', '15100', '17100'],
            '5.5' => ['6900', '8750', '14050', '16300', '18600'],
            '6' => ['7400', '9350', '15100', '17500', '20100'],
            '7' => ['8200', '10350', '17200', '19900', '22500'],
            '8' => ['9000', '11350', '19300', '22300', '24900'],
            '9' => ['9800', '12350', '21400', '24700', '27300'],
            '10' => ['10600', '13350', '23500', '27100', '29700'],
            '11' => ['11400', '14350', '25600', '29500', '32100'],
            '12' => ['12200', '15350', '27700', '31900', '34500'],
            '13' => ['13000', '16350', '29800', '34300', '36900'],
            '14' => ['13800', '17350', '31900', '36700', '39300'],
            '15' => ['14600', '18350', '34000', '39100', '41700'],
            '16' => ['15400', '19350', '36100', '41500', '44100'],
            '17' => ['16200', '20350', '38200', '43900', '46500'],
            '18' => ['17000', '21350', '40300', '46300', '48900'],
            '19' => ['17800', '22350', '42400', '48700', '51300'],
            '20' => ['18600', '23350', '44500', '51100', '53700'],
            '21' => ['19400', '24350', '46600', '53500', '56100'],
            '22' => ['20200', '25350', '48700', '55900', '58500'],
            '23' => ['21000', '26350', '50800', '58300', '60900'],
            '24' => ['21800', '27350', '52900', '60700', '63300'],
            '25' => ['22600', '28350', '55000', '63100', '65700'],
            '26' => ['23400', '29350', '57100', '65500', '68100'],
            '27' => ['24200', '30350', '59200', '67900', '70500'],
            '28' => ['25000', '31350', '61300', '70300', '72900'],
            '29' => ['25800', '32350', '63400', '72700', '75300'],
            '30' => ['26600', '33350', '65500', '75100', '77700']
        ]
    ]
];
