<?php
switch ($_GET["f"])
{
    case "json":
        header('Content-type: application/json');
        echo "{\"ip\":\"" . $_SERVER["HTTP_X_FORWARDED_FOR"] . "\"}";
        break;
    case "xml":
        header('Content-type: application/xml');
        echo "<ip>" . $_SERVER["HTTP_X_FORWARDED_FOR"] . "</ip>";
        break;
    default:
        header('Content-type: text/text');
        echo $_SERVER["HTTP_X_FORWARDED_FOR"]; // I use HTTP_X_FORWARDED_FOR Instead of REMOTE_ADDR in case of a reverse proxy.
}
// By Goncermor
?>
