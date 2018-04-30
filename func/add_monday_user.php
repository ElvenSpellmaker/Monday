<?php

function add_monday_user(string $user, string $subscribeUrl, array $opts)
{
	static $json = '{"members":[{"email":"%s","kind":"guest"}],"make_admin":false}';
	$user = strtolower($user);

	$opts['http']['content'] = sprintf($json, $user);

	$content = file_get_contents($subscribeUrl, null, stream_context_create($opts));

	if (strpos($content, 'user_exists_with_wrong_type') !== false)
	{
		echo "User '$user' already exists as another type!\n";
		return;
	}

	if (preg_match("%{\"$user\":\d+}%", $content))
	{
		echo "Sent an e-mail to '$user'!\n";
		return;
	}

	fwrite(STDERR, "Something went wrong with adding '$user'! Content: $content\n");
}
