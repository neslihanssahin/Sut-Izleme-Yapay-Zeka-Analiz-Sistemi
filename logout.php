<?php
session_start(); // Oturumu başlat
session_unset(); // Oturum değişkenlerini temizle
session_destroy(); // Oturumu yok et
header("Location: loginPage.php"); // Giriş sayfasına yönlendir
exit;
?>
