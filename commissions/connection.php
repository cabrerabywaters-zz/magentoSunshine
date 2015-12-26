<?php

$con = mysqli_connect('104.207.236.202','sunshin4_cabrera','todovaletodovale','sunshin4_magento');
mysqli_set_charset($con, 'utf8'); 
$email = $_REQUEST['query'];

$query = "SELECT account_id as id, name, email as mail FROM affiliateplus_account where email like '%$email%' or name like  '%$email%' ";

function stripAccents($str) {
    return strtr(utf8_decode($str), utf8_decode('àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ'), 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');
}
$results = mysqli_query($con,$query);

	
			while($user = mysqli_fetch_object($results))
			{	
			    $data[] = stripAccents($user->name) ;
			}
//var_dump($data);
	
    echo json_encode($data);
?>