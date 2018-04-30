<?php

function get_csrf(string $boardUrl, array $opts)
{
	$ctx = stream_context_create($opts);
	libxml_set_streams_context($ctx);

	$dom = new DOMDocument;
	@$dom->loadHtmlFile($boardUrl);

	$xpath = new DOMXPath($dom);
	$csrfNode = $xpath->query('/html/head/meta[@name="csrf-token"][1]');

	if ($csrfNode === null || ! count($csrfNode))
	{
		fwrite(STDERR, 'Failed to get the CSRF token! Is the cookie set?');
		exit(1);
	}

	$csrf = $csrfNode[0]->getAttribute('content');

	return $csrf;
}
