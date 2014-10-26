<?php

class Logging {
 
	public static function Info($logFile, $area, $functionName, $message, $jsonArray) {
		$errorString = sprintf("%s: - Info - Area: %s. Function Name: %s, User IP: %s Details: %s. Data: %s \r\n", 
								self::GetTimestamp(), $area, $functionName, self::GetVisitorIp(), $message, $jsonArray);
		error_log($errorString, 3, $logFile);
	}

	public static function Warn($logFile, $area, $functionName, $message, $jsonArray) {
		$errorString = sprintf("%s: - Warning - Area: %s. Function Name: %s, User IP: %s Details: %s. Data: %s \r\n", 
								self::GetTimestamp(), $area, $functionName, self::GetVisitorIp(), $message, $jsonArray);
		error_log($errorString, 3, $logFile);
	}

	public static function Error($logFile, $area, $functionName, $message, $jsonArray) {
	
		$errorString = sprintf("%s: - Error - Area: %s. Function Name: %s, User IP: %s Details: %s. Data: %s \r\n", 
								self::GetTimestamp(), $area, $functionName, self::GetVisitorIp(), $message, $jsonArray);
		
		error_log($errorString, 3, $logFile);
	}
	
	private static function GetTimestamp() {
		return date("d/m/Y - H:i:s");
	}
	
	private static function GetVisitorIp() {
		$ip = $_SERVER['REMOTE_ADDR'];
 
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
	 
		return $ip;
	}
}