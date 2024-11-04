<?php require_once "sidebar.php";

// SQL sorgusunda JOIN işlemi ekleniyor
$sql = "SELECT cattle.*, type.type_name AS type_name, mother_type.type_name AS mother_type_name, father_type.type_name AS father_type_name
        FROM cattle
        LEFT JOIN type ON cattle.type_id = type.id
        LEFT JOIN type AS mother_type ON cattle.mother_type_id = mother_type.id
        LEFT JOIN type AS father_type ON cattle.father_type_id = father_type.id
        ORDER BY cattle.id DESC";

$stmt = $pdo->query($sql);
$cattleList = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculateAge($dateOfBirth) {
    $dob = new DateTime($dateOfBirth);
    $today = new DateTime();
    $age = $today->diff($dob);
    return $age->y;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Çiftlikte Bulunan Hayvanların Listesi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        .edit-icon {
            color: blue;
            cursor: pointer;
        }

        .icon-container {
            display: flex;
            justify-content: flex-start;
            margin-right: 150px;
            margin-top: 20px;
        }

        .icon-container i {
            cursor: pointer;
            font-size: 36px;
            margin-left: 20px;
            transition: color 0.3s ease;
        }

        .icon-container i:hover {
            color: blue;
        }

        .fixed-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
        }

        .fixed-button button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .fixed-button button:hover {
            background-color: #0056b3;
        }

        .accordion-menu {
            display: none;
            position: absolute;
            bottom: 50px;
            right: 0;
            width: 200px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .accordion-content {
            padding: 10px;
        }

        .show-accordion {
            display: block;
        }

        .fixed-button {
            border-radius: 50px;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
    </style>
</head>

<body>
    <div class="container text-center" style="margin-top: 150px;">
        <div class="icon-container">
            <i class="ri-list-unordered" id="listView"></i>
            <i class="ri-grid-fill" id="gridView"></i>
        </div>
        <div class="row">
            <h2>Hayvanları Listeleme Sayfası</h2>
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Sarı Küpe No</th>
                        <th scope="col">RFID No</th>
                        <th scope="col">Takma Ad</th>
                        <th scope="col">Irk</th>
                        <th scope="col">Doğum Tarihi</th>
                        <th scope="col">Yaş</th>
                        <th scope="col">Annesini Takma Ad</th>
                        <th scope="col">Annesinin Irk</th>
                        <th scope="col">Babasının Takma Ad</th>
                        <th scope="col">Babasının Irk</th>
                        <th scope="col">Güncelle</th>
                        <th scope="col">Sil</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($cattleList) > 0) {
                        foreach ($cattleList as $cattle) {
                            $age = calculateAge($cattle['date_of_birth']);
                            echo "<tr>";
                            echo "<td>" . $cattle['ear_tag_number'] . "</td>";
                            echo "<td>" . $cattle['rfid_number'] . "</td>";
                            echo "<td>" . $cattle['nick_name'] . "</td>";
                            echo "<td>" . $cattle['type_name'] . "</td>";
                            echo "<td>" . $cattle['date_of_birth'] . "</td>";
                            echo "<td>" . $age . "</td>";
                            echo "<td>" . $cattle['mother_tag_number'] . "</td>";
                            echo "<td>" . $cattle['mother_type_name'] . "</td>";
                            echo "<td>" . $cattle['father_tag_number'] . "</td>";
                            echo "<td>" . $cattle['father_type_name'] . "</td>";
                            echo "<td><a href='update.php?id=" . $cattle['id'] . "'><i class='fas fa-edit edit-icon'></i></a></td>";
                            echo "<td><a href='delete.php?id=" . $cattle['id'] . "'><i class='ri-delete-bin-6-fill'></i></a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='12'>No cattle found in the table.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="fixed-button" id="toggleAccordion">
        <strong>+</strong>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#toggleAccordion").click(function() {
                window.location.href = 'cattleadd.php';
            });
            $('#listView').click(function() {
                window.location.href = 'cattlelist.php';
            });
            $('#gridView').click(function() {
                window.location.href = 'cattlegrid.php';
            });
        });
    </script>
</body>

</html>
