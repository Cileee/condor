<?php

abstract class BaseSource
{
	public static $conn = null;

	public static function getStatistics(string $url) : float {}

	public static function getFromExternalSource(string $url, string $method = "GET", array $data = []) : string
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		// Set the HTTP method and POST data if needed
		if ($method == "POST") {
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		}

		$output = curl_exec($ch);
		if ($output == false) {
			throw new Exception('CURL Error: ' . curl_error($ch));
		}

		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) >= 400) {
			throw new Exception('HTTP Error: ' . curl_error($ch));
		}

		curl_close($ch);

		return $output;
	}

	public static function getFromDB(array $databaseConfig, string $host) : int
	{
		// DB connection/fetch example
		$conn = self::getConnection($databaseConfig);
		$data = $conn->prepare(
			"SELECT SUM(`value`) AS totalValue
			FROM `statistics`
			WHERE `host` = :host
			AND `date` BETWEEN NOW() AND (NOW() - INTERVAL 30 DAY);"
		);
		$data->execute([ 'host' => $host ]);

		return (int)$data['totalValue'];
	}

	public static function getConnection(array $databaseConfig)
	{
		if (isset(self::$conn)) {
			return self::$conn;
		}
		return self::createConnection($databaseConfig);
	}

	private static function createConnection($databaseConfig)
	{
		try {
            self::$conn = new PDO("mysql:host=" . $databaseConfig['host'] . ";dbname=" . $databaseConfig['database'], $databaseConfig['username'], $databaseConfig['password']);
            self::$conn->exec("set names utf8");
		} catch (PDOException $e) {
			throw $e;
		}
		return self::$conn;
	}
}
