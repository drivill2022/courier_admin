<?php

echo $_SERVER['REMOTE_ADDR'];
const API_TOKEN = "DRIVILL-616ca3b0-d6f0-4fcb-996a-17a7b7e03e6a"; //put ssl provided api_token here
const SID = "ENGINEERING"; // put ssl provided sid here
const DOMAIN = "https://smsplus.sslwireless.com"; //api domain // example http://smsplus.sslwireless.com

//Example:
//const API_TOKEN = "e97a0e5c-e058-4527-914a-e7aac4508ec6"; //put ssl provided api_token here
//const SID = "TESTSID"; // put ssl provided sid here
//const DOMAIN = "https://smsplus.sslwireless.com"; //api domain

/**
 * ===================================================================================================
 *  Send Single SMS
 * ===================================================================================================
 *
 * csms_id must be unique in same day
 */

$msisdn = "019XXXXXXXX";
$messageBody = "Message Body";
$csmsId = "2934fe343"; // csms id must be unique


echo singleSms($msisdn, $messageBody, $csmsId);


/**
 * ===================================================================================================
 *  Send Bulk SMS
 * ===================================================================================================
 * batch_csms_id must be unique in same day
 */

$msisdn = ["019XXXXXXXX", "018xxxxxxxx"]; // msisdn must be array
$messageBody = "Message Body";
$batchCsmsId = "2934fe343"; // csms id must be unique

echo bulkSms($msisdn, $messageBody, $batchCsmsId);



/**
 * ===================================================================================================
 *  Send Dynamic SMS --
 * ===================================================================================================
 *
 */

//prepare message data
// csms_id must be unique
$messageData = [
    [
        "msisdn" => "019XXXXXXXX",
        "text" => "SMS 1",
        "csms_id" => "92334034"
    ],
    [
        "msisdn" => "018xxxxxxxx",
        "text" => "SMS 2",
        "csms_id" => "92340333"
    ]
];

echo dynamicSms($messageData);







/**
 * @param $msisdn
 * @param $messageBody
 * @param $csmsId (Unique)
 */
function singleSms($msisdn, $messageBody, $csmsId)
{
    $params = [
        "api_token" => API_TOKEN,
        "sid" => SID,
        "msisdn" => $msisdn,
        "sms" => $messageBody,
        "csms_id" => $csmsId
    ];
    $url = trim(DOMAIN, '/')."/api/v3/send-sms";
    $params = json_encode($params);

    echo callApi($url, $params);
}

/**
 * @param $msisdns
 * @param $messageBody
 * @param $batchCsmsId
 */
function bulkSms($msisdns, $messageBody, $batchCsmsId)
{
    $params = [
        "api_token" => API_TOKEN,
        "sid" => SID,
        "msisdn" => $msisdns,
        "sms" => $messageBody,
        "batch_csms_id" => $batchCsmsId
    ];
    $url = trim(DOMAIN, '/')."/api/v3/send-sms/bulk";
    $params = json_encode($params);

    echo callApi($url, $params);
}

/**
 * @param $messageData
 */
function dynamicSms($messageData)
{
    $params = [
        "api_token" => API_TOKEN,
        "sid" => SID,
        "sms" => $messageData,
    ];
    $params = json_encode($params);
    $url = trim(DOMAIN, '/')."/api/v3/send-sms/dynamic";
    echo callApi($url, $params);
}


function callApi($url, $params)
{
    $ch = curl_init(); // Initialize cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($params),
        'accept:application/json'
    ));

    $response = curl_exec($ch);

    curl_close($ch);

    return $response;
}


