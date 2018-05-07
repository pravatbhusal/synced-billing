<?php
// Connection Variables
$host        = "host=localhost";
$port        = "port=5432";
$dbname      = "dbname=msoy";
$credentials = "user=postgres password=zFEdPQS6DD";
$current_time = strtotime("now");

// Open database
$dbConnection = pg_connect( "$host $port $dbname $credentials"  );
if(!$dbConnection){
  echo "Error : Unable to open database.\n";
} else {
  echo "Opened database successfully.\n";
}

// Get all expired subscribers, and remove their subscription
$queryExpired = 'SELECT * FROM "BarscriptionRecord" WHERE now() >= expires';
$result = pg_query($dbConnection, $queryExpired);
while($row = pg_fetch_assoc($result)) {
	$memberId = $row['memberId'];
	$queryUpdateFlags = 'UPDATE "MemberRecord" set flags = 256 WHERE "memberId"='.$memberId.'';
	pg_query($dbConnection, $queryUpdateFlags);
	$queryRemoveSubscriber = 'DELETE FROM "BarscriptionRecord" WHERE "memberId"='.$memberId.'';
	pg_query($dbConnection, $queryRemoveSubscriber);
}

pg_close($dbConnection); //close the database
?>
