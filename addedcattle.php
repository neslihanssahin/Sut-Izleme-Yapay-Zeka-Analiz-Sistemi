<?php
require_once "sidebar.php";
// Başlangıç mesajı
$message = "";

// Form submit edildiğinde
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $kupeNo = $_POST['kupeNo'];
    $rfidNo = $_POST['rfidNo'];
    $takmaIsim = $_POST['takmaIsim'];
    $dogumTarihi = $_POST['dogumTarihi'];
    $yas = $_POST['yas'];

    // Veritabanına ekleme sorgusu
    $sql = "INSERT INTO cattle (earTagNumber, RFIDNumber, nickname, dateOfBirth, age) VALUES (:earTagNumber, :RFIDNumber, :nickname, :dateOfBirth, :age)";

    // Sorguyu hazırla
    $stmt = $pdo->prepare($sql);

    // Değişkenleri bağla
    $stmt->bindParam(':earTagNumber', $kupeNo);
    $stmt->bindParam(':RFIDNumber', $rfidNo);
    $stmt->bindParam(':nickname', $takmaIsim);
    $stmt->bindParam(':dateOfBirth', $dogumTarihi);
    $stmt->bindParam(':age', $yas);

    // Sorguyu çalıştır
    if ($stmt->execute()) {
        $message = "Başarıyla eklendi."; // Başarı mesajı
    } else {
        $message = "Ekleme sırasında bir hata oluştu."; // Hata mesajı
    }
}

// Bütün hayvanları listele (en son eklenenden başlayarak)
$sql = "SELECT * FROM cattle ORDER BY id DESC";
$stmt = $pdo->query($sql);
$cattleList = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Tür listesini al
$typeSql = "SELECT id, type_name FROM type "; // Corrected column name
$typeStmt = $pdo->query($typeSql);
$typeList = $typeStmt->fetchAll(PDO::FETCH_ASSOC);
// Tür listesini bir lookup array'e dönüştür
$typeLookup = [];
foreach ($typeList as $type) {
    $typeLookup[$type['id']] = $type['type_name'];
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        ._container {
            max-width: 800px;
            margin: 150px auto;

        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            /* Tablo başlıkları bold olsun */
            text-align: center;
            /* Tablo başlıkları ortalanmış olsun */
        }

        .form-container {
            max-width: 600px;
            margin: 20px auto;
            border: 1px solid #000;
            padding: 20px;
            border-radius: 5px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 10px;
        }

        .form-row label {
            width: 150px;
            text-align: right;
            padding-right: 10px;
        }

        .form-row input,
        .form-row select {
            flex: 1;
            padding: 5px;
            margin: 5px;
            box-sizing: border-box;
        }

        .form-row input[type="submit"] {
            width: auto;
            margin-left: 160px;
            /* Label'in genişliği kadar sağa kaydır */
        }

        .form-title {
            text-align: center;
            font-weight: bold;
        }
    </style>
    <title>Hayvan Ekleme</title>
</head>

<body>
    <div class="_container">
        <h2 class="form-title">Hayvan Bilgi Formu</h2>
        <div class="form-container">
            <form action="submit.php" method="POST">
                <div class="form-row">
                    <label for="kupeNo">Küpe No:</label>
                    <input type="text" id="kupeNo" name="kupeNo" required>
                </div>
                <div class="form-row">
                    <label for="rfidNo">RFID No:</label>
                    <input type="text" id="rfidNo" name="rfidNo" required>
                </div>
                <div class="form-row">
                    <label for="takmaIsim">Takma İsim:</label>
                    <input type="text" id="takmaIsim" name="takmaIsim" required>
                </div>
                <div class="form-row">
                    <label for="dogumTarihi">Doğum Tarihi:</label>
                    <input type="date" id="dogumTarihi" name="dogumTarihi" required>
                </div>
                <div class="form-row">
                    <label for="yas">Yaş:</label>
                    <input type="number" id="yas" name="yas">
                </div>
                <div class="form-row">
                    <label for="typeId">Irk:</label>
                    <select id="typeId" name="typeId" required>
                    <option>Seçiniz</option>

                        <?php foreach ($typeList as $type) : ?>

                            <option value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-row">
                    <input type="submit" value="EKLE">
                </div>
            </form>
        </div>

        <h2>Hayvan Listesi</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Sıra No</th>
                    <th scope="col">Sarı Küpe No</th>
                    <th scope="col">RFID No</th>
                    <th scope="col">Takma Ad</th>
                    <th scope="col">Doğum Tarihi</th>
                    <th scope="col">Yaş</th>
                    <th scope="col">Irk</th>
                </tr>
            </thead>

            <?php
            if (count($cattleList) > 0) {
                foreach ($cattleList as $cattle) {
                    echo "<tr>";
                    echo "<td>" . $cattle['id'] . "</td>";
                    echo "<td>" . $cattle['earTagNumber'] . "</td>";
                    echo "<td>" . $cattle['RFIDNumber'] . "</td>";
                    echo "<td>" . $cattle['nickname'] . "</td>";
                    echo "<td>" . $cattle['dateOfBirth'] . "</td>";
                    echo "<td>" . $cattle['age'] . "</td>";
                    echo "<td>" . (isset($typeLookup[$cattle['type_id']]) ? $typeLookup[$cattle['type_id']] : 'Bilinmiyor') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No cattle found in the table.</td></tr>";
            }
            ?>
        </table>

        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
            <script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 3000); // 3 saniye sonra yönlendir
            </script>
        <?php endif; ?>
    </div>
</body>

</html>