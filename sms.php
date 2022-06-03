<?php
 

	   $username = "drivillPromo";
	   $password = "DrivillD09.@";
	   $mobiles = '+8801785711924';
	   $sms = 'Thank you for your kind purchase.';
	   $originator = '01844016400';
	
	echo sendSMS($username, $password, $mobiles, $sms, $originator);
	
	function sendSMS($username, $password, $phone, $message, $originator)
	{	
		// make sure passed string is url encoded
		$message = rawurlencode($message);
		
		$url = "http://clients.muthofun.com:8901/esmsgw/sendsms.jsp?user=$username&password=$password&mobiles=$phone&sms=$message&unicode=1";			

		$c = curl_init(); 
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($c, CURLOPT_URL, $url); 
		$response = curl_exec($c); 

		if( $response === false)
		{
		    echo 'Curl error: ' . curl_error($c).' '.curl_errno($c);
		}
		return $response;
	}

?>
