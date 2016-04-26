#!/usr/bin/php
<?php
echo "\n{$_SERVER['argc']} arguments received. They are...\n";
foreach ($_SERVER['argv'] as $k => $v) {
	echo "$k: $v\n";
}
?>
