<?php
require_once "functions.php";
if (!isset($_POST['logout'])) {
    goToPage('index.php');
} else {
    session_start();
    session_destroy();
    goToPage('index.php');
}
