
<?php
$mysql_server = 'localhost';
$mysql_login = 'root';
$mysql_password = '';
$mysql_database = 'db_jpos';


mysql_connect($mysql_server, $mysql_login, $mysql_password);
mysql_select_db($mysql_database);
mysql_query("SET NAMES utf8");  

$req = "SELECT product_name,product_id "
	."FROM tb_product "
	."WHERE product_name LIKE '%".$_REQUEST['term']."%' "; 

$query = mysql_query($req);

while($row = mysql_fetch_array($query))
{
	$results[] = array('id' => 1);
	$results[] = array('label' => $row['product_name']);
	
	//$results[] = array('value' => $row['product_name']);
}

echo json_encode($results);

?>