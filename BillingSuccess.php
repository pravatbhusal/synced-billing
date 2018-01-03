<?php

// Connection Variables
$host        = "host=DATABASEHOSTHERE";
$port        = "port=DATABASEPORTHERE";
$dbname      = "dbname=DATABASENAMEHERE";
$credentials = "user=USERHERE password=PASSWORDHERE";
$current_time = strtotime("now");
$sql = "";
   
// Open database
$db = pg_connect( "$host $port $dbname $credentials"  );
if(!$db){
  echo "Error : Unable to open database.\n";
} else {
  echo "Opened database successfully.\n";
}

$item = mysql_real_escape_string(stripslashes($_POST['item']));
$playerid = mysql_real_escape_string(stripslashes($_POST['playerid']));
$barAmount = "";
$monthAmount = "";

//check if the purchase was either bars or for subscription months, then set the values
if (strpos($item, "bars") !== false) {
	$barAmount = chop($barAmount, "bars");
} else if (strpos($item, "month") !== false) {
	$monthAmount = chop($monthAmount, "month");
	$monthAmount = "+" . $monthAmount . " month";
}	
		
if(strpos($item, "bars") !== false)
{
      $sql =<<<EOF
      UPDATE "MemberAccountRecord" set bars = bars + $barAmount where "memberId"=$playerid;
EOF;
} else if (strpos($item, "month") !== false)
{
   $subscribe_time = date("Y-m-d", strtotime($monthAmount, $current_time));
   
   $sql =<<<EOF
      INSERT INTO "BarscriptionRecord" ("memberId",expires) VALUES ($playerid, '$subscribe_time');
      UPDATE "MemberRecord" set flags = 4096 where "memberId"=$playerid;
	  UPDATE "MemberAccountRecord" set bars = bars + 10 where "memberId"=$playerid;
EOF;
}
				
//Update the sql database
$ret = pg_query($db, $sql);
if(!$ret){
echo pg_last_error($db);
exit;
} else {
echo "Record updated successfully\n";
}
		
pg_close($db); //close the database
?>