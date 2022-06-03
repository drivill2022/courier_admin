<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://smsplus.sslwireless.com/api/v3/send-sms',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('api_token' => 'DRIVILL-616ca3b0-d6f0-4fcb-996a-17a7b7e03e6a','sid' => 'DRIVILLBDAPI','msisdn' => '+918878791555','sms' => 'test message','csms_id' => '473433434pZ684333392')
));

$response = curl_exec($curl);
if( $response === false)
{
    echo 'Curl error: ' . curl_error($curl).' '.curl_errno($curl);
}
curl_close($curl);
echo $response;
