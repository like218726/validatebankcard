<?php
require_once 'CardInfo.class.php';
//6221 6822 8696 8909			16
//6221682286968909 				16
//6227003324560223723 			19
//6227 0033 2456 0223 723 		19

$bankcart = str_replace(" ", "", trim($_POST['bankcard']));
if(preg_match("/^\d*$/",$bankcart)) {
	if (!in_array(strlen($bankcart), array('16','19'))) {
		echo json_encode(array('code'=>'403','msg'=>'卡号不是16位或者19位'));
	} else {
		$cardinfo = new cardinfo();		
		$card = $cardinfo->getbankinfo($bankcart);
		echo json_encode(array('code'=>'200','msg'=>'成功','data'=>$card));			
	}	
} else {
	echo json_encode(array('code'=>'404','msg'=>'卡号不是数字'));
}  



