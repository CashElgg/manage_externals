<?php

$urls = elgg_get_external_js();
foreach ($urls as $url) {
	echo "<script type=\"text/javascript\" src=\"$url\"></script>\n";
}
