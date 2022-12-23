<?php

class GoogleAnalytics extends BaseSource
{
	private static $url = "https://test.com";
	private static $method = "POST";

	public static function getStatistics(string $host) : float
	{
		// $data['target'] = $host;
		try {
			// $rawData = self::getFromExternalSource(self::$url, self::$method, $data);
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
