<?php
// PayPal's notification (This program is in the billing page)

header('HTTP/1.1 200 OK');

// Create the response we need to send back to PayPal for them to confirm that it's legit

$resp = 'cmd=_notify-validate';
foreach ($_POST as $parm => $var) 
	{
	$var = urlencode(stripslashes($var));
	$resp .= "&$parm=$var";
	}
	
// Extract the data PayPal IPN has sent us, into local variables 

$item_name = $_POST['item_name1'];
$payment_status = $_POST['payment_status'];

$purchase = explode("_", $item_name, 2);
$item = $purchase[0];
$playerid = $purchase[1];
 
// Get the HTTP header into a variable and send back the data we received so that PayPal can confirm it's genuine

$httphead = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$httphead .= "Content-Type: application/x-www-form-urlencoded\r\n";
$httphead .= "Content-Length: " . strlen($resp) . "\r\n\r\n";
 
 // Now create a ="file handle" for writing to a URL to paypal.com on Port 443 (the IPN port)

$errno ='';
$errstr='';
 
$fh = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);

// Now send the data back to PayPal so it can tell us if the IPN notification was genuine
 
 if (!$fh) {
 
// Uh oh. This means that we have not been able to get thru to the PayPal server.  It's an HTTP failure
 } 
		   
// Connection opened, so spit back the response and get PayPal's view whether it was an authentic notification		   
		   
else {
           fputs ($fh, $httphead . $resp);
		   while (!feof($fh))
		{
			$readresp = fgets ($fh, 1024);
			if ($payment_status == "Completed") 
			{
			   //Success! The purchase was validated. Let's send the post vars to the BillingSuccess.php only once.
			   $payment_status = "Paid_Once"; //the code will no longer loop the database update
				
				//send the item and playerid to the billingsuccess php page
				$url = 'http://www.syncedonline.com:8080/BillingSuccess.php';
				$myvars = 'item=' . $item . '&playerid=' . $playerid;

				$ch = curl_init( $url );
				curl_setopt( $ch, CURLOPT_POST, 1);
				curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
				curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
				curl_setopt( $ch, CURLOPT_HEADER, 0);
				curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

				$response = curl_exec( $ch );

			} else if (strcmp ($readresp, "INVALID") == 0) 
			{
				//Failed attempt, or we're done with updating the database.
				
			}
		}
fclose ($fh);
		}
?>
