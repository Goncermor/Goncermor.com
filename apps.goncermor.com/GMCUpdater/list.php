<?php

header('Content-Type:text/plain');

$mods = array();

$mods_lite = array();

foreach (array_diff(scandir("mods/"), array('.', '..')) as &$value) {
    array_push($mods, $value);
}

foreach (array_diff(scandir("lite/"), array('.', '..')) as &$value) {
    array_push($mods_lite, $value);
}

echo join("\n", $mods) . "\n\n" . join("\n", $mods_lite);

// By Goncermor
?>
