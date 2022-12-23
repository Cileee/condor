<?php

// Autoload the classes
spl_autoload_register(function ($class_name) {
    include __DIR__ . "/sources/{$class_name}.php";
});

$response = isset($_GET['response']) ? $_GET['response'] : 'json';
if (!in_array($response, ['json', 'xml'])) {
	printError('Invalid response type');
}
global $response;

$url = isset($_GET['url']) ? $_GET['url'] : null;
if (empty($url)) {
	printError('Empty url');
}
if (!filter_var($url, FILTER_VALIDATE_URL)) {
    printError('Invalid url');
}

$sources = [
	'GoogleAnalytics',
	'PositiveGuys',
	'Bing',
];

$data = [];
foreach ($sources as $source) {
	$value = call_user_func([$source, 'getStatistics'], $url);
	if (is_null($value)) {
		// error
		continue;
	}
	$data[$source] = $value;
}

$return_value = match($response) {
    'json' => [
		'error' => false,
		'message' => '',
		'data' => $data,
	],
    'xml' => 'we really hate XML :-D',
};
var_export($return_value);

function printError($msg)
{
	global $response;
	$return_value = match($response) {
		'json' => [
			'error' => true,
			'message' => $msg,
			'data' => [],
		],
		'xml' => 'we really hate XML :-D',
	};
	var_export($return_value);
	exit();
}
