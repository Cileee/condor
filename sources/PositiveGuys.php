<?php

class PositiveGuys extends BaseSource
{
	private static $databaseConfig = [
		'host' => 'localhost',
		'database' => 'condor',
		'username' => 'root',
		'password' => '',
	];

	public static function getStatistics(string $host) : float
	{
		try {
			// $data = self::getFromDB(self::$databaseConfig, $host);
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
