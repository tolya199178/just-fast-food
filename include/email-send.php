<?php

$MSG = "";
$MSG_SUBJ = "";
include_once('functions.php');

function SENDMAIL($GET ,$CC) {
	global $obj;
	switch($GET['type']) {
		case 'verify-acct':
			$MSG = '<strong>Thank you for your interest in Just-FastFood.com. Your Account has been created </strong><br/><br/>';
			$MSG .= 'Please Follow This Link To Verify Your Email. <strong><a href="https://just-fastfood.com/?verify_email='.$GET['Verify_Code'].'">Verify My Email</a></strong><br/><br/>';
			$MSG .= '<br><strong>https://just-fastfood.com/?verify_email='.$GET['Verify_Code'].'</strong><br><br>';
			$MSG .= 'If link does not work, please copy and paste this address into your address bar';

			$MSG_SUBJ = "Verify Your Account";
		break;

		case 'new-user-reg-live':
			$MSG = '<strong>Thanks for visiting Just-FastFood.com. You will be notify when we go live!</strong><br/><br/>';

			$MSG_SUBJ = "Thanks for visiting";
		break;

		case 'upt-pass':
			$MSG = '<strong>Thank you for your interest in Just-FastFood.com.</strong><br/><br/>';
			$MSG .= 'Please Follow This Link To Update Your Password. <strong><a href="http://just-fastfood.com/forgot-password.php?vcode='.$GET['vcode'].'">http://just-fastfood.com/'.$GET['link'].'.php?vcode='.$GET['vcode'].'</a></strong><br/><br/>';
			$MSG .= 'If Link Does Not Work Please Copy And Paste This Link to Your Address Bar';

			$MSG_SUBJ = "Update Your Password";
		break;

    case 'driver_email':

      $MSG = 'Full Name: <strong> '.$GET['drv_name'].'</strong><br/>';
      $MSG .= 'Email Address: <strong> '.$GET['drv_email'].'</strong><br/>';
      $MSG .= 'Mobile Number: <strong> '.$GET['drv_no'].'</strong><br/>';
      $MSG .= 'Drivers Location: <strong> '.$GET['drv_location'].'</strong><br/>';
      $MSG .= 'Vehicle type: <strong> '.$GET['drv_vehicle'].'</strong><br/>';
      $MSG .= 'Reffered By: <strong> '.$GET['drv_referred'].'</strong><br/>';
      $MSG .= 'Additional Information: <strong> '.$GET['drv_details'].'</strong><br/>';

      $MSG_SUBJ = "A New Driver Application";

    break;

        case 'corporate_user':
            $MSG  = '<html><body>';
            $MSG .= '<style>';
            $MSG .= 'body {
                         font-family:"Roboto", sans-serif !important;
                     }
                     .metahead {
                         color: #FFF;
                         font-size: 36px;
                         letter-spacing: 0.07em;
                         line-height: 46px;
                         padding: 0.4em;
                         text-align: center;
                         text-transform: uppercase;
                         text-rendering: optimizelegibility;
                         background:#333;
                     }
                     .informer {
                         border:2px solid #333;
                         padding: 10px;
                     }';
            $MSG .= '</style>';
            $MSG .= '<div>
                     <img src="https://just-fastfood.com/images/logo2.png" class="img-responsive" alt="food delivery" />
                     <div class="metahead">Welcome</div>
                     <div class="informer">
                         <p>Thank you for signing up for your corporate account. Please see your login information below</p>';
            $MSG  .=    '<p>Username: '. $GET['co_email'] . '</p>';
            $MSG  .=    '<p>Password: '. $GET['co_password'] . '</p>';            
            $MSG  .= '</div>';
            $MSG  .= '</body></html>';
            $MSG_SUBJ = "Your Just-FastFood Corporate Account";

            break;

    case 'admin_corporate_user':
      $MSG  = '<html><body>';
      $MSG .= '<style>';
      $MSG .= 'body {
                         font-family:"Lato", sans-serif !important;
                     }
                     .metahead {
                         color: #FFF;
                         font-size: 36px;
                         letter-spacing: 0.07em;
                         line-height: 46px;
                         padding: 0.4em;
                         text-align: center;
                         text-transform: uppercase;
                         text-rendering: optimizelegibility;
                         background:#333;
                     }
                     .informer {
                         border:2px solid #333;
                         padding: 10px;
                     }';
      $MSG .= '</style>';
      $MSG .= '<div>
                     <img src="https://just-fastfood.com/images/logo2.png" class="img-responsive" alt="food delivery" />
                     <div class="metahead">Welcome</div>
                     <div class="informer">
                         <p>Thank you for signing up for your corporate account. Please see your login information below</p>';
      $MSG  .=    '<p>Company name: '. strtoupper($GET['co_company_name']) . '</p>';
      $MSG  .=    '<p>Full name: '. $GET['co_full_name'] . '</p>';
      $MSG  .=    '<p>Job Title: '. $GET['co_job_title'].'</p>';
      $MSG  .=    '<p>Address: '. $GET['co_address'].'</p>';
      $MSG  .=    '<p>City: '. $GET['co_city'].'</p>';
      $MSG  .=    '<p>No Of Employee: '. $GET['co_employee_no'].'</p>';
      $MSG  .=    '<p>Email Address: '. $GET['co_email_addy'].'</p>';

      $MSG  .= '</div>';
      $MSG  .= '</body></html>';
      $MSG_SUBJ = $GET['co_company_name']. " Signed Up - Just-FastFood ";

      break;

		case 'order_complete_error':
			$MSG = '<strong>An Error occurred in Order Completion!</strong><br/>';
			$MSG .= 'Details Below<br/><br/>';
			foreach($GET['details'] as $name => $detail) {
				$MSG .= $name . ' : '. urldecode($detail).'<br/>';
			}
			$MSG_SUBJ = "Error in Order Completion";
			break;

		case 'refund_email':

			$MSG = '<strong>Please find Refund Status Details Below:</strong><br/>';
			$MSG .= 'ERROR : '.$GET['details']['eror'].'<br><br>';
			foreach($GET['details']['return'] as $name => $detail) {
				$MSG .= $name . ' : '. urldecode($detail).'<br/>';
			}

			$MSG_SUBJ = "Refund Status Order id : ".$GET['order_id'];

			break;

		case 'new_order_takeaway':
			$MSG = 'A New Order Received From <strong>'.$GET['user_name'].'</strong><br/><br/>';

			$order_type = json_decode($GET['order_delivery_type'] ,true);

			$MSG .= '<h2>Order Type:'.$order_type['type'].' '.$order_type['time'].'</h2>';
			$MSG .= 'Email : <strong>'.$GET['user_email'].'</strong><br/>';
			$MSG .= 'Order ID : <strong style="color:#D62725">'.$GET['order_id'].'</strong><br/>';
			$MSG .= 'Transaction ID : <strong>'.$GET['order_transaction_id'].'</strong><br/>';
			$MSG .= 'Post Code : <strong>'.strtoupper(key(json_decode($GET['order_postcode'], true))).'</strong><br/>';
			$MSG .= 'Address : <strong>'.$GET['order_address'].'</strong><br/>';
			$MSG .= 'Order Note : <strong style="color:#D62725">'.$GET['order_note'].'</strong><br/>';
			$MSG .= 'Phone No : <strong>'.$GET['order_phoneno'].'</strong><br/>';
            $MSG .= 'To Be Delivered: <strong>'.$order_type['time'].'</strong><br/><br/>';

			$Array = json_decode($GET['order_details'] ,true);

			$MSG .= 'Total Items : <strong>'.(count($Array) -1).'</strong><br/>';
			$MSG .= 'Orderd List Below: <br/>';

			$MSG .= '<div>';

			foreach($Array as $key => $val) {
				if($key != 'TOTAL') {
					$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 2px;">';
					$MSG .= '<span>'.$val['QTY'].' x '.$val['NAME'].'  (&pound;'.number_format($val['TOTAL'],2).')</span>';
					$MSG .= '</p>';
				}
			}

			$MSG .= '</div>';
			$MSG .= 'Please see SMS or go to your profile to Confirm or Cancel This Order ASAP<br/>';

			$MSG_SUBJ = "New Order Alert";
			break;

		case 'new_order_staff':
			$MSG = 'A New Order For <strong>'.$GET['type_name'].'</strong><br/><br/>';

			$MSG .= 'Order ID : <strong style="color:#D62725">'.$GET['order_id'].'</strong><br/>';
			$MSG .= 'Post Code : <strong>'.strtoupper(key(json_decode($GET['order_postcode'], true))).'</strong><br/>';
            $MSG .= (is_user_corporate($_SESSION['userId']) == 'true' ? ". Company Order ." : "");
			$MSG .= 'Address : <strong>'.$GET['order_address'].'</strong><br/>';
			$MSG .= 'Order Note : <strong style="color:#D62725">'.$GET['order_note'].'</strong><br/>';
			$MSG .= 'Phone No : <strong>'. $GET['order_phoneno'].'</strong><br/>';
            $MSG .= 'Transaction ID : <strong>'.$GET['order_transaction_id'].'</strong><br/>';
            $MSG .= 'Payment Type: <strong>'.$GET['order_payment_type'].'</strong><br/>';
            $MSG .= 'Order Arrival Time: <strong>'.$GET['order_arrival_time'].'</strong><br/><br/>';

			$Array = json_decode($GET['order_details'] ,true);

			$MSG .= 'Total Items : <strong>'.(count($Array) -1).'</strong><br/>';
			$MSG .= 'Ordered List Below: <br/><br/>';

			$MSG .= '<div>';

			foreach($Array as $key => $val) {
				if($key != 'TOTAL') {
					$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 2px;">';
					$MSG .= '<span>'.$val['QTY'].' x '.$val['NAME'].'.</span>';
					$MSG .= '</p>';
				}
			}

			$MSG .= '</div>';
			$MSG .= 'Please see SMS or go to your profile to Confirm or Cancel This Order ASAP<br/>';

			$MSG_SUBJ = "New Order Alert";
			break;

		case 'new_order_user':

			$Array = json_decode($GET['order_details'] ,true);
			$MSG_SUBJ = "Thanks for your order!";

			$value1 = $obj->query_db("SELECT `type_name`,`type_phoneno` FROM `menu_type` WHERE `type_id` = '" . $GET['order_rest_id'] . "'");
			$restaurant = $obj->fetch_db_assoc($value1);

			$MSG = '
					<!DOCTYPE HTML>
					<html lang="en-US">
					<head>
						<meta charset="UTF-8">
						<title>Order Email</title>
					</head>
					<body>
					<table cellspacing="8" cellpadding="5" width="100%">
						<tbody>
							<tr>
								<td align="center">
									<table border="0" cellspacing="0" cellpadding="0" width="600">
										<tbody>
											<tr>
												<td style="WIDTH:600px" align="center">
													<table style="border-right:#cccccc 2px solid;border-bottom:#cccccc 2px solid;border-top:#cccccc 2px solid;border-left:#cccccc 2px solid"
													border="0" cellspacing="0" cellpadding="0" width="600">
														<tbody>
															<tr>
																<td style="MARGIN-TOP:10px;WIDTH:600px;PADDING-TOP:10px" align="center">
																	<div style="TEXT-ALIGN:center">
																		<a rel="nofollow">
																			<img border="0" alt="Just-FastFood.com" src="http://just-fastfood.com/email-images/logo.png" width="580" height="100">
																		</a>
																	</div>
																</td>
															</tr>
															<tr>
																<td style="PADDING-RIGHT:12px;FONT-FAMILY:Arial;FONT-SIZE:12px;FONT-WEIGHT:bold;MARGIN-RIGHT:12px;PADDING-TOP:5px"
																align="right">'.date('d/m/Y').'</td>
															</tr>
															<tr>
																<td>
																	<hr>
																</td>
															</tr>
															<tr>
																<td style="PADDING-BOTTOM:20px;PADDING-LEFT:10px;FONT-FAMILY:Arial;MARGIN-LEFT:10px;FONT-SIZE:12px;PADDING-TOP:10px"
																valign="top" align="left">
																	<div>
																		<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																		width="600">
																			<tbody>
																				<tr>
																					<td style="">
																						<table align="left" border="0" cellpadding="0" cellspacing="0" style="width: 600px;">
																							<tbody>
																								<tr>

																									<td align="right">
																										<a href="https://www.facebook.com/pages/Just-FastFood/475488035817059" target="_blank" title="Just-FastFood on Facebook"><img src="http://just-fastfood.com/email-images/icon-social-facebook.png" alt=""></a>
																										<a href="" target="_blank" title="Just-FastFood on Twiter"><img src="http://just-fastfood.com/email-images/icon-social-twitter.png" alt=""></a>
																										<a href="" target="_blank" title="Just-FastFood on Google Plus"><img src="http://just-fastfood.com/email-images/icon-social-googleplus.png" alt=""></a>
																										<a href="/blog" target="_blank" title="Just-FastFood Blog"><img src="http://just-fastfood.com/email-images/social-blog.png" alt=""></a>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td style="" height="110" width="600">
																						<a href="" rel="nofollow" target="_blank">
																							<img style="DISPLAY:block" border="0" name="" alt="Thank you for your order" src="http://just-fastfood.com/email-images/Thanks.png" width="600" height="110">
																						</a>
																					</td>
																				</tr>
																				<tr>
																					<td style="">
																						<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																						width="600" align="left">
																							<tbody>
																								<tr>
																									<td height="104" width="267">
																										<a href="http://just-fastfood.com/chat/client.php" rel="nofollow" target="_blank">
																											<img style="DISPLAY:block" border="0" name="" alt="Need help? Live chat" src="http://just-fastfood.com/email-images/Live.png" width="241" height="104">
																										</a>
																									</td>
																									<td>
																										<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																										width="333" align="left">
																											<tbody>
																												<tr>
																													<td height="65" width="333">
																														<img style="DISPLAY:block" border="0" name=""
																														alt="Last minute changes or need to contact the restaurant?" src="http://just-fastfood.com/email-images/LastMin.gif"
																														width="333" height="65">
																													</td>
																												</tr>

																											</tbody>
																										</table>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td style="" height="21" width="600"></td>
																				</tr>
																				<tr>
																					<td style="">
																						<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																						width="600" align="left">
																							<tbody>
																								<tr>
																									<td height="49" width="49"></td>
																									<td height="49" width="464"><span style="FONT-FAMILY:Tahoma,Geneva,sans-serif;COLOR:rgb(153,153,153);FONT-SIZE:15px"></span>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td style="" height="48" width="600">
																						<hr width="600"/>
																					</td>
																				</tr>
																				<tr>
																					<td style="">
																						<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																						width="600" align="left">
																							<tbody>
																								<tr>
																									<td height="38" width="205"></td>
																									<td height="38" width="188">
																										<img style="DISPLAY:block" border="0" name=""
																										alt="Your order" src="http://just-fastfood.com/email-images/urorder.gif"
																										width="188" height="38">
																									</td>
																									<td height="38" width="207"></td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td style="">
																						<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																						width="600" align="left">
																							<tbody>
																								<tr>
																									<td height="80" width="18"></td>
																									<td height="80" valign="middle" width="582">
																										<table style="DISPLAY:inline-table" border="0" cellspacing="0" cellpadding="0"
																										width="582" align="left">
																											<tbody>
																												<tr>
																													<td width="582">
																														<span style="FONT-FAMILY:Tahoma;COLOR:rgb(153,153,153);FONT-SIZE:12pt;FONT-WEIGHT:bold">
																															<div>
																																<table width="600">
																																	<tbody>
																																		<tr>
																																			<td style="LINE-HEIGHT:20px" valign="top"><font size="2">'. $restaurant['type_name'].'</font>
																																			</td>
																																			<td align="right">&nbsp;</td>
																																		</tr>
																																		<tr>
																																			<td style="LINE-HEIGHT:16px" colspan="2">
																																				<br>Order no.<b style="color:#D62725"> '. $GET['order_id'] .'</b>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td style="LINE-HEIGHT:16px">
																																				<br>Transaction no. <b style="color:#D62725">'. $GET['order_transaction_id'] .'</b>
																																			</td>
																																		</tr>
																																	</tbody>
																																</table>
																																<table width="600">
																																	<tbody>
																																		<tr>
																																			<td align="center">Pcs.</td>
																																			<td style="LINE-HEIGHT:16px">Name</td>
																																			<td>Description</td>
																																			<td align="center">Unit Price</td>
																																			<td width="50" nowrap="" align="right">Total</td>
																																		</tr>
																																		<tr>
																																			<td colspan="5">
																																				<hr size="1" width="600" noshade="">
																																			</td>
																																		</tr>
																																		';
																																			$item_total = 0;
																																			foreach($Array as $key => $val) {
																																				if($key != 'TOTAL') {
																																					$value = $obj->query_db("SELECT `item_details` FROM `items` WHERE `item_id` = '" . $val['ID'] . "'");
																																					$item_details = $obj->fetch_db_assoc($value);
																																					$item_total += $val['TOTAL'];

																																					$MSG .= '<tr>
																																						<td valign="top" align="center"><font size="3"><strong>'. $val['QTY'] .'</strong></font></td>
																																						<td valign="top" width="200"><font size="2">X <b>'. $val['NAME'] .'</b></font></td>
																																						<td style="LINE-HEIGHT:17px" width="185"><font size="2"><b>'. $item_details['item_details'] .'</b> - </font></td>
																																						<td width="85" nowrap="" align="right"><font size="2">&pound; '. number_format($val['TOTAL'] / $val['QTY'],2).'</font></td>
																																						<td nowrap="" align="right"><font size="2">&pound; '. number_format($val['TOTAL'],2).'</font></td>
																																					</tr>';
																																				}
																																			}
																																		$MSG .= '<tr>
																																			<td colspan="3"></td>
																																			<td style="LINE-HEIGHT:17px"><font size="2">Card fee: </font>
																																			</td>
																																			<!--<td align="right"><font size="2">&pound; '. process_fee() .'</font> -->
																																			</td>
																																		</tr>
																																		<tr>
																																			<td colspan="3"></td>
																																			<td style="LINE-HEIGHT:17px"><font size="2">Delivery price: </font>
																																			</td>
																																			<td align="right"><font size="2">&pound; '. number_format($GET['order_tatal'] - ($item_total + process_fee()), 2) .'</font>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td colspan="4">&nbsp;</td>
																																			<td align="right">
																																				<hr size="1" width="50">
																																			</td>
																																		</tr>
																																		<tr>
																																			<td colspan="3"></td>
																																			<td style="LINE-HEIGHT:17px"><b><font size="2">Total:</font></b>
																																			</td>
																																			<td nowrap="" align="right"><font size="2">&pound; '. number_format($GET['order_tatal'], 2).'</font>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td width="579" colspan="5">
																																				<hr size="1" noshade="">
																																			</td>
																																		</tr>
																																		<tr>
																																			<td valign="top" colspan="5"><b>Comments:</b>
																																				<br><b></b>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td style="LINE-HEIGHT:22px" valign="bottom" colspan="5">
																																				<br>Order arrival time: '.$GET['order_arrival_time'].';
																																				<br>Please note that changes in delivery time can occur.
																																				<br>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td colspan="5" align="left">
																																				<table width="600">
																																					<tbody>
																																						<tr>
																																							<td style="LINE-HEIGHT:18px" valign="bottom" width="200" colspan="3">
																																								<br>Delivery address:</td>
																																							<td style="LINE-HEIGHT:18px" valign="bottom" width="400"
																																							colspan="3" align="left">'. $GET['user_name'] .'</td>
																																						</tr>
																																						<tr>
																																							<td valign="bottom" colspan="3"></td>
																																							<td style="LINE-HEIGHT:18px" valign="bottom" width="400" colspan="3"
																																							align="left"><font size="4">'. $GET['order_address'] .' -</font>
																																							</td>
																																						</tr>
																																						<tr>
																																							<td valign="bottom" colspan="3"></td>
																																							<td style="LINE-HEIGHT:18px" valign="bottom" width="400" colspan="3"
																																							align="left">'. $GET['order_postcode'] .'</td>
																																						</tr>
																																						<tr>
																																							<td valign="bottom" colspan="3"></td>
																																							<td style="LINE-HEIGHT:18px" valign="bottom" width="400" colspan="3"
																																							align="left">'. $GET['user_phoneno'] .'</td>
																																						</tr>
																																					</tbody>
																																				</table>
																																			</td>
																																		</tr>
																																		<tr>
																																			<td style="LINE-HEIGHT:22px" valign="bottom" colspan="5">
																																				<br><b>THE ORDER IS PREPAID BY : '. strtoupper($GET['order_payment_type']).'<b><br></b></b>
																																			</td>
																																		</tr>
																																	</tbody>
																																</table>
																															</div>
																														</span>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																				<tr>
																					<td style="" height="161" width="600">
																						<a href="https://twitter.com/intent/tweet?status=I%27ve+just+joined+the+fight+against+the+tyranny+of+cooking+by+ordering+a+takeaway+or+fastfood+from+%40Just-FastFood&amp;url=http%3A%2F%2Fwww.just-eat.co.uk%2F"
																						rel="nofollow" target="_blank">
																							<img style="DISPLAY:block" border="0" name="" alt="Tweet your order" src="http://just-fastfood.com/email-images/Tweet.png" width="600" height="161">
																						</a>
																					</td>
																				</tr>
																				<tr>
																					<td>
																						<a href=""><img src="http://just-fastfood.com/email-images/invite.png" alt=""/></a>
																					</td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
					<div style="font-size:11px; font-family:arial"><a href="http://just-fastfood.com" title="Just-FastFood.com" style="color:#ccc">&copy; Just-FastFood.com</a></div>
					<div style="font-size:11px; font-family:arial; text-align:right">Powered By: <a href="http://just-fastfood.com" title="Powered By Just-Fastfood" style="color:#D62725">Just-Fastfood</a></div>


