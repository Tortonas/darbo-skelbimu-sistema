<?php
session_start();
foreach (glob("src/*.php") as $filename)
{
    include $filename;
}
$controller = new Controller();
$controller->logout();
$controller->redirect_to_another_page("index.php", 0);
?>