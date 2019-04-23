<?php

function add_monday_user(array $findResult, string $subscribeUrl, array $opts)
{
	$json = $findResult['found'] === true
		? '{"members":["%s"],"make_admin":false}'
		: '{"members":[{"email":"%s","kind":"guest"}],"make_admin":false}';

	$opts['http']['content'] = sprintf($json, $findResult['user']);

	$content = file_get_contents($subscribeUrl, null, stream_context_create($opts));

	$user = $findResult['email'];

	if (strpos($content, 'user_exists_with_wrong_type') !== false)
	{
		echo "User '$user' already exists as another type!\n";
		return;
	}

	if ($content === '{}')
	{
		$existing = $user === $findResult['user']
			? ' existing '
			: ' ';

		echo "Sent an e-mail to$existing'$user'!\n";
		return;
	}

	fwrite(STDERR, "Something went wrong with adding '$user'! Content: $content\n");
}
