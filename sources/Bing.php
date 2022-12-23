<?php

class Bing extends BaseSource
{
	private static $url = "https://test.com?target=";
	private static $method = "GET";

	public static function getStatistics(string $host) : float
	{
		// $url .= $host;
		try {
			// $rawData = self::getFromExternalSource(self::$url, self::$method);
			// $data = json_decode($rawData, true);
		} catch (Exception $e) {
			// log error
			// send metrics
			return null;
		}
		$data = [
			'statistics' => '123.654'
		];
		return (float)$data['statistics'];
	}
}
