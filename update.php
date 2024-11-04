<?php
require_once "sidebar.php";

// ID parametresini kontrol etme
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // ID parametresi varsa ve boş değilse, hayvanın bilgilerini veritabanından çekme
    $id = $_GET['id'];
    $sql = "SELECT * FROM cattle WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $cattle = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Form gönderilmiş mi kontrol etme
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $id = $_POST['id'];
    $ear_tag_number = $_POST['ear_tag_number'];
    $rfid_number = $_POST['rfid_number'];
    $nick_name = $_POST['nick_name'];
    $date_of_birth = $_POST['date_of_birth'];

    // Dosya yükleme işlemleri
    if (!empty($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        // Dosya yükleme kontrolleri
        $img_dir = __DIR__ . "/assets/img/photo";
        if (!is_dir($img_dir)) {
            mkdir($img_dir, 0777, true);
        }

        $pathinfo = pathinfo($_FILES["photo"]["name"]);
        $base = $pathinfo["filename"];
        $base = preg_replace("/[^\w-]/", "_", $base);
        $filename = $base . "." . $pathinfo["extension"];

        $destination = $img_dir . "/" . $filename;

        // Dosya varsa taşı
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $destination)) {
            $image_url = "assets/img/photo/" . $filename;
        } else {
            exit("Yüklenen dosya taşınamadı.");
        }
    } else {
        $image_url = $cattle['photo']; // Eğer dosya yüklenmediyse eski fotoğraf yolunu kullan
    }

    // Veritabanında ilgili kaydı güncelle
    $sql = "UPDATE cattle 
            SET ear_tag_number = :ear_tag_number, 
                rfid_number = :rfid_number, 
                nick_name = :nick_name, 
                date_of_birth = :date_of_birth,
                photo = :photo
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ear_tag_number', $ear_tag_number, PDO::PARAM_STR);
    $stmt->bindParam(':rfid_number', $rfid_number, PDO::PARAM_STR);
    $stmt->bindParam(':nick_name', $nick_name, PDO::PARAM_STR);
    $stmt->bindParam(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
    $stmt->bindParam(':photo', $image_url, PDO::PARAM_STR); // Doğru değişkeni kullanın
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Başarılı güncelleme durumunda cattlelist.php sayfasına yönlendir
        header("Location: cattlelist.php?success=1");
        exit();
    } else {
        // Güncelleme başarısız olduğunda hata mesajı göster
        echo "Güncelleme işlemi sırasında bir hata oluştu.";
    }
}

// Veritabanından verileri al
$typesql = "SELECT type_name FROM type;";
$typeresult = $pdo->query($typesql);
$typedata = array();

while ($row = $typeresult->fetch(PDO::FETCH_ASSOC)) {
    $typedata[] = $row; // Tür verilerini diziye ekliyoruz
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Güncelleme Sayfası</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .photo {
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
            width: 250px;
            height: 250px;
        }

        .photo img {
            width: 100%;
            height: 100%;
        }
    </style>
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('photoPreview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</head>

<body>
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh; padding: 10px;">
        <?php if (isset($_GET['success']) && $_GET['success'] == 1) : ?>
            <p class="success-message">Güncelleme başarıyla gerçekleştirildi!</p>
        <?php endif; ?>

        <div class="photo" style="padding: 20px;">
            <?php if (!empty($cattle['photo'])) : ?>
                <img id="photoPreview" src="<?php echo $cattle['photo']; ?>" alt="Cattle Photo">
            <?php else : ?>
                <img id="photoPreview" style="display:none;" alt="Cattle Photo">
                <p id="noPhotoMessage">Fotoğraf bulunamadı.</p>
            <?php endif; ?>
        </div>

        <div class="form" style="padding: 20px; margin-top: 50px;">
            <h2>Güncelleme Sayfası</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $cattle['id']; ?>">
                <label for="ear_tag_number">Sarı Küpe No:</label>
                <input type="text" id="ear_tag_number" name="ear_tag_number" value="<?php echo $cattle['ear_tag_number']; ?>">

                <label for="rfid_number">RFID No:</label>
                <input type="text" id="rfid_number" name="rfid_number" value="<?php echo $cattle['rfid_number']; ?>">

                <label for="nick_name">Takma Ad:</label>
                <input type="text" id="nick_name" name="nick_name" value="<?php echo $cattle['nick_name']; ?>">

                <label for="date_of_birth">Doğum Tarihi:</label>
                <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo $cattle['date_of_birth']; ?>">

                <label for="photo">Fotoğraf:</label>
                <input type="file" id="photo" name="photo" onchange="previewImage(event)">

                <input type="submit" value="Güncelle">
            </form>
        </div>
    </div>
</body>

</html>
