<?php

/**
 * Attempts to find a Monday.com user using their e-mail.
 *
 * @param string $user
 * @param string $searchUrl
 * @param string $boardId
 * @param array  $opts
 */
function find_monday_user(
	string $user,
	string $searchUrl,
	string $boardId,
	array $opts
) : array
{
	$user = strtolower($user);

	$queryString = [
		'project_id' => $boardId,
		'only_guests' => 'true',
		'without_guests' => 'false',
		'dont_consider_project' => 'true',
		'with_teams' => 'false',
		'term' => $user,
	];

	$searchUrl .= '?' . http_build_query($queryString);

	$opts['http']['method'] = 'GET';

	$content = file_get_contents($searchUrl, null, stream_context_create($opts));
	$content = json_decode($content, true);

	$findResult = [
		'user' => $user,
		'email' => $user,
		'found' => false,
	];

	foreach ($content['results'] as $result)
	{
		if ($result['email'] === $user)
		{
			$findResult['user'] = $result['id'];
			$findResult['found'] = true;
			break;
		}
	}

	return $findResult;
}
