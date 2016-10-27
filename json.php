<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


$host = 'localhost';
$user = 'shemul';
$pass = '';
$db = 'gsb';

  
    
$mysqli = new mysqli($host,$user,$pass,$db) or die('died'); 


$search = $_GET['search'];


if (isset($search))
{

	$query = "SELECT * from user_detail where uid = '$search' ";
} else {
	$query = "SELECT * from user_detail";

}




$json = array();



$result = $mysqli->query($query) or die($mysqli->error.__LINE.__);

//$json[] = $search ;

if($result->num_rows > 0)
{
	while ($row =$result->fetch_assoc()) {
		# code...
		$json[] = $row;

	}
}

echo json_encode(array('events' => $json),JSON_PRETTY_PRINT);

?>
