<?php

$data = array('email_penerima' => "vulnwalker@getnada.com" , 'subjek_email' => "sub jek email", "body_email" => "ini body email"  );
$curl = curl_init('http://admin.saudagarkaya.com/sendEmail.php') ;
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($curl);


?>
