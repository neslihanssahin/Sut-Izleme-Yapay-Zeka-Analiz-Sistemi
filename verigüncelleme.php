<?php
require_once "sidebar.php";
// İsim listesini tanımlayın
$names = [
    "Akasya", "Alabaş", "Alacalı", "Alagöz", "Alainek", "Alakız", "Ay", "Ayışığı", "Aykız", "Ayna", "Aynalı",
    "Bağdagül", "Bahar", "Ballı", "Baydar", "Benek", "Benekli", "Benzer", "Bestel", "Beyaz", "Boran",
    "Boynuzlu", "Boziya", "Bozkız", "Bozo", "Ceylan", "Cicikız", "Cihan", "Cilveli", "Civcile", "Çiçek",
    "Çiçekli", "Çilli", "Çimen", "Cümbişli", "Defne", "Dilenci", "Elmalı", "Elmas", "Erik", "Farfara",
    "Fındık", "Gazel", "Geyik", "Hanımkız", "Hediye", "Işık", "Kadem", "Kader", "Kahve", "Karaca",
    "Karagöz", "Kırıkboynuz", "Kiraz", "Kömür", "Körkız", "Kulaksız", "Kuyruksuz", "Küpeli", "Latte"
];

// Rastgele 30 isim seç
$randomNames = array_rand(array_flip($names), 30);

// Güncellenecek kayıtların id'lerini alın
$sql = "SELECT id FROM cattle LIMIT 30";
$stmt = $pdo->query($sql);
$cattleIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

if(count($cattleIds) < 30) {
    die('Veritabanında yeterli kayıt yok.');
}

// Her bir id için rastgele bir isimle güncelleme yap
foreach ($cattleIds as $index => $id) {
    $newName = $randomNames[$index];
    $updateSql = "UPDATE cattle SET nick_name = :newName WHERE id = :id";
    $updateStmt = $pdo->prepare($updateSql);
    $updateStmt->execute([':newName' => $newName, ':id' => $id]);
}

echo "Kayıtlar başarıyla güncellendi.";
?>
