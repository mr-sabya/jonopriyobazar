<?php

namespace App;

class SendCode{

	public static function sendCode($phone){
		$token = "e561cfabf58cfd91717aed1671dac984";
		$code = rand(1111, 9999);
		$to = $phone;
		$message = "Your verify code from Jonopriyobazar is ".$code." for ".$phone.". Use it ASAP.";
		$url = "http://api.greenweb.com.bd/api.php";

		$data = array(
			'to'=> $to,
			'message'=> $message,
			'token'=> $token
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_ENCODING, '');
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		$smsresult = curl_exec($ch);
		$result = mb_substr($smsresult, 0, 2);

		if ($result == 'Ok') {
			return $code;
		}else{
			return "error";
		}
	}

}

?>