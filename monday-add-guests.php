<?php

require __DIR__ . '/func/get_csrf.php';
require __DIR__ . '/func/add_monday_user.php';

$config = 'config.local.php';
if (! file_exists(__DIR__ . '/' . $config))
{
	fwrite(STDERR, "Can't find `$config` file!\n");
	exit(1);
}

$config = require $config;

$company = $config['company'];
$boardId = $config['board_id'];

$rootDomain = "$company.monday.com";
$baseUrl = "https://$rootDomain";
$boardUrl = "$baseUrl/boards/$boardId";
$subscribeUrl = "$baseUrl/projects/$boardId/subscribers";

$cookie = 'Cookie: ' . $config['cookie'];

$opts = [
	'http' => [
		'header' => $cookie,
	],
];

$csrf = get_csrf($boardUrl, $opts);

$opts['http']['method'] = 'POST';

$userAgent = 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.183 Safari/537.36 Vivaldi/1.96.1147.36';
$opts['http']['header'] .= "\r\nAccept: application/json, text/javascript, */*; q=0.01\r\nContent-Type: application/json; charset=UTF-8";
$opts['http']['header'] .= "\r\nX-Csrf-Token: $csrf\r\nReferer: $boardUrl\r\nOrigin: $baseUrl\r\nAuthority: $rootDomain";
$opts['http']['header'] .= "\r\nAccept-Language: en-US,en;q=0.9\r\nX-Requested-With: XMLHttpRequest\r\nUser-Agent: $userAgent";

$file = 'userlist';
if (! file_exists($file))
{
	fwrite(STDERR, "Can't find `$file` file!\n");
	exit(1);
}

$users = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($users as $user)
{
	add_monday_user($user, $subscribeUrl, $opts);
}
