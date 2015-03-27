<?php
/* include_once('../functions.php');

	$_select = "*";
	$_where = "`order_id` = '160'";
	$order_result = SELECT($_select ,$_where, 'orders', 'array');

$transDet = json_decode($order_result['order_transaction_details'],true);
$transactionDetails['CrossReference'] = $transDet['CrossReference'];
$transactionDetails['Amount'] = $order_result['order_total'];
$transactionDetails['OrderID'] = $order_result['order_transaction_id'];

$refund_return = refundCard($transactionDetails);

print_r($refund_return);
 */
function refundCard($transactionDetails) {

	// <LIVE ACCOUNR DETAILS>
	$MerchantID = "JffSol-6874397";
	$Password = "JustFastfood123";
	// </LIVE ACCOUNR DETAILS>


	// <TEST ACCOUNT DETAILS>
	/* $MerchantID = "JffSol-8524398";
	$Password = "Pakistan124"; */
	// </TEST ACC>

	$RESPONSE['eror'] = 'false';

	//XML Headers used in cURL - remember to change the function after thepaymentgateway.net in SOAPAction when changing the XML to call a different function
	$headers = array(
				'SOAPAction:https://www.thepaymentgateway.net/CrossReferenceTransaction',
				'Content-Type: text/xml; charset = utf-8',
				'Connection: close'
			);

	//Enter your gateway ID & Password
	$gwMerchantID = $MerchantID;
	$gwPassword = $Password;

	$CrossReference = $transactionDetails['CrossReference']; //Cross Reference of Original Transaction to refund

	$Amount = ($transactionDetails['Amount'] * 100); //Amount to refund (must be equal to, or can be less than the original transaction [a partial refund]). You cannot refund more than was originally captured.
	$OrderID = $transactionDetails['OrderID']; //Order ID for this transaction (recommend you use the same order ID as the original order - suffixed with an R, to indicate this is a refund for the original transaction).
	$OrderDescription = "Refund of Order ID: ".$transactionDetails['OrderID']; //Order Description for this refund.

	//XML to send to the Gateway
	//NOTE: this is uses the "CrossReferenceTransaction" function of the gateway - notice how the TransactionType = REFUND.
	$xml = '<?xml version="1.0" encoding="utf-8"?>
	<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xmlns:xsd="http://www.w3.org/2001/XMLSchema"
	xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
	<soap:Body>
	<CrossReferenceTransaction xmlns="https://www.thepaymentgateway.net/">
	<PaymentMessage>
	<MerchantAuthentication MerchantID="'. $gwMerchantID .'" Password="'. $gwPassword . '" />
	<TransactionDetails Amount="'. $Amount .'" CurrencyCode="826">
	<MessageDetails TransactionType="REFUND" NewTransaction="TRUE" CrossReference="'. $CrossReference .'" />
	<OrderID>'. $OrderID .'</OrderID>
	<OrderDescription>'. $OrderDescription .'</OrderDescription>
	<TransactionControl>
	<EchoCardType>TRUE</EchoCardType>
	<EchoAVSCheckResult>TRUE</EchoAVSCheckResult>
	<EchoCV2CheckResult>TRUE</EchoCV2CheckResult>
	<EchoAmountReceived>TRUE</EchoAmountReceived>
	<DuplicateDelay>60</DuplicateDelay>
	<AVSOverridePolicy>BPPF</AVSOverridePolicy>
	<ThreeDSecureOverridePolicy>FALSE</ThreeDSecureOverridePolicy>
	<CustomVariables>
	<GenericVariable Name="MyInputVariable" Value="Ping" />
	</CustomVariables>
	</TransactionControl>
	</TransactionDetails>
	<PassOutData>Some data to be passed out</PassOutData>
	</PaymentMessage>
	</CrossReferenceTransaction>
	</soap:Body>
	</soap:Envelope>';

	$gwId = 1;
	$domain = "cardsaveonlinepayments.com";
	$port = "4430";
	$transattempt = 1;
	$soapSuccess = false;

	//It will attempt each of the gateway servers (gw1, gw2 & gw3) 3 times each before totally failing
	while(!$soapSuccess && $gwId <= 3 && $transattempt <= 3) {

		//builds the URL to post to (rather than it being hard coded - means we can loop through all 3 gateway servers)
		$url = 'https://gw'.$gwId.'.'.$domain.':'.$port.'/';

		//initialise cURL
		$curl = curl_init();

		//set the options
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		//Execute cURL request
		//$ret = returned XML
		$ret = curl_exec($curl);
		//$err = returned error number
		$err = curl_errno($curl);
		//retHead = returned XML header
		$retHead = curl_getinfo($curl);

		//close cURL connection
		curl_close($curl);
		$curl = null;

		//if no error returned
		if($err == 0) {
			$StatusCode = null;
			$soapStatusCode = null;

			//use regular expression to match "StatusCode" - this will tell us if the cURL request was processed correctly or not.
			if( preg_match('#<StatusCode>([0-9]+)</StatusCode>#iU', $ret, $soapStatusCode) ) {
				$StatusCode = (int)$soapStatusCode[1];

				//Get the "Message" returned by the gateway
				if (preg_match('#<Message>(.+)</Message>#iU', $ret, $soapMessage)) {
					$Message = $soapMessage[1];
				} else {
					$Message = "Strange problem";
				}

				//request was processed correctly
				if( $StatusCode != 50 ) {
					//set success flag so it will not run the request again.
					$soapSuccess = true;

					//Check StatusCode - 0 = success
					switch ($StatusCode) {
						case 0:
							//echo returned message to page
							$RESPONSE['return']['message'] = $Message;
							//echo $Message;

							//Get the crossreference
							if (preg_match('#<TransactionOutputData CrossReference="(.+)">#iU', $ret, $soapMD)) {
								$CrossRef = $soapMD[1];
							} else {
								$CrossRef = "CrossReference Missing";
							}

							//echo to the page
							//echo "<br>" . $CrossRef;
							$RESPONSE['return']['CrossRef'] = $CrossRef;
							$RESPONSE['eror'] = 'false';

							break;

						default:
							$RESPONSE['eror'] = 'true';
							//echo "An error has occurred: " . $Message;
							$RESPONSE['return']['message'] =  $Message;
							break;
					}
				}
			}
		}

		//increment the transaction attempt if <=2
		if($transattempt <=2) {
			$transattempt++;
		} else {
			//reset transaction attempt to 1 & increment $gwID (to use next numeric gateway number (eg. use gw2 rather than gw1 now))
			$transattempt = 1;
			$gwId++;
		}
	}
	//$RESPONSE['messagexml'] = $xml;
	return $RESPONSE;
}
?>