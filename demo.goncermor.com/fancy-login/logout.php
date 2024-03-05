<?php
if (isset($_COOKIE['data'])) {
    unset($_COOKIE['data']); 
    setcookie('data', null, -1, '/'); 
}
header("Location: https://demo.goncermor.com/fancy-login/");
?>