</body>
					</html>
					';
			$USER_ORDER_EMIAL = $MSG;
			/* $MSG = '<strong>Thanks for your order at Just-FastFood.com</strong><br/><br/>';
			$MSG .= 'Your Order Details:<br/><br/>';
			$MSG .= 'Order ID : <strong>'.$GET['order_id'].'</strong><br/>';
			$MSG .= 'Transaction ID : <strong>'.$GET['order_transaction_id'].'</strong><br/>';
			$MSG .= 'Payment Type : <strong>'.strtoupper($GET['order_payment_type']).'</strong><br/>';
			$MSG .= 'Name : <strong>'.$GET['user_name'].'</strong><br/>';
			$MSG .= 'Email : <strong>'.$GET['user_email'].'</strong><br/>';
			$MSG .= 'Post Code : <strong>'.$GET['order_postcode'].'</strong><br/>';
			$MSG .= 'Address : <strong>'.$GET['order_address'].'</strong><br/><br/>';
			$MSG .= 'Total Items : <strong>'.(count($Array) -1).'</strong><br/>';
			$MSG .= 'Orderd List Below: <br/>';

			$MSG .= '<div style="margin:10px; px">';

			foreach($Array as $key => $val) {
				if($key != 'TOTAL') {
					$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 2px;">';
					/* foreach($val as $k => $v) {
						if($k == 'TOTAL') {
							$MSG .= '<span style=" padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.':  &pound; '.number_format($v, 2).'</span>';
						} else {
							$MSG .= '<span style="display: block; padding: 0px 5px 0px 5px; margin:0px; font-size: 12px;">'.$k.' :  '.$v.'</span>';
						}
					}//
					$MSG .= '<span>'.$val['QTY'].' x '.$val['NAME'].'  (&pound;'.number_format($val['TOTAL'],2).')</span>';
					$MSG .= '</p>';
				}

			}

			$MSG .= '</div>';
			$MSG .= 'Total Amount : <strong>&pound; '.number_format($GET['order_tatal'], 2).'</strong><br/><br/>';
			$MSG .= '<strong>Your Order is on the way.</strong><br/>'; */

			break;

		case 'cancel_order_user':
			$MSG = '<strong>Please Accept Our Apologies! Your order cannot be processed at the moment, as a result It has been cancelled.<br> <br></strong><br/><br/>';
			$MSG .= 'Our delivery drivers are currently busy fulfilling orders.<br/>';
			$MSG .= 'Please try again in a little while<br/><br/>';
			$MSG .= '<strong>Your payment will be fully refunded. If you do not receive your payment please contact our live chat or email support@just-fastfood.com</strong><br/>';
			$MSG .= '<strong>Your order ID : '.$GET['order_id'].'</strong><br/>';
			$MSG .= '<strong>Total order amount : &pound;'.number_format($GET['order_tatal'], 2).'</strong><br/>';
			$MSG .= '<strong>Payment Type : '.$GET['order_payment_type'].'</strong><br/>';

			$MSG_SUBJ = "Order cancelled!";
			break;

		case 'new-feedback':
			$MSG = 'A New Feedback Received From <strong>Just-Fastfood &lt;'.$GET['user_email'].'&gt;</strong><br/><br/>';
			$MSG .= '<p style="border: 1px dotted #DDDDDD; padding: 5px; font-family: Georgia; ">'.$GET['feedback'].'</p>';

			$MSG_SUBJ = "New Feedback received";
			break;

		case 'new-user-reg':
			$MSG = 'A New User Registered <strong>Just-FastFood &lt;'.$GET['user_email'].'&gt;</strong><br/>';
			$MSG .= 'Post Code : <strong>'.$GET['user_postcode'].'</strong><br/>';

			$MSG_SUBJ = "New User Registered";
			break;

		case 'new-join_rest':
			$MSG = '<strong>Thank you for your interest in Just-FastFood.</strong><br/><br/>';
			$MSG .= 'You want to add a new restaurant Name: <strong>'.$GET['rest_name'].'</strong> , Phone No: <strong>'.$GET['phone_no'].'</strong> and Post Code : <strong>'.$GET['post_code'].'</strong> at Just-FastFood<br/><br/>';
			$MSG .= '<strong>Your Application is being reviewed by the Sales Manager. Once reviewed, you will be contacted soon. As a restaurant owner, you will be able to add your own menus, categories and items.</strong><br/><br/>';
			$MSG .= '<p style="font-size:11px; font-family:Verdana; padding:0px; text-align:right; margin:0px;">* Please Note: All Restaurant and menu`s are UK only.</p>';

			$MSG_SUBJ = "New Restaurant";
			break;

		case 'new-join_rest-admin':
			$MSG = '<strong>'.$GET['user_name'].'Wants To Add a new Restaurant Name: <strong>'.$GET['rest_name'].'</strong> and Post Code : <strong>'.$GET['post_code'].'</strong>.</strong><br/><br/>';
			$MSG .= '<p style="font-size:11px; font-family:Verdana; padding:0px; margin:0px;">Please go to admin and see details.</p>';

			$MSG_SUBJ = $GET['user_name'].'Wants to add New Restaurant';
			break;
	}


	if($MSG == "") {
		return false;
	}

	$message = '
	<!DOCTYPE HTML>
	<html lang="en-US">
	<head>
		<meta charset="UTF-8">
		<title>Just-FastFood.com | Email</title>
		<style type="text/css">
			a{
				color: #363636;
				text-decoration: underline;
			}
			a:hover{
				color:#D62725;
			}
		</style>
	</head>
	<body>
		<div class="wrapper" style="padding:15px; border:1px solid #ddd; margin:20px; font-family:Verdana;">
			<div>
				<h1 style="font: bolder 30px Rockwell,Tahoma,Arial,sans-serif; padding-bottom: 10px; margin:0px; padding:0px; color:#D62725;" title="Just-FastFood.com">Just-FastFood</h1>
				<span style="font-size:11px; font-family:Verdana; font-style:italic">Order Your Favourite Fast Food & Takeaways Online</span>
				<p style="font-size:11px; font-family:Verdana; padding:0px; text-align:right; margin:0px;">* You have received this from <a href="http://just-fastfood.com">Just-FastFood.com</a></p>
			</div>
			<hr style="height:1px; background:#ddd; margin:10px;"/>
			<div>
				<div style="font-size:13px; font-family:Verdana; margin:5px; padding:10px;">'.$MSG.'</div>
			</div>
			<hr style="height:1px; background:#ddd; margin:10px;"/>
			<div>
				<p style="font-size:12px; font-family:arial; padding-bottom:10px; color:#bbb">&copy; Just-FastFood.com</p>
				<p style="font-size:10px; font-family:verdana; padding:0px; margin:0px; color:#bbb; text-align:right;font-style:italic">Proudly Powered By : <a href="http://just-fastfood.com">Just-FastFood</a></p>
				<p style="font-size:10px; font-family:verdana; padding:0px; margin:0px; color:#bbb; text-align:center;font-style:italic">Design & Develop By : <a href="http://just-fastfood.com">Just-FastFood</a></p>
			</div>
		</div>
    </body>
	</html>
	';
	//echo $message;

	$to = $GET['email'];
	$subject = $MSG_SUBJ;

	$headers = "From:Just-FastFood <info@just-fastfood.com>\r\n";
	$headers .= 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	if($CC) {
		$headers .= "Cc:Admin Just-FastFood <".admin_email().">\r\n";
	}

	if(mail($to, $subject, $message, $headers, '-finfo@just-fastfood.com'))
		return true;
	else
		return false;
    /*
     * Acceptance time is enclosed in here
     */
    //&nbsp;<b><font size="4">'. date('h:i A F d, Y' ,strtotime($GET['order_acceptence_time']) + 45*60).'</font></b>
}
?>