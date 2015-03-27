<?php

/** RefundTransaction NVP example; last modified 08MAY23.
 *
 *  Issue a refund for a prior transaction.
*/
//include_once("config.php");

//$environment = $PayPalMode;	// or 'beta-sandbox' or 'live'

/**
 * Send HTTP POST Request
 *
 * @param	string	The API method name
 * @param	string	The POST Message fields in &name=value pair format
 * @return	array	Parsed HTTP Response body
 */
function PPHttpPost($methodName_, $nvpStr_) {
	$environment = 'live';

	$API_UserName = urlencode('smartdelivery_api1.outlook.com');
	$API_Password = urlencode('32T2YKXQFDNJ8VY3');
	$API_Signature = urlencode('ABUQTY1RaDqyl5JXGVmVsIvCFPZeAL-qUa5Wg8f821mX00Nn4vZDfk5V');
	/* $API_UserName = urlencode('awaisk_1349926600_biz_api1.yahoo.com');
	$API_Password = urlencode('1349926631');
	$API_Signature = urlencode('AFcWxV21C7fd0v3bYYYRCpSSRl31A4IYu3nowsFclMPQ81jktAn3aj3s'); */

	// Set up your API credentials, PayPal end point, and API version.


	$API_Endpoint = "https://api-3t.paypal.com/nvp";
	if("sandbox" === $environment || "beta-sandbox" === $environment) {
		$API_Endpoint = "https://api-3t.$environment.paypal.com/nvp";
	}
	$version = urlencode('51.0');

	// Set the curl parameters.
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
	curl_setopt($ch, CURLOPT_VERBOSE, 1);

	// Turn off the server and peer verification (TrustManager Concept).
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);

	// Set the API operation, version, and API signature in the request.
	$nvpreq = "METHOD=$methodName_&VERSION=$version&PWD=$API_Password&USER=$API_UserName&SIGNATURE=$API_Signature$nvpStr_";

	// Set the request as a POST FIELD for curl.
	curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

	// Get response from the server.
	$httpResponse = curl_exec($ch);

	if(!$httpResponse) {
		exit("$methodName_ failed: ".curl_error($ch).'('.curl_errno($ch).')');
	}

	// Extract the response details.
	$httpResponseAr = explode("&", $httpResponse);

	$httpParsedResponseAr = array();
	foreach ($httpResponseAr as $i => $value) {
		$tmpAr = explode("=", $value);
		if(sizeof($tmpAr) > 1) {
			$httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
		}
	}

	if((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
		exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
	}

	return $httpParsedResponseAr;
}


function refundPaypal($transactionID) {
	// Set request-specific fields.
	$transactionID = urlencode($transactionID);
	$refundType = urlencode('Full');						// or 'Partial'
	$amount;												// required if Partial.
	$memo;													// required if Partial.
	$currencyID = urlencode('GBP');							// or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')

	// Add request-specific fields to the request string.
	$nvpStr = "&TRANSACTIONID=$transactionID&REFUNDTYPE=$refundType&CURRENCYCODE=$currencyID";

	if(isset($memo)) {
		$nvpStr .= "&NOTE=$memo";
	}

	if(strcasecmp($refundType, 'Partial') == 0) {
		if(!isset($amount)) {
			exit('Partial Refund Amount is not specified.');
		} else {
			$nvpStr = $nvpStr."&AMT=$amount";
		}

		if(!isset($memo)) {
			exit('Partial Refund Memo is not specified.');
		}
	}

	// Execute the API operation; see the PPHttpPost function above.
	$httpParsedResponseAr = PPHttpPost('RefundTransaction', $nvpStr);

	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
		//exit('Refund Completed Successfully: '.print_r($httpParsedResponseAr, true));
		$RETURN['eror'] = 'false';

	} else  {
		//exit('RefundTransaction failed: ' . print_r($httpParsedResponseAr, true));
		$RETURN['eror'] = 'true';
	}

	$RETURN['return'] = $httpParsedResponseAr;
	return $RETURN;
}


?>