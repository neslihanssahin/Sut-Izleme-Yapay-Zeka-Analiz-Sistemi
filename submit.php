<?php
// Veritabanı bağlantısını yapılandırma
require_once "database.php";

// Formdan gelen verileri al
$kupeNo = $_POST['kupeNo'];
$rfidNo = $_POST['rfidNo'];
$takmaIsim = $_POST['takmaIsim'];
$dogumTarihi = $_POST['dogumTarihi'];

try {
    // Veritabanına ekleme sorgusu
    $sql = "INSERT INTO cattle (ear_tag_number, rfid_number, nick_name, date_of_birth) VALUES (:ear_tag_number, :rfid_number, :nick_name, :dateOfBirth)";

    // Sorguyu hazırla
    $stmt = $pdo->prepare($sql);

    // Değişkenleri sorguya bağla
    $stmt->bindParam(':ear_tag_number', $kupeNo);
    $stmt->bindParam(':rfid_number', $rfidNo);
    $stmt->bindParam(':nick_name', $takmaIsim);
    $stmt->bindParam(':date_of_birth', $dogumTarihi);

    // Sorguyu çalıştır
    $stmt->execute();

    // Başarılı mesajı
    $message = "Veri başarıyla eklendi.";
} catch (PDOException $e) {
    // Hata durumunda hata mesajı
    $message = "Veri eklenirken bir hata oluştu: " . $e->getMessage();
}

// Başarılı veya hata mesajıyla birlikte addedCattle.php sayfasına yönlendirme yap
header("Location: addedCattle.php?message=" . urlencode($message));
exit; // Sayfadan çıkış yap
?>
