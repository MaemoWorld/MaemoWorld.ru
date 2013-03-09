<?php

// Return current timestamp (with microseconds) as a float
function forum_microtime()
{
    if (version_compare(PHP_VERSION, '5.0.0', '>='))
    {
	$mt = microtime(true);
    }
    else
    {
	list($usec, $sec) = explode(' ', microtime());
	$mt = ((float)/**/$usec + (float)/**/$sec);
    }

    return $mt;
}