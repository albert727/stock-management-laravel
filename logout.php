<?php
session_start();

// Menghapus sesi login
session_destroy();

// Redirect ke halaman login
header('Location: login.php');
exit;
?>
