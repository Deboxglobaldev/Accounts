<?php
function OpenCon()
{
 $constring="host=controlserver.postgres.database.azure.com port=5432 dbname=db_accounts user=dbconnect@controlserver password=Debox#01";
 $conn = pg_connect($constring) ;
 return $conn;
}
?>
