<?php
$dsn = "  ";
$dbusername = "kullanici_adi"; 
$dbpassword = "parola"; 

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "bağlantı başarılı";
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
