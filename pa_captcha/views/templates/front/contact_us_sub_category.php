<?php
include("/opt/lampstack-5.6.29-1/apache2/htdocs/shop/config/settings.inc.php");
$conn = mysqli_connect('_DB_SERVER_','_DB_NAME_','_DB_USER_','_DB_PASSWD_');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 }
 
 $sql = 'SELECT c.id_reason,c.id_parent,c.reason FROM ' . _DB_PREFIX_ .'fc_farmer_shipment_reject c where c.id_parent<>0 and  c.complaint_category="PG" and c.id_lang=1 and id_parent= '.$_POST("reasonid");
 
 var_dump($sql);
 die();
 $result = mysqli_query($conn,$sql);
 $output = "";
 $output ='<option value="">-- Choose --</option>';
 
 while($row = mysqli_fetch_array($result));
 {
	$output .= '<option value="'.$row["id_reason"].'">'.$row["reason"].'</option>';
 }
 
 echo $output;
?>