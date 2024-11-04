<?php
ob_start();
require_once "sidebar.php";

if (isset($_POST['delete'])) {
    // Handle the form submission to update death date, reason, and delete the record
    $id = $_POST['id'];
    $deathDate = $_POST['death_date'];
    $deathReason = $_POST['death_reason'];

    try {
        $pdo->beginTransaction();

        // Update the record with death date and reason
        $updateSql = "UPDATE cattle SET death_date = :death_date, explanation = :deathReason WHERE id = :id";
        $updateStmt = $pdo->prepare($updateSql);
        $updateStmt->bindParam(':death_date', $deathDate, PDO::PARAM_STR);
        $updateStmt->bindParam(':deathReason', $deathReason, PDO::PARAM_STR);
        $updateStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $updateStmt->execute();

        $pdo->commit();
        header("Location: cattlegrid.php");
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Failed: " . $e->getMessage();
    }
}

// ID parametresini kontrol etme
if (isset($_GET['id']) && !empty($_GET['id'])) {
    // ID parametresi varsa ve boş değilse, hayvanın bilgilerini veritabanından çekme
    $id = $_GET['id'];

    $sql = "SELECT * FROM cattle WHERE id = :id ";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $onecattle = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$onecattle) {
        echo "Hayvan bulunamadı.";
        header("refresh:3;url=index.php"); // 3 saniye sonra index.php sayfasına yönlendir
        exit;
    }
} else {
    echo "Geçersiz ID.";
    header("refresh:3;url=index.php"); // 3 saniye sonra index.php sayfasına yönlendir
    exit;
}

// Bütün hayvanları listele (en son eklenenden başlayarak)
$sql = "SELECT * FROM cattle WHERE death_date IS NOT NULL ORDER BY id DESC";
$stmt = $pdo->query($sql);
$cattleList = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Yaşı hesaplayan fonksiyon
function calculateAge($birthDate)
{
    $birthDate = new DateTime($birthDate);
    $currentDate = new DateTime();
    $age = $currentDate->diff($birthDate);
    return $age->y;
}

?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .deathinfo .input-group {
            margin: 10px;
        }

        .deathinfo .form-control {
            height: 120px;
            width: 500px;
            margin-top: 10px;
        }

        .deathinfo .input-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .deathinfo .input-group input[type="date"] {
            margin-top: 10px;
            width: 250px;
        }

        .form-row input[type="submit"] {
            width: 250px;
            padding: 10px;
            border-radius: 50px;
            margin-top: 15px;
            margin-left: 150px;
            border-color: red;
            background: red;
            color: white;
            font-weight: bold;
        }

        .photo {
            margin-top: 10px;
            overflow: hidden;
            width: 250px;
            height: 250px;
        }

        .photo img {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 150px;">
        <div class="row">
            <div class="col">
                <div class="card mb-3" style="max-width:700px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <div class="photo">
                                <?php if (!empty($onecattle['photo'])) : ?>
                                    <img src="<?php echo $onecattle['photo']; ?>" alt="" style=" margin-top:25px;margin-left:10px">
                                <?php else : ?>
                                    <img src="assets/img/photo/photo.png" alt="" style=" margin-top:25px;margin-left:10px">
                                <?php endif; ?>
                            </div>

                        </div>
                        <div class="col-md-8">
                            <div class="card-body"  style="margin-left:50px;">
                                <h5 class="card-title">Hayvan Bilgi Kartı</h5>
                                <div class="card" style="width: 18rem;">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Küpe No:</strong> <?php echo $onecattle['ear_tag_number']; ?></li>
                                        <li class="list-group-item"><strong>RFID No:</strong> <?php echo $onecattle['rfid_number']; ?></li>
                                        <li class="list-group-item"><strong>Takma Ad:</strong> <?php echo $onecattle['nick_name']; ?></li>
                                        <li class="list-group-item"><strong>Doğum Tarihi:</strong> <?php echo $onecattle['date_of_birth']; ?></li>
                                        <li class="list-group-item"><strong>Yaş:</strong> <?php echo calculateAge($onecattle['date_of_birth']); ?></li>
                                        <li class="list-group-item"><strong>Annesinin Küpe No:</strong> <?php echo $onecattle['mother_tag_number']; ?></li>
                                        <li class="list-group-item"><strong>Babasınnın Küpe No:</strong> <?php echo $onecattle['father_tag_number']; ?></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mb-3" style="max-width: 600px;">
                    <div class="row g-0">
                        <div class="col-md-8">
                            <div class="deathinfo">
                                <div class="card-body">
                                    <h5 class="card-title">Ölüm Raporu</h5>
                                    <form method="POST" action="">
                                        <div class="input-group">
                                            <span class="input-group-text">Ölüm Sebebi</span>
                                            <textarea class="form-control" name="death_reason" aria-label="With textarea" required></textarea>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-text">Ölüm Tarihi</span>
                                            <input type="date" id="death_date" name="death_date" style="margin:10px;" required>
                                        </div>
                                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                                        <div class="form-row">
                                            <input type="submit" name="delete" value="SİL">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h2>Ölen Hayvanların Listesi</h2>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Sarı Küpe No:</th>
                            <th scope="col">RFID No</th>
                            <th scope="col">Takma Ad</th>
                            <th scope="col">Yaş</th>
                            <th scope="col">Ölüm Tarihi</th>
                            <th scope="col">Ölüm Sebebi</th>
                        </tr>
                    </thead>
                    <?php
                    if (count($cattleList) > 0) {
                        foreach ($cattleList as $cattle) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($cattle['ear_tag_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($cattle['rfid_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($cattle['nick_name']) . "</td>";
                            echo "<td>" . htmlspecialchars(calculateAge($cattle['date_of_birth'])) . "</td>";
                            if (!empty($cattle['death_date'])) {
                                echo "<td>" . htmlspecialchars(date('Y-m-d', strtotime($cattle['death_date']))) . "</td>";
                            } else {
                                echo "<td></td>";
                            }
                            echo "<td>" . htmlspecialchars($cattle['explanation']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>Ölen Hayvan Bulunamadı.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>