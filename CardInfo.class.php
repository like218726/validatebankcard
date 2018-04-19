<?php

class CardInfo {
	
	public $list;
	public function __construct(){
		require_once 'BankList.class.php';
		$this->list = new BankList();
	}
	
	/**
	 * 
	 * 获取银行卡信息
	 * @param unknown_type $var
	 * @return array
	 * 
	 */
	function getbankinfo($var){
		$url = "https://ccdcapi.alipay.com/validateAndCacheCardInfo.json?_input_charset=utf-8&cardNo=";  
	    $url .=$var;  
	    $url .="&cardBinCheck=true"; 
	    $curl_data = $this->curl_request($url);
	    $curl_data = json_decode($curl_data,true); 
	    $cardtype = $this->card_type();	    
	    $bank_name = $this->list->Banklist()[substr($var,0,6)];
		preg_match('/([\d]{4})([\d]{4})([\d]{4})([\d]{4})([\d]{0,})?/', $var,$match);  	  
		unset($match[0]);  
	    $print_data = array(
	    	'bank_beati_card' => implode(' ', $match),
	    	'bank_card' => $var,
	    	'bank_code' => $curl_data['bank'],
	    	'bank_name' => $bank_name,
	    	'bank_type' => $cardtype[$curl_data['cardType']],
	    	'bank_img' => 'https://apimg.alipay.com/combo.png?d=cashier&t='.$curl_data['bank'],
	    ); 
	    return $print_data; 
	}

	/**
	 * 
	 * @action: 银行卡类型: 借记卡,贷记卡
	 * @return Array
	 * 
	 */
	public function card_type(){
		return array(
			'DC' => '借记卡',
			'CC' => '贷记卡'
		);
	}

	/**
	 * 
	 * 打印数据
	 * @param unknown_type $var
	 */
	function debug($var){
		echo '变量:$var <xmp>'.var_export($var,true).'</xmp><hr/>';
	}	
	
	/**
	 * 
	 * @action 接口查询
	 * @param unknown_type $url
	 * @param unknown_type $post
	 * @param unknown_type $cookie
	 * @param unknown_type $returnCookie
	 */
	function curl_request($url,$post='',$cookie='', $returnCookie=0){
         $curl = curl_init();
         curl_setopt($curl, CURLOPT_URL, $url);
         curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
         curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
         curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
         curl_setopt($curl, CURLOPT_REFERER, "http://XXX");
         if($post) {
             curl_setopt($curl, CURLOPT_POST, 1);
             curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post));
         }
         if($cookie) {
             curl_setopt($curl, CURLOPT_COOKIE, $cookie);
         }
         curl_setopt($curl, CURLOPT_HEADER, $returnCookie);
         curl_setopt($curl, CURLOPT_TIMEOUT, 10);
         curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
         curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
         $data = curl_exec($curl);
         if (curl_errno($curl)) { echo $url;
             return curl_error($curl);
         }
         curl_close($curl);
         if($returnCookie){
             list($header, $body) = explode("\r\n\r\n", $data, 2);
             preg_match_all("/Set\-Cookie:([^;]*);/", $header, $matches);
             $info['cookie']  = substr($matches[1][0], 1);
             $info['content'] = $body;
             return $info;
         }else{
             return $data;
         }
	}	
}