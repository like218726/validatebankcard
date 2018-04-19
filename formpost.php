<?php
require_once 'CardInfo.class.php';
$cardinfo = new cardinfo();
$bankcart = str_replace(" ", "", trim($_POST['bankcard']));

$card = $cardinfo->getbankinfo($bankcart);
echo json_encode(array('code'=>'200','msg'=>'成功','data'=>$card));


