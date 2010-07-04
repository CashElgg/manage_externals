<?php

$urls = elgg_get_external_css();
foreach ($urls as $url) {
	echo "<link rel=\"stylesheet\" href=\"$url\" type=\"text/css\" />\n";
}

