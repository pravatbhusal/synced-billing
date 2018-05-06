CLIENT-SIDE DEMO (NO SERVER-SIDE IMPLEMENTATION): https://shadowsych.github.io/synced-billing/billing.html

This is the billing system programmed by Pravat Bhusal (www.github.com/Shadowsych) 
for Richard Fraser. This code may be given to anyone to study and use as his or her
billing service for their Whirled server. However, proper set-up must
be completed for the billing files. For this reason, I have provided step-by-step
documentation below to properly set-up the billing system.

Documentation:
1. Copy and paste the "billing.html" file into your Whirled's "pages" folder.
2. Copy and paste the "BillingSuccess.php" file into the "htdocs" folder of an Apache web-server.
3. Open the "BillingIPN.php" file and on line 57 replace the "http://www.syncedonline.com:8080/BillingSuccess.php"
with the URL for your "BillingSuccess.php" file from step 2.
4. Now copy and paste the "BillingIPN.php" in a new Apache web-server that runs on port 80.
5. Now we're going to set-up the PayPal IPN, so go to this link and click the "Update" button on the "Instant payment notifications" row:
"https://www.paypal.com/uk/cgi-bin/webscr?cmd=_profile-display-handler&tab_id=SELLER_PREFERENCES"
6. Set the "Notification URL" to the URL of your "BillingIPN.php" file.
7. Tick the "receive IPN messages (Enabled)" checkbox and press the "Save" button.
8. You are finished setting-up the PayPal IPN!

-----------------------------------------------------------------------------------------------
NOTE: Here are the different Apache web-servers you can install based on your operating system
- Windows Apache Server: XAMPP
- Mac Apache Server: MAMP
- Linux Apache Server: LAMP

NOTE: If you're using a Linux server and PostgreSQL, make sure to install the PHP and PostgreSQL driver:
```
sudo apt-get install php5-pgsql
```

NOTE: You need a PayPal Premier or PayPal Business account for the IPN system to work.

NOTE: You can read more about the PayPal IPN integration system here: 
"https://developer.paypal.com/docs/classic/products/instant-payment-notification/"
