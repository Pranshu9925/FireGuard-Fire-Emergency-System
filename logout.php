<?php require_once 'config/config.php';
$_SESSION = [];
session_regenerate_id(true);
set_flash('You have been logged out.');
redirect('index.php');
