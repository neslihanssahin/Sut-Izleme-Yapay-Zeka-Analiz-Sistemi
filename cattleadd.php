<?php
// require_once "database.php";
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
    $annesininKupeNo = $_POST['annesininKupeNo'];
    $babasininKupeNo = $_POST['babasininKupeNo'];
    $annesininIrk = $_POST['annesininIrk'];
    $babasininIrk = $_POST['babasininIrk'];
    $typeId = $_POST['typeId'];

    // Dosya yükleme işlemleri
    if (!empty($_FILES['image'])) {
        // Dosya yükleme kontrolleri
        if ($_FILES["image"]["error"] !== UPLOAD_ERR_OK) {
            exit('Dosya yüklenirken bir hata oluştu.');
        }

        $img_dir = __DIR__ . "/assets/img/photo";
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true);
        }

        $pathinfo = pathinfo($_FILES["image"]["name"]);
        $base = $pathinfo["filename"];
        $base = preg_replace("/[^\w-]/", "_", $base);
        $filename = $base . "." . $pathinfo["extension"];

        $destination = $img_dir . "/" . $filename;

        // Dosya varsa taşı
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $destination)) {
            exit("Yüklenen dosya taşınamadı.");
        }

        $image_url = "assets/img/photo/" . $filename;
    } else {
        $image_url = null; // Eğer dosya yüklenmediyse null olarak ayarla
    }

    // Veritabanına ekleme sorgusu
    $sql = "INSERT INTO cattle (ear_tag_number, rfid_number, nick_name, date_of_birth, photo,type_id,mother_tag_number,mother_type_id,father_tag_number,father_type_id) 
            VALUES (:ear_tag_number, :rfid_number, :nick_name, :date_of_birth, :photo,:type_id,:mother_tag_number,:mother_type_id,:father_tag_number,:father_type_id)";

    // Sorguyu hazırla
    $stmt = $pdo->prepare($sql);

    // Değişkenleri bağla
    $stmt->bindParam(':ear_tag_number', $kupeNo);
    $stmt->bindParam(':rfid_number', $rfidNo);
    $stmt->bindParam(':nick_name', $takmaIsim);
    $stmt->bindParam(':date_of_birth', $dogumTarihi);
    $stmt->bindParam(':mother_tag_number', $annesininKupeNo);
    $stmt->bindParam(':father_tag_number', $babasininKupeNo);
    $stmt->bindParam(':mother_type_id', $annesininIrk);
    $stmt->bindParam(':father_type_id', $babasininIrk);
    $stmt->bindParam(':type_id', $typeId);
    $stmt->bindParam(':photo', $image_url, PDO::PARAM_STR);

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
// Bütün buzağıları listele (en son eklenenden başlayarak)
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
var_dump($typeLookup);
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
            text-align: center;
        }

        .form-container {
            width: 700px;
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
        }

        .form-title {
            text-align: center;
            font-weight: bold;
        }

        .img {
            margin: 25px;
        }

        .img img {
            max-width: 250px;
            /* Gerekirse resmin maksimum genişliğini ayarlayabilirsiniz */
            display: block;
            /* Resmi blok element olarak ayarlamak */
            margin: 0 auto;
            /* Resmi dikey olarak ortalamak için */
        }
    </style>
    <title>Hayvan Ekleme</title>
</head>

<body>
    <div class="_container">
        <h2 class="form-title">Hayvan Bilgi Formu</h2>
        <div class="add" style="display:flex; ">
            <div class="img">
                <img id="previewImage" src="" alt="Uploaded Image">
            </div>

            <div class="form-container">
                <form method="POST" enctype="multipart/form-data">
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
                        <label for="annesininIrk">Irk:</label>
                        <select id="annesininIrk" name="annesininIrk" required>
                            <option>Seçiniz</option>
                            <?php foreach ($typeList as $type) : ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="dogumTarihi">Doğum Tarihi:</label>
                        <input type="date" id="dogumTarihi" name="dogumTarihi" required>
                    </div>
                    <div class="form-row">
                        <label for="annesininKupeNo">Annesinin Küpe No:</label>
                        <input type="text" id="annesininKupeNo" name="annesininKupeNo" required>
                    </div>
                    <div class="form-row">
                        <label for="annesininIrk">Annesinin Irk:</label>
                        <select id="annesininIrk" name="annesininIrk" required>
                            <option>Seçiniz</option>
                            <?php foreach ($typeList as $type) : ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="babasininKupeNo">Babasının Küpe No:</label>
                        <input type="text" id="babasininKupeNo" name="babasininKupeNo" required>
                    </div>
                    <div class="form-row">
                        <label for="babasininIrk">Babasının Irk:</label>
                        <select id="babasininIrk" name="babasininIrk" required>
                            <option>Seçiniz</option>
                            <?php foreach ($typeList as $type) : ?>
                                <option value="<?php echo $type['id']; ?>"><?php echo $type['type_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <label for="image">Resim Dosyası:</label>
                        <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <div class="form-row">
                        <input type="submit" value="EKLE">
                    </div>
                </form>
            </div>
        </div>

        <h2>Cattle List</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Sarı Küpe NO</th>
                    <th scope="col">RFID No</th>
                    <th scope="col">Takma Ad</th>
                    <th scope="col">Doğum Tarihi</th>
                    <th scope="col">Tür</th>
                    <th scope="col">Annesinin Küpe No</th>
                    <th scope="col">Annesinin Irk</th>
                    <th scope="col">Babasının Küpe No</th>
                    <th scope="col">Babasının Irk</th>
                    <th scope="col">Fotoğraf</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($cattleList) > 0) {
                    foreach ($cattleList as $cattle) {
                        echo "<tr>";
                        echo "<td>" . $cattle['ear_tag_number'] . "</td>";
                        echo "<td>" . $cattle['rfid_number'] . "</td>";
                        echo "<td>" . $cattle['nick_name'] . "</td>";
                        echo "<td>" . $cattle['date_of_birth'] . "</td>";
                        echo "<td>" . (isset($typeLookup[$cattle['type_id']]) ? $typeLookup[$cattle['type_id']] : 'Bilinmiyor') . "</td>";
                        echo "<td>" . $cattle['mother_tag_number'] . "</td>";
                        echo "<td>" . (isset($typeLookup[$cattle['mother_type_id']]) ? $typeLookup[$cattle['mother_type_id']] : 'Bilinmiyor') . "</td>";
                        echo "<td>" . $cattle['father_tag_number'] . "</td>";
                        echo "<td>" . (isset($typeLookup[$cattle['father_type_id']]) ? $typeLookup[$cattle['father_type_id']] : 'Bilinmiyor') . "</td>";

                        echo "<td>";
                        if (!empty($cattle['photo'])) {
                            echo "<img src='" . $cattle['photo'] . "' alt='Cattle Photo' style='max-width: 100px;'>";
                        } else {
                            echo "<img src='assets/img/photo/photo.png' alt='Cattle Photo' style='max-width: 100px;'>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No cattle found in the table.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if (!empty($message)) : ?>
            <p><?php echo $message; ?></p>
            <script>
                setTimeout(function() {
                    window.location.href = "cattleadd.php";
                }, 3000); // 3 saniye sonra yönlendir
            </script>
        <?php endif; ?>

        <script>
            document.getElementById('image').addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        document.getElementById('previewImage').setAttribute('src', event.target.result);
                    }
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('previewImage').setAttribute('src', '');
                }
            });
        </script>
    </div>
</body>

</html>